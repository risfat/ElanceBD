<?php

/**
 * Class FreelancerController.
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App\Http\Controllers;

use App\Freelancer;
use Illuminate\Http\Request;
use App\Helper;
use App\Location;
use App\Skill;
use Session;
use App\Profile;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Proposal;
use App\Job;
use DB;
use App\Package;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use ValidateRequests;
use App\Item;
use Carbon\Carbon;
use App\Message;
use App\Payout;
use App\SiteManagement;


/**
 * Class FreelancerController
 *
 */
class FreelancerController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $freelancer
     */
    protected $freelancer;

    /**
     * Create a new controller instance.
     *
     * @param instance $freelancer instance
     *
     * @return void
     */
    public function __construct(Profile $freelancer, Payout $payout)
    {
        $this->freelancer = $freelancer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::pluck('title', 'id');
        $skills = Skill::pluck('title', 'id');
        $profile = $this->freelancer::where('user_id', Auth::user()->id)
            ->get()->first();
        $gender = !empty($profile->gender) ? $profile->gender : '';
        $hourly_rate = !empty($profile->hourly_rate) ? $profile->hourly_rate : '';
        $tagline = !empty($profile->tagline) ? $profile->tagline : '';
        $description = !empty($profile->description) ? $profile->description : '';
        $address = !empty($profile->address) ? $profile->address : '';
        $longitude = !empty($profile->longitude) ? $profile->longitude : '';
        $latitude = !empty($profile->latitude) ? $profile->latitude : '';
        $banner = !empty($profile->banner) ? $profile->banner : '';
        $avater = !empty($profile->avater) ? $profile->avater : '';
        $role_id =  Helper::getRoleByUserID(Auth::user()->id);
        $packages = DB::table('items')->where('subscriber', Auth::user()->id)->count();
        $package_options = Package::select('options')->where('role_id', $role_id)->first();
        $options = !empty($package_options) ? unserialize($package_options['options']) : array();
        return view(
            'back-end.freelancer.profile-settings.personal-detail.index',
            compact(
                'locations',
                'skills',
                'profile',
                'gender',
                'hourly_rate',
                'tagline',
                'description',
                'banner',
                'address',
                'longitude',
                'latitude',
                'avater',
                'options'
            )
        );
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
        $path = Helper::PublicPath() . '/uploads/users/temp/';
        if (!empty($request['hidden_avater_image'])) {
            $profile_image = $request['hidden_avater_image'];
            return Helper::uploadTempImage($path, $profile_image);
        } elseif (!empty($request['hidden_banner_image'])) {
            $profile_image = $request['hidden_banner_image'];
            return Helper::uploadTempImage($path, $profile_image);
        } elseif (!empty($request['project_img'])) {
            $profile_image = $request['project_img'];
            return Helper::uploadTempImage($path, $profile_image);
        } elseif (!empty($request['award_img'])) {
            $profile_image = $request['award_img'];
            return Helper::uploadTempImage($path, $profile_image);
        }
    }

    /**
     * Store profile settings.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function storeProfileSettings(Request $request)
    {
        $json = array();
        $this->validate(
            $request,
            [
                'first_name'    => 'required',
                'last_name'    => 'required',
                'gender'    => 'required',
            ]
        );
        if (Auth::user()) {
            $role_id = Helper::getRoleByUserID(Auth::user()->id);
            $packages = DB::table('items')->where('subscriber', Auth::user()->id)->count();
            $package_options = Package::select('options')->where('role_id', $role_id)->first();
            $options = !empty($package_options) ? unserialize($package_options['options']) : array();
            $skills = !empty($options) ? $options['no_of_skills'] : array();
            if ($packages > 0) {
                if (!empty($request['skills'])) {
                    if (count($request['skills']) > $skills) {
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.cannot_add_morethan') . '' . $options['no_of_skills'] . '' . trans('lang.skills');
                        return $json;
                    }
                }
                $profile =  $this->freelancer->storeProfile($request, Auth::user()->id);
                if ($profile = 'success') {
                    $json['type'] = 'success';
                    $json['message'] = '';
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.update_pkg');
                return $json;
            }
            Session::flash('message', trans('lang.update_profile'));
            return Redirect::back();
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Get freelancer skills.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerSkills()
    {
        $json = array();
        if (Auth::user()) {
            $skills = User::find(Auth::user()->id)->skills()
                ->orderBy('title')->get()->toArray();
            if (!empty($skills)) {
                $json['type'] = 'success';
                $json['freelancer_skills'] = $skills;
                return $json;
            } else {
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Show the form for creating and updating experiance and education settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function experienceEducationSettings()
    {
        return view('back-end.freelancer.profile-settings.experience-education.index');
    }

    /**
     * Show the form for creating and updating projects & awards.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectAwardsSettings()
    {

        return view('back-end.freelancer.profile-settings.projects-awards.index');
    }

    /**
     * Show the form for payment settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentSettings()
    {
        $profile = $this->freelancer::where('user_id', Auth::user()->id)
            ->get()->first();
        $payout_id = !empty($profile->payout_id) ? $profile->payout_id : '';
        return view('back-end.freelancer.profile-settings.payment-settings.index', compact('payout_id'));
    }

    /**
     * Show the form for creating and updating experiance and education settings.
     *
     * @param mixed $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeExperienceEducationSettings(Request $request)
    {
        $json = array();
        $this->validate(
            $request,
            [
                'experience.*.job_title' => 'required',
                'experience.*.start_date' => 'required',
                'experience.*.end_date' => 'required',
                'experience.*.company_title' => 'required',
                'education.*.degree_title' => 'required',
                'education.*.start_date' => 'required',
                'education.*.end_date' => 'required',
                'education.*.institute_title' => 'required',
            ]
        );
        $user_id = Auth::user()->id;
        $update_experience_education = $this->freelancer->updateExperienceEducation($request, $user_id);
        if ($update_experience_education['type'] == 'success') {
            $json['type'] = 'success';
            $json['message'] = trans('lang.saving_profile');
            $json['complete_message'] = trans('lang.profile_update_success');
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.empty_fields_not_allowed');
        }
        return $json;
    }

    /**
     * Store payment settings.
     *
     * @param mixed $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function storePaymentSettings(Request $request)
    {
        $json= array();
        $user_id = Auth::user()->id;
        $user_profile = $this->freelancer::select('id')->where('user_id', $user_id)
            ->get()->first();
        if (!empty($request)) {
            if (!empty($user_profile->id)) {
                $profile = $this->freelancer::find($user_profile->id);
                $profile->payout_id = $request['payout_id'];
                $profile->save();
            } else {
                $profile = new Profile();
                $profile->user()->associate($user_id);
                $profile->payout_id = $request['payout_id'];
                $profile->save();
            }
            $json['type'] = 'success';
            $json['processing'] = trans('lang.saving_payment_settings');
        }
    }

    /**
     * Show the form with saved values.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerExperiences()
    {
        $json = array();
        $user_id = Auth::user()->id;
        if (Auth::user()) {
            $profile = $this->freelancer::select('experience')
                ->where('user_id', $user_id)->get()->first();
            if (!empty($profile)) {
                $json['type'] = 'success';
                $json['experiences'] = unserialize($profile->experience);
                return $json;
            } else {
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Show the form with saved values.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerEducations()
    {
        $json = array();
        $user_id = Auth::user()->id;
        if (Auth::user()) {
            $profile = $this->freelancer::select('education')
                ->where('user_id', $user_id)->get()->first();
            if (!empty($profile)) {
                $json['type'] = 'success';
                $json['educations'] = unserialize($profile->education);
                return $json;
            } else {
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }


    /**
     * Show the form for creating and updating projects and awards settings.
     *
     * @param mixed $request Request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeProjectAwardSettings(Request $request)
    {
        $json = array();
        if (!empty($request)) {
            $this->validate(
                $request,
                [
                    'award.*.award_title' => 'required',
                    'award.*.award_date'    => 'required',
                    'award.*.award_hidden_image'    => 'required',
                    'project.*.project_title' => 'required',
                    'project.*.project_url'    => 'required',
                ]
            );
            $user_id = Auth::user()->id;
            $store_awards_projects = $this->freelancer->updateAwardProjectSettings($request, $user_id);
            if ($store_awards_projects['type'] == 'success') {
                $json['type'] = 'success';
                $json['message'] = trans('lang.saving_profile');
                $json['complete_message'] = 'Profile Updated Successfully';
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.empty_fields_not_allowed');
            }
            return $json;
        }
    }

    /**
     * Get freelancer's projects
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerProjects()
    {
        $user_id = Auth::user()->id;
        $json = array();
        if (Auth::user()) {
            $profile = $this->freelancer::select('projects')
                ->where('user_id', $user_id)->get()->first();
            if (!empty($profile)) {
                $json['type'] = 'success';
                $json['projects'] = unserialize($profile->projects);
                return $json;
            } else {
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Get freelancer's awards
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerAwards()
    {
        $user_id = Auth::user()->id;
        $json = array();
        if (Auth::user()) {
            $profile = $this->freelancer::select('awards')
                ->where('user_id', $user_id)->get()->first();
            if (!empty($profile)) {
                $json['type'] = 'success';
                $json['awards'] = unserialize($profile->awards);
                return $json;
            } else {
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Show Freelancer Jobs.
     *
     * @param string $status job status
     *
     * @return \Illuminate\Http\Response
     */
    public function showFreelancerJobs($status)
    {
        $ongoing_jobs = array();
        $freelancer_id = Auth::user()->id;
        if (Auth::user()) {
            $ongoing_jobs = Proposal::select('job_id')->latest()->where('freelancer_id', $freelancer_id)->where('status', 'hired')->paginate(7);
            $completed_jobs = Proposal::select('job_id')->latest()->where('freelancer_id', $freelancer_id)->where('status', 'completed')->paginate(7);
            $cancelled_jobs = Proposal::select('job_id')->latest()->where('freelancer_id', $freelancer_id)->where('status', 'cancelled')->paginate(7);
            if (!empty($status) && $status === 'hired') {
                return view(
                    'back-end.freelancer.jobs.ongoing',
                    compact(
                        'ongoing_jobs'
                    )
                );
            } elseif (!empty($status) && $status === 'completed') {
                return view(
                    'back-end.freelancer.jobs.completed',
                    compact(
                        'completed_jobs'
                    )
                );
            } elseif (!empty($status) && $status === 'cancelled') {
                return view(
                    'back-end.freelancer.jobs.cancelled',
                    compact(
                        'cancelled_jobs'
                    )
                );
            }
        }
    }

    /**
     * Show Freelancer Job Details.
     *
     * @param string $slug job slug
     *
     * @return \Illuminate\Http\Response
     */
    public function showOnGoingJobDetail($slug)
    {
        $job = array();
        if (Auth::user()) {
            $job = Job::where('slug', $slug)->first();
            $proposal = Job::find($job->id)->proposals()->select('id', 'status')->where('status', '!=', 'pending')
                ->first();
            $employer_name = Helper::getUserName($job->user_id);
            $duration = !empty($job->duration) ? Helper::getJobDurationList($job->duration) : '';
            $profile = User::find(Auth::user()->id)->profile;
            $employer_profile = User::find($job->user_id)->profile;
            $employer_avatar = !empty($employer_profile) ? $employer_profile->avater : '';
            $user_image = !empty($profile) ? $profile->avater : '';
            $profile_image = !empty($user_image) ? '/uploads/users/' . Auth::user()->id . '/' . $user_image : 'images/user-login.png';
            $employer_image = !empty($employer_avatar) ? '/uploads/users/' . $job->user_id . '/' . $employer_avatar : 'images/user-login.png';
            return view(
                'back-end.freelancer.jobs.show',
                compact(
                    'job',
                    'employer_name',
                    'duration',
                    'profile_image',
                    'employer_image',
                    'proposal'
                )
            );
        }
    }

    /**
     * Show freelancer proposals.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFreelancerProposals()
    {
        $proposals = Proposal::select('job_id', 'status', 'id')->where('freelancer_id', Auth::user()->id)->latest()->paginate(7);
        return view(
            'back-end.freelancer.proposals.index',
            compact(
                'proposals'
            )
        );
    }

    /**
     * Show freelancer dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function freelancerDashboard()
    {
        $ongoing_jobs = array();
        $freelancer_id = Auth::user()->id;
        $ongoing_projects = Proposal::getProposalsByStatus($freelancer_id, 'hired', 3);
        $cancelled_projects = Proposal::getProposalsByStatus($freelancer_id, 'cancelled');
        $package_item = Item::where('subscriber', $freelancer_id)->first();
        $package = !empty($package_item) ? Package::find($package_item->product_id) : array();
        $option = !empty($package) && !empty($package['options']) ? unserialize($package['options']) : '';
        $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
        $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
        $message_status = Message::where('status', 0)->where('receiver_id', $freelancer_id)->count();
        $notify_class = $message_status > 0 ? 'wt-insightnoticon' : '';
        $completed_projects = Proposal::getProposalsByStatus($freelancer_id, 'completed');
        $currency   = SiteManagement::getMetaValue('payment_settings');
        $symbol = !empty($currency) ? Helper::currencyList($currency[0]['currency']) : array();
        $trail  = !empty($package) && $package['trial'] == 1 ? 'true' : 'false';
        if (Auth::user()) {
            return view(
                'back-end.freelancer.dashboard',
                compact(
                    'ongoing_projects',
                    'cancelled_projects',
                    'expiry_date',
                    'notify_class',
                    'completed_projects',
                    'symbol',
                    'trail'
                )
            );
        }
    }

    /**
     * Get freelancer payouts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayouts()
    {
        $payouts =  Payout::where('user_id', Auth::user()->id)->paginate(10);
        return view(
            'back-end.freelancer.payouts',
            compact('payouts')
        );
    }

}
