<?php

/**
 * Class JobController.
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Language;
use App\Category;
use App\Skill;
use App\Location;
use App\Helper;
use App\Proposal;
use ValidateRequests;
use App\User;
use App\Profile;
use App\Package;
use DB;
use Spatie\Permission\Models\Role;
use App\SiteManagement;
use App\Mail\AdminEmailMailable;
use App\Mail\EmployerEmailMailable;
use App\EmailTemplate;
use App\Item;
use Carbon\Carbon;

/**
 * Class JobController
 *
 */
class JobController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $job
     */
    protected $job;

    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $job
     */
    // public $email_settings;

    /**
     * Create a new controller instance.
     *
     * @param instance $job instance
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
        $email_settings = SiteManagement::getMetaValue('settings');
        if (!empty($email_settings[0]['email'])) {
            config(['mail.username' => $email_settings[0]['email']]);
        }
    }

    /**
     * Post Job Form.
     *
     * @return post jobs page
     */
    public function postJob()
    {
        $languages = Language::pluck('title', 'id');
        $locations = Location::pluck('title', 'id');
        $english_levels = Helper::getEnglishLevelList();
        $project_levels = Helper::getProjectLevel();
        $job_duration = Helper::getJobDurationList();
        $freelancer_level = Helper::getFreelancerLevelList();
        $skills = Skill::pluck('title', 'id');
        $categories = Category::pluck('title', 'id');
        $role_id =  Helper::getRoleByUserID(Auth::user()->id);
        $package_options = Package::select('options')->where('role_id', $role_id)->first();
        $options = !empty($package_options) ? unserialize($package_options['options']) : array();
        return view(
            'back-end.employer.jobs.create',
            compact(
                'english_levels',
                'languages',
                'project_levels',
                'job_duration',
                'freelancer_level',
                'skills',
                'categories',
                'locations',
                'options'
            )
        );
    }

    /**
     * Manage Jobs.
     *
     * @return manage jobs page
     */
    public function index()
    {
        $job_details = $this->job->latest()->where('user_id', Auth::user()->id)->paginate(5);
        return view('back-end.employer.jobs.index', compact('job_details'));
    }

    /**
     * Job Edit Form.
     *
     * @param integer $job_slug Job Slug
     *
     * @return show job edit page
     */
    public function edit($job_slug)
    {
        if (!empty($job_slug)) {
            $job = Job::where('slug', $job_slug)->first();
            $json = array();
            $languages = Language::pluck('title', 'id');
            $locations = Location::pluck('title', 'id');
            $skills = Skill::pluck('title', 'id');
            $categories = Category::pluck('title', 'id');
            $project_levels = Helper::getProjectLevel();
            $english_levels = Helper::getEnglishLevelList();
            $job_duration = Helper::getJobDurationList();
            $freelancer_level_list = Helper::getFreelancerLevelList();
            $attachments = !empty($job->attachments) ? unserialize($job->attachments) : '';
            if (!empty($job)) {
                return View(
                    'back-end.employer.jobs.edit',
                    compact(
                        'job',
                        'project_levels',
                        'english_levels',
                        'job_duration',
                        'freelancer_level_list',
                        'languages',
                        'categories',
                        'skills',
                        'locations',
                        'attachments'
                    )
                );
            }
        }
    }

    /**
     * Get job attachment settings.
     *
     * @param integer $request $request->attributes
     *
     * @return show job single page
     */
    public function getAttachmentSettings(Request $request)
    {
        $json = array();
        if ($request['slug']) {
            $settings = Job::where('slug', $request['slug'])
                ->select('is_featured', 'show_attachments')->first();
            if (!empty($settings)) {
                $json['type'] = 'success';
                if ($settings->is_featured == 'true') {
                    $json['is_featured'] = 'true';
                }
                if ($settings->show_attachments == 'true') {
                    $json['show_attachments'] = 'true';
                }
            } else {
                $json['type'] = 'error';
            }
            return $json;
        }
    }

    /**
     * Upload image to temporary folder.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request)
    {
        if (!empty($request['file'])) {
            $attachments = $request['file'];
            return $this->job->uploadTempattachments($attachments);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = array();
        $this->validate(
            $request,
            [
                'title' => 'required',
                'project_levels'    => 'required',
                'job_duration'    => 'required',
                'english_level'    => 'required',
                'project_cost'    => 'required',
                'description'    => 'required',
            ]
        );
        $package_item = Item::where('subscriber', Auth::user()->id)->first();
        $package = Package::find($package_item->product_id);
        $option = !empty($package->options) ? unserialize($package->options) : '';
        $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
        $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->format('M d, Y') : '';
        $current_date = Carbon::now()->format('M d, Y');
        $posted_jobs = $this->job::where('user_id', Auth::user()->id)->count();
        $posted_featured_jobs = Job::where('user_id', Auth::user()->id)->where('is_featured', 'true')->count();
        if (!empty($package) && $current_date <= $expiry_date) {
            if ($request['is_featured'] == 'true') {
                if ($posted_featured_jobs >= intval($option['featured_jobs'])) {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.sorry_can_only_feature')  .' '. $option['featured_jobs'] .' ' . trans('lang.jobs_acc_to_pkg');
                    return $json;
                }
            }
            if ($posted_jobs >= intval($option['jobs'])) {
                $json['type'] = 'error';
                $json['message'] = trans('lang.sorry_cannot_submit') .' '. $option['jobs'] .' ' . trans('lang.jobs_acc_to_pkg');
                return $json;
            } else {
                $job_post = $this->job->storeJobs($request);
                if ($job_post = 'success') {
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.job_post_success');
                    $email_settings = SiteManagement::getMetaValue('settings');
                    // Send Email
                    $user = User::find(Auth::user()->id);
                    //send email to admin
                    if (!empty($email_settings[0]['email'])) {
                        $job = $this->job::where('user_id', Auth::user()->id)->latest()->first();
                        $email_params = array();
                        $new_posted_job_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_new_job_posted')->get()->first();
                        $new_posted_job_template_employer = DB::table('email_types')->select('id')->where('email_type', 'employer_email_new_job_posted')->get()->first();
                        if (!empty($new_posted_job_template->id) || !empty(new_posted_job_template_employer)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($new_posted_job_template->id);
                            $template_data_employer = EmailTemplate::getEmailTemplateByID($new_posted_job_template_employer->id);
                            $email_params['job_title'] = $job->title;
                            $email_params['posted_job_link'] = url('/job/' . $job->slug);
                            $email_params['name'] = Helper::getUserName(Auth::user()->id);
                            $email_params['link'] = url('profile/' . $user->slug);
                            $admin_mail = User::role('admin')->select('email')->pluck('email')->first();
                            Mail::to($admin_mail)
                                ->send(
                                    new AdminEmailMailable(
                                        'admin_email_new_job_posted',
                                        $template_data,
                                        $email_params
                                    )
                                );
                            if (!empty($user->email)) {
                                Mail::to($user->email)
                                    ->send(
                                        new EmployerEmailMailable(
                                            'employer_email_new_job_posted',
                                            $template_data_employer,
                                            $email_params
                                        )
                                    );
                            }
                        }

                    }
                    return $json;
                }
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.need_to_purchase_pkg');
            return $json;
        }
    }

    /**
     * Updated resource in DB.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $json = array();
        $this->validate(
            $request,
            [
                'title' => 'required',
                'project_levels'    => 'required',
                'english_level'    => 'required',
                'project_cost'    => 'required',
            ]
        );
        $id = $request['id'];
        $job_update = $this->job->updateJobs($request, $id);
        if ($job_update['type'] = 'success') {
            $json['type'] = 'success';
            $json['message'] = trans('lang.job_update_success');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $slug Job Slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $job = $this->job::all()->where('slug', $slug)->first();
        if (!empty($job)) {
            $submitted_proposals = $job->proposals->where('status', '!=', 'cancelled')->pluck('freelancer_id')->toArray();
            $employer_id = $job->employer->id;
            $profile = User::find($employer_id)->profile;
            $user_image = !empty($profile) ? $profile->avater : '';
            $profile_image = !empty($user_image) ? '/uploads/users/' . $job->employer->id . '/' . $user_image : 'images/user-login.png';
            $reasons = Helper::getReportReasons();
            $auth_profile = Auth::user() ? auth()->user()->profile : '';
            $save_jobs = !empty($auth_profile->saved_jobs) ? unserialize($auth_profile->saved_jobs) : array();
            $save_employers = !empty($auth_profile->saved_employers) ? unserialize($auth_profile->saved_employers) : array();
            $attachments  = unserialize($job->attachments);
            return view(
                'front-end.jobs.show',
                compact(
                    'job',
                    'reasons',
                    'profile_image',
                    'submitted_proposals',
                    'save_jobs',
                    'save_employers',
                    'attachments'
                )
            );
        } else {
            abort(404);
        }
    }

    /**
     * Get job Skills.
     *
     * @param mixed $request $req->attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getJobSkills(Request $request)
    {
        $json = array();
        if (!empty($request['slug'])) {
            $job = $this->job::where('slug', $request['slug'])->select('id')->first();
            if (!empty($job)) {
                $jobs = $this->job::find($job['id']);
                $skills = $jobs->skills->toArray();
                if (!empty($skills)) {
                    $json['type'] = 'success';
                    $json['skills'] = $skills;
                    return $json;
                } else {
                    $json['error'] = 'error';
                    return $json;
                }
            } else {
                $json['error'] = 'error';
                return $json;
            }
        }
    }

    /**
     * Display admin jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobsAdmin()
    {
        $jobs = $this->job->latest()->paginate(6);
        return view(
            'back-end.admin.jobs.index',
            compact('jobs')
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listjobs()
    {
        $jobs = array();
        $categories = array();
        $locations = array();
        $languages = array();
        $jobs = $this->job->latest()->paginate(6);
        $categories = Category::all();
        $locations = Location::all();
        $languages = Language::all();
        $freelancer_skills = Helper::getFreelancerLevelList();
        $project_length = Helper::getJobDurationList();
        $skills = Skill::all();
        $keyword = '';
        $Jobs_total_records = '';
        $type = 'job';
        return view(
            'front-end.jobs.index',
            compact(
                'jobs',
                'categories',
                'locations',
                'languages',
                'freelancer_skills',
                'project_length',
                'keyword',
                'Jobs_total_records',
                'type',
                'skills'
            )
        );
    }

    /**
     * Add job to whishlist.
     *
     * @param mixed $request request->attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function addWishlist(Request $request)
    {
        $json = array();
        if (Auth::user()) {
            if (!empty($request['id'])) {
                $user_id = Auth::user()->id;
                $id = $request['id'];
                $profile = new Profile();
                $add_wishlist = $profile->addWishlist($request['column'], $id, $user_id);
                if ($add_wishlist == "success") {
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.added_to_wishlist');
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.something_wrong');
                    return $json;
                }
            }
        } else {
            $json['type'] = 'authentication';
            $json['message'] = trans('lang.need_to_reg');
            return $json;
        }
    }
}
