<?php
/**
 * Class ProposalController
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proposal;
use App\Job;
use App\Helper;
use App\Mail\EmailVerificationMailable;
use ZipArchive;
use App\User;
use App\Profile;
use Storage;
use Response;
use Auth;
use Carbon\Carbon;
use DB;
use App\Package;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\SiteManagement;
use App\Mail\EmployerEmailMailable;
use App\Mail\FreelancerEmailMailable;
use App\EmailTemplate;

/**
 * Class ProposalController
 *
 */
class ProposalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param instance $proposal instance
     *
     * @return void
     */
    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
        $email_settings = SiteManagement::getMetaValue('settings');
        if (!empty($email_settings[0]['email'])) {
            config(['mail.username' => $email_settings[0]['email']]);
        }
    }

    /**
     * View job proposal.
     *
     * @param int $job_slug jobslug
     *
     * @return \Illuminate\Http\Response
     */
    public function createProposal($job_slug)
    {
        if (!empty($job_slug)) {
            $job = Job::all()->where('slug', $job_slug)->first();
            $job_skills = $job->skills->pluck('id')->toArray();
            $check_skill_req = $this->proposal->getJobSkillRequirement($job_skills);
            $proposal_status = Job::find($job->id)->proposals()->where('status', 'hired')->first();
            $role_id =  Helper::getRoleByUserID(Auth::user()->id);
            $package_options = Package::select('options')->where('role_id', $role_id)->first();
            $options = !empty($package_options) ? unserialize($package_options['options']) : array();
            $settings = SiteManagement::getMetaValue('settings');
            $required_connects = !empty($settings[0]['connects_per_job']) ? $settings[0]['connects_per_job'] : 2;
            $remaining_proposals = !empty($options) ? $options['no_of_connects'] / $required_connects : 0;
            $submitted_proposals = $this->proposal::where('freelancer_id', Auth::user()->id)->count();
            $duration =  Helper::getJobDurationList($job->duration);
            $job_completion_time = Helper::getJobDurationList();
            $commision_amount = SiteManagement::getMetaValue('commision');
            $commision = !empty($commision_amount) ? $commision_amount[0]["commision"] : 0;
            return View(
                'front-end.jobs.proposal',
                compact(
                    'job',
                    'proposal_status',
                    'duration',
                    'job_completion_time',
                    'commision',
                    'check_skill_req',
                    'remaining_proposals',
                    'submitted_proposals'
                )
            );
        } else {
            abort(404);
        }
    }

    /**
     * Upload Image to temporary folder.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request)
    {
        if (!empty($request['file'])) {
            $attachments = $request['file'];
            $path = 'uploads/proposals/temp/';
            return Helper::uploadTempMultipleAttachments($attachments, $path);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request req attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()) {
            if (!empty($request)) {
                $json = array();
                $this->validate(
                    $request,
                    [
                        'amount' => 'required',
                        'completion_time'    => 'required',
                        'description'    => 'required',
                    ]
                );
                $job = Job::find($request['id']);
                if (intval($request['amount']) > $job->price) {
                    $json['type'] = 'error';
                    $json['message'] = 'Proposal amount must not exceed the job amount';
                    return $json;
                }
                $package = DB::table('items')->where('subscriber', Auth::user()->id)->select('product_id')->first();
                $proposals = $this->proposal::where('freelancer_id', Auth::user()->id)->count();
                $settings = SiteManagement::getMetaValue('settings');
                $required_connects = !empty($settings[0]['connects_per_job']) ? $settings[0]['connects_per_job'] : 2;
                if (!empty($package->product_id)) {
                    $package_options = Package::select('options')->where('id', $package->product_id)->get()->first();
                    $option = unserialize($package_options->options);
                    $allowed_proposals = $option['no_of_connects'] / $required_connects;
                    if ($proposals <= $allowed_proposals) {
                        $submit_propsal = $this->proposal->storeProposal($request, $request['id']);
                        if ($submit_propsal = 'success') {
                            $json['type'] = 'success';
                            $json['message'] = trans('lang.proposal_submitted');
                            $user = User::find(Auth::user()->id);
                            //send email
                            if (!empty($job->employer->email)) {
                                $email_params = array();
                                $proposal_received_template = DB::table('email_types')->select('id')->where('email_type', 'employer_email_proposal_received')->get()->first();
                                $proposal_submitted_template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_new_proposal_submitted')->get()->first();
                                if (!empty($proposal_received_template->id)
                                    || !empty($proposal_submitted_template->id)
                                ) {
                                    $template_data = EmailTemplate::getEmailTemplateByID($proposal_received_template->id);
                                    $template_submit_proposal = EmailTemplate::getEmailTemplateByID($proposal_submitted_template->id);
                                    $email_params['employer'] = Helper::getUserName($job->employer->id);
                                    $email_params['employer_profile'] = url('profile/' . $job->employer->slug);
                                    $email_params['freelancer'] = Helper::getUserName(Auth::user()->id);
                                    $email_params['freelancer_profile'] = url('profile/' . $user->slug);
                                    $email_params['title'] = $job->title;
                                    $email_params['link'] = url('job/' . $job->slug);
                                    $email_params['amount'] = $request['amount'];
                                    $email_params['duration'] = Helper::getJobDurationList($request['completion_time']);
                                    $email_params['message'] = $request['description'];
                                    Mail::to($job->employer->email)
                                        ->send(
                                            new EmployerEmailMailable(
                                                'employer_email_proposal_received',
                                                $template_data,
                                                $email_params
                                            )
                                        );
                                    Mail::to($user->email)
                                        ->send(
                                            new FreelancerEmailMailable(
                                                'freelancer_email_new_proposal_submitted',
                                                $template_submit_proposal,
                                                $email_params
                                            )
                                        );
                                } else {
                                    $json['type'] = 'error';
                                    $json['message'] = trans('lang.something_wrong');
                                    return $json;
                                }
                            }
                            return $json;
                        } else {
                            $json['type'] = 'error';
                            $json['message'] = trans('lang.something_wrong');
                            return $json;
                        }
                    } else {
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.not_enough_connects');
                        return $json;
                    }
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.need_to_purchase_pkg');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Get job proposal listing.
     *
     * @param string $slug jobSlug
     *
     * @return \Illuminate\Http\Response
     */
    public function getJobProposals($slug)
    {
        if (!empty($slug)) {
            $accepted_proposal = array();
            $job = Job::where('slug', $slug)->first();
            $proposals = Job::latest()->find($job->id)->proposals;
            $accepted_proposal = Job::find($job->id)->proposals()->where('hired', 1)->first();
            $duration = !empty($job->duration) ? Helper::getJobDurationList($job->duration) : '';
            return View(
                'back-end.employer.proposals.index',
                compact(
                    'proposals',
                    'job',
                    'duration',
                    'accepted_proposal'
                )
            );
        } else {
            abort(404);
        }
    }

    /**
     * Hire freelancer.
     *
     * @param \Illuminate\Http\Request $request req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function hiredFreelencer(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            $this->proposal->assignJob($request['id']);
            $json['type'] = 'success';
            $json['message'] = trans('lang.freelancer_hire');
            return $json;
        }
    }



    /**
     * Proposal Details.
     *
     * @param string $slug slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $profile = array();
        $accepted_proposal = array();
        $freelancer_name = '';
        $profile_image = '';
        $user_slug = '';
        $attachments = array();
        $job = Job::where('slug', $slug)->first();
        $accepted_proposal = Job::find($job->id)->proposals()->where('hired', 1)
            ->first();
        $freelancer_name = Helper::getUserName($accepted_proposal->freelancer_id);
        $completion_time = !empty($accepted_proposal->completion_time) ?
            Helper::getJobDurationList($accepted_proposal->completion_time) : '';
        $profile = User::find($accepted_proposal->freelancer_id)->profile;
        $attachments = !empty($accepted_proposal->attachments) ? unserialize($accepted_proposal->attachments) : '';
        $user_image = !empty($profile) ? $profile->avater : '';
        $profile_image = !empty($user_image) ? '/uploads/users/' . $accepted_proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
        $rating = !empty($profile->rating) ? $profile->rating : 'Not Rated Yet';
        $employer_name = Helper::getUserName($job->user_id);
        $project_status = Helper::getProjectStatus();
        $duration = !empty($job->duration) ? Helper::getJobDurationList($job->duration) : '';
        $review_options = DB::table('review_options')->get()->all();
        $user_slug = User::find($accepted_proposal->freelancer_id)->slug;
        return view(
            'back-end.employer.proposals.show',
            compact(
                'job',
                'duration',
                'accepted_proposal',
                'project_status',
                'employer_name',
                'profile_image',
                'completion_time',
                'freelancer_name',
                'attachments',
                'rating',
                'review_options',
                'user_slug'
            )
        );
    }
}
