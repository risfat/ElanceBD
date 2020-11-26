<?php

/**
 * Class UserController
 *
  
 * @category ElanceBD
 *
 * @package Elancebd
 * @author  Risfat <md@risfbd.com>
 * @license https://risfbd.com Risfat
 * @link    https://risfbd.com

 */

namespace App\Http\Controllers;

use App\EmailTemplate;
use App\Helper;
use App\Invoice;
use App\Job;
use App\Language;
use App\Mail\AdminEmailMailable;
use App\Mail\FreelancerEmailMailable;
use App\Package;
use App\Profile;
use App\Proposal;
use App\Report;
use App\Review;
use App\SiteManagement;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Input;
use View;
use App\Offer;
use App\Message;
use Illuminate\Support\Arr;
use App\Payout;
use File;
use Storage;

/**
 * Class UserController
 *
 */
class UserController extends Controller
{
    /**
     * Defining public scope of varriable
     *
     * @access public
     *
     * @var array $user
     */
    use HasRoles;
    protected $user;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @param instance $user    make instance
     * @param instance $profile make profile instance
     *
     * @return void
     */
    public function __construct(User $user, Profile $profile)
    {
        $this->user = $user;
        $this->profile = $profile;
        $email_settings = SiteManagement::getMetaValue('settings');
        if (!empty($email_settings[0]['email'])) {
            config(['mail.username' => $email_settings[0]['email']]);
        }
    }

    /**
     * Profile Manage Account/ Profile Settings
     *
     * @access public
     *
     * @return View
     */
    public function accountSettings()
    {
        $languages = Language::pluck('title', 'id');
        $user_id = Auth::user()->id;
        $profile = new Profile();
        $saved_options = $profile::select('profile_searchable', 'profile_blocked', 'english_level')
            ->where('user_id', $user_id)->get()->first();
        $english_levels = Helper::getEnglishLevelList();
        $user_level = !empty($saved_options->english_level) ? $saved_options->english_level : trans('lang.basic');
        $user = $this->user::find($user_id);
        $user_languages = array();
        if (!empty($user->languages)) {
            foreach ($user->languages as $user_language) {
                $user_languages[] = $user_language->id;
            }
        }

        return view(
            'back-end.settings.security-settings',
            compact('languages', 'saved_options', 'user_languages', 'english_levels', 'user_level')
        );
    }

    /**
     * Save user account settings.
     *
     * @param mixed $request request attribute
     *
     * @access public
     *
     * @return View
     */
    public function saveAccountSettings(Request $request)
    {
        $profile = new Profile();
        $user_id = Auth::user()->id;
        $profile->storeAccountSettings($request, $user_id);
        Session::flash('message', trans('lang.account_settings_saved'));
        return Redirect::back();
    }

    /**
     * Reset password form.
     *
     * @access public
     *
     * @return View
     */
    public function resetPassword()
    {
        return view('back-end.settings.reset-password');
    }

    /**
     * Update reset password.
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function requestPassword(Request $request)
    {
        if (!empty($request)) {
            Validator::extend(
                'old_password',
                function ($attribute, $value, $parameters) {
                    return Hash::check($value, Auth::user()->password);
                }
            );
            $this->validate(
                $request,
                [
                    'old_password' => 'required',
                    'confirm_password' => 'required',
                ]
            );
            $user_id = $request['user_id'];
            $user = User::find($user_id);
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->confirm_password);
                $user->save();
                Session::flash('message', trans('lang.pass_changed'));
                Auth::logout();
                return Redirect::to('/');
            } else {
                Session::flash('error', trans('lang.pass_not_match'));
                return Redirect::back();
            }
        } else {
            Session::flash('error', trans('lang.something_wrong'));
            return Redirect::back();
        }
    }

    /**
     * Email Notification Settings Form.
     *
     * @access public
     *
     * @return View
     */
    public function emailNotificationSettings()
    {
        $user_email = !empty(Auth::user()) ? Auth::user()->email : '';
        return view('back-end.settings.email-notifications', compact('user_email'));
    }

    /**
     * Save Email Notification Settings.
     *
     * @param mixed $request request attribute
     *
     * @access public
     *
     * @return View
     */
    public function saveEmailNotificationSettings(Request $request)
    {
        $profile = new Profile();
        $user_id = Auth::user()->id;
        $profile->storeEmailNotification($request, $user_id);
        Session::flash('message', trans('lang.email_settings_saved'));
        return Redirect::back();
    }

    /**
     * Delete Account From.
     *
     * @access public
     *
     * @return View
     */
    public function deleteAccount()
    {
        return view('back-end.settings.delete-account');
    }

    /**
     * User delete account.
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function destroy(Request $request)
    {
        $this->validate(
            $request,
            [
                'old_password' => 'required',
                'retype_password'    => 'required',
            ]
        );
        $json = array();
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        if (Hash::check($request->old_password, $user->password)) {
            if (!empty($user_id)) {
                $user->profile()->delete();
                $user->skills()->detach();
                $user->languages()->detach();
                $user->categories()->detach();
                $user->roles()->detach();
                $user->delete();
                $email_settings = SiteManagement::getMetaValue('settings');
                if (!empty($email_settings[0]['email'])) {
                    $delete_reason = Helper::getDeleteAccReason($request['delete_reason']);
                    $email_params = array();
                    $template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_delete_account')->get()->first();
                    if (!empty($template->id)) {
                        $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                        $email_params['reason'] = $delete_reason;
                        Mail::to($email_settings[0]['email'])
                            ->send(
                                new AdminEmailMailable(
                                    'admin_email_delete_account',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
                Auth::logout();
                $json['acc_del'] = trans('lang.acc_deleted');
                return $json;
            } else {
                $json['type'] = 'warning';
                $json['msg'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'warning';
            $json['msg'] = trans('lang.pass_mismatched');
            return $json;
        }
    }

    /**
     * Delete user by admin.
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function deleteUser(Request $request)
    {
        $json = array();
        $user = User::find($request['user_id']);
        if (!empty($user)) {
            $user->profile()->delete();
            $user->skills()->detach();
            $user->categories()->detach();
            $user->roles()->detach();
            $user->delete();
            $email_settings = SiteManagement::getMetaValue('settings');
            if (!empty($email_settings[0]['email'])) {
                $delete_reason = $request['delete_reason'];
                $email_params = array();
                $template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_delete_account')->get()->first();
                if (!empty($template->id)) {
                    $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                    $email_params['reason'] = $delete_reason;
                    Mail::to($email_settings[0]['email'])
                        ->send(
                            new AdminEmailMailable(
                                'admin_email_delete_account',
                                $template_data,
                                $email_params
                            )
                        );
                }
            }
            $json['type'] = 'Sucess';
            $json['message'] = trans('lang.ph_user_delete_message');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get Manage Account Data
     *
     * @access public
     *
     * @return View
     */
    public function getManageAccountData()
    {
        if (Auth::user()) {
            $json = array();
            $user_id = Auth::user()->id;
            $profile = User::find($user_id)->profile->first();
            if (!empty($profile)) {
                $json['type'] = 'success';
                if ($profile->profile_searchable == 'true') {
                    $json['profile_searchable'] = 'true';
                }
                if ($profile->profile_blocked == 'true') {
                    $json['profile_blocked'] = 'true';
                }
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        }
    }

    /**
     * Get User Notification Settings
     *
     * @access public
     *
     * @return View
     */
    public function getUserEmailNotificationSettings()
    {
        $json = array();
        $profile = new Profile();
        $notifications = $profile::select('weekly_alerts', 'message_alerts')
            ->where('user_id', Auth::user()->id)->get()->first();
        if (!empty($notifications)) {
            $json['type'] = 'success';
            if ($notifications->weekly_alerts == 'true') {
                $json['weekly_alerts'] = 'true';
            }
            if ($notifications->message_alerts == 'true') {
                $json['message_alerts'] = 'true';
            }
        } else {
            $json['type'] = 'error';
        }
        return $json;
    }

    /**
     * Get User Searchable Settings
     *
     * @access public
     *
     * @return View
     */
    public function getUserSearchableSettings()
    {
        $json = array();
        $profile = new Profile();
        $user_data = $profile::select('profile_searchable', 'profile_blocked')
            ->where('user_id', Auth::user()->id)->get()->first();
        if (!empty($user_data)) {
            $json['type'] = 'success';
            if ($user_data->profile_searchable == 'true') {
                $json['profile_searchable'] = 'true';
            }
            if ($user_data->profile_blocked == 'true') {
                $json['profile_blocked'] = 'true';
            }
        } else {
            $json['type'] = 'error';
        }
        return $json;
    }

    /**
     * Get user saved item list
     *
     * @param mixed $request request attributes
     * @param int   $role    role
     *
     * @access public
     *
     * @return View
     */
    public function getSavedItems(Request $request, $role = '')
    {
        if (Auth::user()) {
            $user = $this->user::find(Auth::user()->id);
            $profile = $user->profile;
            $saved_jobs        = !empty($profile->saved_jobs) ? unserialize($profile->saved_jobs) : array();
            $saved_freelancers = !empty($profile->saved_freelancer) ? unserialize($profile->saved_freelancer) : array();
            $saved_employers   = !empty($profile->saved_employers) ? unserialize($profile->saved_employers) : array();
            $currency          = SiteManagement::getMetaValue('payment_settings');
            $symbol            = !empty($currency) ? Helper::currencyList($currency[0]['currency']) : array();
            if ($request->path() === 'employer/saved-items') {
                return view(
                    'back-end.employer.saved-items',
                    compact(
                        'profile',
                        'saved_jobs',
                        'saved_freelancers',
                        'saved_employers',
                        'symbol'
                    )
                );
            } elseif ($request->path() === 'freelancer/saved-items') {
                return view(
                    'back-end.freelancer.saved-items',
                    compact(
                        'profile',
                        'saved_jobs',
                        'saved_freelancers',
                        'saved_employers',
                        'symbol'
                    )
                );
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get User Saved Item
     *
     * @param mixed $request request attributes
     *
     * @access public
     *
     * @return View
     */
    public function getUserWishlist(Request $request)
    {
        if (Auth::user()) {
            $user = $this->user::find(Auth::user()->id);
            $profile = $user->profile;
            if (!empty($request['slug'])) {
                $json = array();
                $selected_user = DB::table('users')->select('id')
                    ->where('slug', $request['slug'])->get()->first();
                $role = $this->user::getUserRoleType($selected_user->id);
                if ($role->role_type == 'freelancer') {
                    $json['user_type'] = 'freelancer';
                    if (in_array($selected_user->id, unserialize($profile->saved_freelancer))) {
                        $json['current_freelancer'] = 'true';
                    }
                    return $json;
                } else if ($role->role_type == 'employer') {
                    $json['user_type'] = 'employer';
                    $employer_jobs = $this->user::find($selected_user->id)
                        ->jobs->pluck('id')->toArray();
                    if (!empty($employer_jobs) && !empty(unserialize($profile->saved_jobs))) {
                        if (in_array($employer_jobs, unserialize($profile->saved_jobs))) {
                            $json['employer_jobs'] = 'true';
                        }
                    }
                    if (in_array($selected_user->id, unserialize($profile->saved_employers))) {
                        $json['current_employer'] = 'true';
                    }
                    return $json;
                }
            }
        }
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
            $json['authentication'] = true;
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
            $json['authentication'] = false;
            $json['message'] = trans('lang.need_to_reg');
            return $json;
        }
    }

    /**
     * Submit Reviews.
     *
     * @param \Illuminate\Http\Request $request request->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function submitReview(Request $request)
    {
        $json = array();
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            $submit_review = Review::submitReview($request, $user_id);
            if ($submit_review['type'] == "success") {
                $json['type'] = 'success';
                $json['message'] = trans('lang.feedback_submit');
                // Send Email
                $email_settings = SiteManagement::getMetaValue('settings');
                $freelancer = Proposal::select('freelancer_id')->where('status', 'completed')->first();
                $user = User::find($freelancer->freelancer_id);
                $job = Job::find($request['job_id']);
                //send email
                if (!empty($email_settings[0]['email'])) {
                    $email_params = array();
                    $job_completed_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_job_completed')->get()->first();
                    if (!empty($job_completed_template->id)) {
                        $template_data = EmailTemplate::getEmailTemplateByID($job_completed_template->id);
                        $email_params['project_title'] = $job->title;
                        $email_params['completed_project_link'] = url('/job/' . $job->slug);
                        $email_params['name'] = Helper::getUserName($freelancer->freelancer_id);
                        $email_params['link'] = url('profile/' . $user->slug);
                        Mail::to($email_settings[0]['email'])
                            ->send(
                                new AdminEmailMailable(
                                    'admin_email_job_completed',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
                return $json;
            } elseif ($submit_review['type'] == "rating_error") {
                $json['type'] = 'error';
                $json['message'] = trans('lang.rating_required');
                return $json;
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
     * Download Attachements.
     *
     * @param \Illuminate\Http\Request $request request->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadAttachments(Request $request)
    {
        if (!empty($request['attachments'])) {
            $freelancer_id = $request['freelancer_id'];
            $path = storage_path() . '/app/uploads/proposals/' . $freelancer_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $zip = new \Chumper\Zipper\Zipper();
            foreach ($request['attachments'] as $attachment) {
                $zip->make($path . '/attachments.zip')->add($path . '/' . $attachment);
            }
            $zip->close();
            return response()->download(storage_path('app/uploads/proposals/' . $freelancer_id . '/attachments.zip'));
        } else {
            Session::flash('error', trans('lang.files_not_found'));
            return Redirect::back();
        }
    }

    /**
     * Submit Report
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function storeReport(Request $request)
    {
        $json = array();
        if (Auth::user()) {
            $this->validate(
                $request,
                [
                    'description' => 'required',
                    'reason' => 'required',
                ]
            );
            $report = Report::submitReport($request);
            if ($report == 'success') {
                $json['type'] = 'success';
                $email_settings = SiteManagement::getMetaValue('settings');
                $user = $this->user::find(Auth::user()->id);
                //send email
                if (
                    $request['report_type'] == 'job-report'
                    || $request['report_type'] == 'employer-report'
                    || $request['report_type'] == 'freelancer-report'
                ) {
                    if (!empty($email_settings[0]['email'])) {
                        $email_params = array();
                        if ($request['report_type'] == 'job-report') {
                            $report_project_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_report_project')->get()->first();
                            if (!empty($report_project_template->id)) {
                                $job = Job::where('id', $request['id'])->first();
                                $template_data = EmailTemplate::getEmailTemplateByID($report_project_template->id);
                                $email_params['reported_project'] = $job->title;
                                $email_params['link'] = url('job/' . $job->slug);
                                $email_params['report_by_link'] = url('profile/' . $user->slug);
                                $email_params['reported_by'] = Helper::getUserName(Auth::user()->id);
                                $email_params['message'] = $request['description'];
                                Mail::to($email_settings[0]['email'])
                                    ->send(
                                        new AdminEmailMailable(
                                            'admin_email_report_project',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }
                        } else if ($request['report_type'] == 'employer-report') {
                            $report_employer_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_report_employer')->get()->first();
                            if (!empty($report_employer_template->id)) {
                                $template_data = EmailTemplate::getEmailTemplateByID($report_employer_template->id);
                                $employer = User::find($request['id']);
                                $email_params['reported_employer'] = Helper::getUserName($request['id']);
                                $email_params['link'] = url('profile/' . $employer->slug);;
                                $email_params['report_by_link'] = url('profile/' . $user->slug);
                                $email_params['reported_by'] = Helper::getUserName(Auth::user()->id);
                                $email_params['message'] = $request['description'];
                                Mail::to($email_settings[0]['email'])
                                    ->send(
                                        new AdminEmailMailable(
                                            'admin_email_report_employer',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }
                        } else if ($request['report_type'] == 'freelancer-report') {
                            $report_freelancer_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_report_freelancer')->get()->first();
                            if (!empty($report_freelancer_template->id)) {
                                $freelancer = User::find($request['id']);
                                $template_data = EmailTemplate::getEmailTemplateByID($report_freelancer_template->id);
                                $email_params['reported_freelancer'] = Helper::getUserName($request['id']);
                                $email_params['link'] = url('profile/' . $freelancer->slug);
                                $email_params['report_by_link'] = url('profile/' . $user->slug);
                                $email_params['reported_by'] = Helper::getUserName(Auth::user()->id);
                                $email_params['message'] = $request['description'];
                                Mail::to($email_settings[0]['email'])
                                    ->send(
                                        new AdminEmailMailable(
                                            'admin_email_report_freelancer',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }
                        }
                    }
                } else if ($request['report_type'] == 'proposal_cancel') {
                    $freelancer_job_cancelled = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_cancel_job')->get()->first();
                    $json['message'] = trans('lang.job_cancelled');
                    if (!empty($freelancer_job_cancelled->id)) {
                        if (!empty($email_settings[0]['email'])) {
                            $template_data = EmailTemplate::getEmailTemplateByID($freelancer_job_cancelled->id);
                            $job = Job::find($request['id']);
                            $proposal = Proposal::where('id', $request['proposal_id'])->first();
                            $freelancer = User::find($proposal->freelancer_id);
                            $email_params['project_title'] = $job->title;
                            $email_params['cancelled_project_link'] = url('job/' . $job->slug);
                            $email_params['name'] = Helper::getUserName($proposal->freelancer_id);
                            $email_params['link'] = url('profile/' . $freelancer->slug);
                            $email_params['employer_profile'] = url('profile/' . Auth::user()->slug);
                            $email_params['emp_name'] = Helper::getUserName(Auth::user()->id);
                            $email_params['msg'] = $request['description'];
                            Mail::to($email_settings[0]['email'])
                                ->send(
                                    new FreelancerEmailMailable(
                                        'freelancer_email_cancel_job',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                    }
                }
                $json['message'] = trans('lang.report_submitted');
                return $json;
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
     * Store resource in DB.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function sendPrivateMessage(Request $request)
    {
        if (Auth::user()) {
            if (!empty($request['description'])) {
                $user_id = Auth::user()->id;
                $json = array();
                $proposal = DB::table('proposals')->select('status')->where('id', $request['proposal_id'])->get()->first();
                if ($proposal->status == "hired") {
                    $proposal = new Proposal();
                    $send_message = $proposal::sendMessage($request, $user_id);
                    if ($send_message = 'success') {
                        $json['type'] = 'success';
                        $json['progress_message'] = trans('lang.sending_msg');
                        $json['message'] = trans('lang.msg_sent');
                        return $json;
                    } else {
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.something_wrong');
                        return $json;
                    }
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.not_allowed_msg');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.desc_required');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Get Private Messages.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrivateMessage(Request $request)
    {
        $json = array();
        $messages = array();
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            if (!empty($request['id'])) {
                $freelancer_id = $request['freelancer_id'];
                $proposal_id = $request['id'];
                $proposal = new Proposal();
                $message_data = $proposal::getMessages($user_id, $freelancer_id, $proposal_id);
                if (!empty($message_data)) {
                    foreach ($message_data as $key => $data) {
                        $content = strip_tags(stripslashes($data->content));
                        $excerpt = str_limit($content, 100);
                        $default_avatar = url('images/user-login.png');
                        $profile_image = !empty($data->avater)
                            ? '/uploads/users/' . $data->author_id . '/' . $data->avater
                            : $default_avatar;
                        $messages[$key]['id'] = $data->id;
                        $messages[$key]['author_id'] = $data->author_id;
                        $messages[$key]['proposal_id'] = $data->proposal_id;
                        $messages[$key]['content'] = $content;
                        $messages[$key]['excerpt'] = $excerpt;
                        $messages[$key]['user_image'] = asset($profile_image);
                        $messages[$key]['created_at'] = Carbon::parse($data->created_at)->format('d-m-Y');
                        $messages[$key]['notify'] = $data->notify;
                        $messages[$key]['attachments'] = !empty($data->attachments) ? 1 : 0;
                    }
                    $json['type'] = 'success';
                    $json['messages'] = $messages;
                    return $json;
                } else {
                    $json['messages'] = trans('lang.something_wrong');
                    return $json;
                }
            } else {
                $json['messages'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Download Attachments.
     *
     * @param \Illuminate\Http\Request $id ID
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadMessageAttachments($id)
    {
        if (!empty($id)) {
            $messages = DB::table('private_messages')->select('attachments', 'author_id')->where('id', $id)->get()->toArray();
            $attachments = unserialize($messages[0]->attachments);
            $path = storage_path() . '/app/uploads/proposals/' . $messages[0]->author_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $zip = new \Chumper\Zipper\Zipper();
            foreach ($attachments as $attachment) {
                if (Storage::disk('local')->exists('uploads/proposals/' . $messages[0]->author_id . '/' . $attachment)) {
                    $zip->make($path . '/' . $id . '-attachments.zip')->add($path . '/' . $attachment);
                }
            }
            $zip->close();
            if (Storage::disk('local')->exists('uploads/proposals/' . $messages[0]->author_id . '/' . $id . '-attachments.zip')) {
                return response()->download(storage_path('app/uploads/proposals/' . $messages[0]->author_id . '/' . $id . '-attachments.zip'));
            } else {
                Session::flash('error', trans('lang.file_not_found'));
                return Redirect::back();
            }
        }
    }

    /**
     * Checkout Page.
     *
     * @param \Illuminate\Http\Request $id ID
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout($id)
    {
        if (!empty($id)) {
            $package_options = Helper::getPackageOptions(Auth::user()->getRoleNames()[0]);
            $package = Package::find($id);
            return view::make('back-end.package.checkout', compact('package', 'package_options'));
        }
    }

    /**
     * Print Thankyou.
     *
     * @return \Illuminate\Http\Response
     */
    public function thankyou()
    {
        if (Auth::user()) {
            echo "thank you";
        } else {
            abort(404);
        }
    }

    /**
     * Get Invoices.
     *
     * @param \Illuminate\Http\Request $type type
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployerInvoices($type = '')
    {
        if (Auth::user()->getRoleNames()[0] != 'admin' && Auth::user()->getRoleNames()[0] === 'employer') {
            $currency   = SiteManagement::getMetaValue('payment_settings');
            $symbol = !empty($currency) ? Helper::currencyList($currency[0]['currency']) : array();
            $invoices = array();
            $expiry_date = '';
            if ($type === 'project') {
                $invoices = DB::table('invoices')
                    ->join('items', 'items.invoice_id', '=', 'invoices.id')
                    ->select('invoices.*')
                    ->where('items.subscriber', Auth::user()->id)
                    ->where('invoices.type', $type)
                    ->get();
                return view('back-end.employer.invoices.project', compact('invoices', 'type', 'expiry_date', 'symbol'));
            } elseif ($type === 'package') {
                $invoices = DB::table('invoices')
                    ->join('items', 'items.invoice_id', '=', 'invoices.id')
                    ->join('packages', 'packages.id', '=', 'items.product_id')
                    ->select('invoices.*', 'packages.options')
                    ->where('items.subscriber', Auth::user()->id)
                    ->where('invoices.type', $type)
                    ->get();
                return view('back-end.employer.invoices.package', compact('invoices', 'type', 'expiry_date', 'symbol'));
            }
        }
    }

    /**
     * Get Freelancer Invoices.
     *
     * @param \Illuminate\Http\Request $type type
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerInvoices($type = '')
    {
        if (Auth::user()->getRoleNames()[0] != 'admin' && Auth::user()->getRoleNames()[0] === 'freelancer') {
            $invoices = array();
            $invoices = DB::table('invoices')
                ->join('items', 'items.invoice_id', '=', 'invoices.id')
                ->join('packages', 'packages.id', '=', 'items.product_id')
                ->select('invoices.*', 'packages.options')
                ->where('items.subscriber', Auth::user()->id)
                ->where('invoices.type', $type)
                ->get();
            $expiry_date = '';
            $currency   = SiteManagement::getMetaValue('payment_settings');
            $symbol = !empty($currency) ? Helper::currencyList($currency[0]['currency']) : array();
            if ($type === 'project') {
                return view('back-end.freelancer.invoices.project', compact('invoices', 'type', 'expiry_date', 'symbol'));
            } elseif ($type === 'package') {
                return view('back-end.freelancer.invoices.package', compact('invoices', 'type', 'expiry_date', 'symbol'));
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get Invoices.
     *
     * @param integer $id roletype
     *
     * @return \Illuminate\Http\Response
     */
    public function showInvoice($id)
    {
        if (!empty($id)) {
            $invoice_info = DB::table('invoices')
                ->join('items', 'items.invoice_id', '=', 'invoices.id')
                ->select('items.*', 'invoices.*')
                ->where('invoices.id', '=', $id)
                ->get()->first();
            $code = Helper::currencyList($invoice_info->currency_code);
            $symbol = !empty($code) ? $code['symbol'] : '$';
            if (Auth::user()->getRoleNames()->first() === 'freelancer') {
                return view::make('back-end.freelancer.invoices.show', compact('invoice_info', 'symbol'));
            } elseif (Auth::user()->getRoleNames()->first() === 'employer') {
                return view::make('back-end.employer.invoices.show', compact('invoice_info', 'symbol'));
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProfileSettings()
    {
        $profile = Profile::where('user_id', Auth::user()->id)
            ->get()->first();
        $banner = !empty($profile->banner) ? $profile->banner : '';
        $avater = !empty($profile->avater) ? $profile->avater : '';
        $tagline = !empty($profile->tagline) ? $profile->tagline : '';
        $description = !empty($profile->description) ? $profile->description : '';
        return view(
            'back-end.admin.profile-settings.personal-detail.index',
            compact(
                'banner',
                'avater',
                'tagline',
                'description'
            )
        );
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
        $this->validate(
            $request,
            [
                'first_name'    => 'required',
                'last_name'    => 'required',
            ]
        );
        if (!empty($request)) {
            $user_id = Auth::user()->id;
            $this->profile->storeProfile($request, $user_id);
            $json['type'] = 'success';
            $json['process'] = trans('lang.saving_profile');
            return $json;
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
        $path = Helper::PublicPath() . '/uploads/users/temp/';
        if (!empty($request['hidden_avater_image'])) {
            $profile_image = $request['hidden_avater_image'];
            return Helper::uploadTempImage($path, $profile_image);
        } elseif (!empty($request['hidden_banner_image'])) {
            $profile_image = $request['hidden_banner_image'];
            return Helper::uploadTempImage($path, $profile_image);
        }
    }

    /**
     * Store project Offer
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeProjectOffers(Request $request)
    {
        $json = array();
        if (!empty($request)) {
            $offer = new Offer();
            if (Auth::user()->getRoleNames()->first() === 'employer') {
                $storeProjectOffers = $offer->saveProjectOffer($request['offer'], $request['freelancer_id']);
                if ($storeProjectOffers == "success") {
                    $json['type'] = 'success';
                    $json['progressing'] = trans('lang.send_offer');
                    $json['message'] = trans('lang.offer_sent');
                    $email_settings = SiteManagement::getMetaValue('settings');
                    $user = $this->user::find(Auth::user()->id);
                    //send email
                    if (!empty($email_settings[0]['email'])) {
                        $email_params = array();
                        $send_freelancer_offer = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_send_offer')->get()->first();
                        $message = new Message();
                        if (!empty($send_freelancer_offer->id)) {
                            $job = Job::where('id', $request['offer']['project'])->first();
                            $freelancer = User::find($request['freelancer_id']);
                            $template_data = EmailTemplate::getEmailTemplateByID($send_freelancer_offer->id);
                            $message->user_id = intval(Auth::user()->id);
                            $message->receiver_id = intval($request['freelancer_id']);
                            $message->body = $template_data->content;
                            $message->status = 0;
                            $message->save();
                            $email_params['project_title'] = $job->title;
                            $email_params['project_link'] = url('job/' . $job->slug);
                            $email_params['employer_profile'] = url('profile/' . $user->slug);
                            $email_params['emp_name'] = Helper::getUserName(Auth::user()->id);
                            $email_params['link'] = url('profile/' . $freelancer->slug);
                            $email_params['name'] = Helper::getUserName($freelancer->id);
                            $email_params['msg'] = $request['offer']['desc'];
                            Mail::to($freelancer->email)
                                ->send(
                                    new FreelancerEmailMailable(
                                        'freelancer_email_send_offer',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                    }
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.not_send_offer');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.not_authorize');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Raise Dispute
     *
     * @param mixed $slug get job slug
     *
     * @access public
     *
     * @return View
     */
    public function raiseDispute($slug)
    {
        $job = Job::where('slug', $slug)->first();
        $reasons = Helper::getReportReasons();
        return View(
            'back-end.freelancer.jobs.dispute',
            compact(
                'job',
                'reasons'
            )
        );
    }

    /**
     * Raise dispute
     *
     * @param mixed $request $req->attr
     *
     * @access public
     *
     * @return View
     */
    public function storeDispute(Request $request)
    {
        $json = array();
        $storeDispute = $this->user->saveDispute($request);
        if ($storeDispute == "success") {
            $json['type'] = 'success';
            $json['message'] = trans('lang.dispute_raised');
            $email_settings = SiteManagement::getMetaValue('settings');
            $user = $this->user::find(Auth::user()->id);
            //send email
            if (!empty($email_settings[0]['email'])) {
                $email_params = array();
                $dispute_raised_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_dispute_raised')->get()->first();
                if (!empty($dispute_raised_template->id)) {
                    $job = Job::where('id', $request['proposal_id'])->first();
                    $template_data = EmailTemplate::getEmailTemplateByID($dispute_raised_template->id);
                    $email_params['project_title'] = $job->title;
                    $email_params['project_link'] = url('job/' . $job->slug);
                    $email_params['sender_link'] = url('profile/' . $user->slug);
                    $email_params['name'] = Helper::getUserName(Auth::user()->id);
                    $email_params['msg'] = $request['description'];
                    $email_params['reason'] = $request['reason'];
                    Mail::to($email_settings[0]['email'])
                        ->send(
                            new AdminEmailMailable(
                                'admin_email_dispute_raised',
                                $template_data,
                                $email_params
                            )
                        );
                }
            }
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Raise dispute
     *
     * @access public
     *
     * @return View
     */
    public function userListing()
    {
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $users = $this->user::where('first_name', 'like', '%' . $keyword . '%')->orWhere('last_name', 'like', '%' . $keyword . '%')->paginate(7)->setPath('');
                $pagination = $users->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else {
                $users = User::select('*')->paginate(10);
            }
            return view('back-end.admin.users.index', compact('users'));
        } else {
            abort(404);
        }
    }



    

    /**
     * Get Freelancer Payouts.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayouts()
    {
        $payouts =  Payout::paginate(10);
        return view(
            'back-end.admin.payouts',
            compact('payouts')
        );
    }
}
