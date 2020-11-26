<?php
/**
 * Class PublicController
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
use App\User;
use App\Language;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMailable;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Redirect;
use Hash;
use Auth;
use DB;
use App\Helper;
use App\Profile;
use App\Category;
use App\Location;
use App\Skill;
use Session;
use Storage;
use App\Report;
use App\Job;
use App\Proposal;
use App\EmailTemplate;
use App\Mail\GeneralEmailMailable;
use App\Mail\AdminEmailMailable;
use App\SiteManagement;
use App\Review;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Payout;

/**
 * Class PublicController
 *
 */
class PublicController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $email_settings = SiteManagement::getMetaValue('settings');
        if (!empty($email_settings[0]['email'])) {
            config(['mail.username' => $email_settings[0]['email']]);
        }
    }


    /**
     * User Login Function
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function loginUser(Request $request)
    {
        $json = array();
        if (Session::has('user_id')) {
            $id = Session::get('user_id');
            $user = User::find($id);
            Auth::login($user);
            $json['type'] = 'success';
            $json['role'] = $user->getRoleNames()->first();
            session()->forget('user_id');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Step1 Registeration Validation
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function registerStep1Validation(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
            ]
        );
    }

    /**
     * Step2 Registeration Validation
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function registerStep2Validation(Request $request)
    {
        $this->validate(
            $request,
            [
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'termsconditions' => 'required',
            ]
        );
    }

    /**
     * Set slug before saving in DB
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyUserCode(Request $request)
    {
        $json = array();
        if (Session::has('user_id')) {
            $id = Session::get('user_id');
            $email = Session::get('email');
            $password = Session::get('password');
            $user = User::find($id);
            if (!empty($request['code'])) {
                if ($request['code'] === $user->verification_code) {
                    $user->user_verified = 1;
                    $user->verification_code = null;
                    $user->save();
                    $json['type'] = 'success';
                    //send mail
                    $email_settings = SiteManagement::getMetaValue('settings');
                    if (!empty($email_settings[0]['email'])) {
                        $email_params = array();
                        $template = DB::table('email_types')->select('id')->where('email_type', 'new_user')->get()->first();
                        if (!empty($template->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                            $email_params['name'] = Helper::getUserName($id);
                            $email_params['email'] = $email;
                            $email_params['password'] = $password;
                            Mail::to($email)
                                ->send(
                                    new GeneralEmailMailable(
                                        'new_user',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                    }
                    if (!empty($email_settings[0]['email'])) {
                        $email_params = array();
                        $template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_registration')->get()->first();
                        if (!empty($template->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                            $email_params['name'] = Helper::getUserName($id);
                            $email_params['email'] = $email;
                            $email_params['link'] = url('profile/' . $user->slug);
                            Mail::to($email_settings[0]['email'])
                                ->send(
                                    new AdminEmailMailable(
                                        'admin_email_registration',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                    }
                    session()->forget('password');
                    session()->forget('email');
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.invalid_verify_code');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.verify_code');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.session_expire');
            return $json;
        }
    }

    /**
     * Download file.
     *
     * @param type    $type     file type
     * @param string  $filename file typname
     * @param integer $id       id
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    function getFile($type, $filename, $id)
    {
        if (!empty($type) && !empty($filename) && !empty($id)) {
            if (Storage::disk('local')->exists('uploads/' . $type . '/' . $id . '/' . $filename)) {
                return Storage::download('uploads/' . $type . '/' . $id . '/' . $filename);
            } else {
                Session::flash('error', trans('lang.file_not_found'));
                return Redirect::back();
            }
        } else {
            abort(404);
        }
    }

    /**
     * Show user profile.
     *
     * @param string $slug slug
     *
     * @return \Illuminate\Http\Response
     */
    public function showUserProfile($slug)
    {
        $user = User::select('id')->where('slug', $slug)->first();
        if (!empty($user)) {
            $user = User::find($user->id);
            $skills = $user->skills()->get();
            $job = Job::where('user_id', $user->id)->get();
            $profile = Profile::all()->where('user_id', $user->id)->first();
            $reasons = Helper::getReportReasons();
            $avatar = !empty($profile->avater) ? '/uploads/users/' . $profile->user_id . '/' . $profile->avater : '/images/user.jpg';
            $banner = !empty($profile->banner) ? '/uploads/users/' . $profile->user_id . '/' . $profile->banner : Helper::getUserProfileBanner($user->id);
            $auth_user = Auth::user() ? true : false;
            $user_name = Helper::getUserName($profile->user_id);
            $current_date = Carbon::now()->format('M d, Y');
            if ($user->getRoleNames()->first() === 'freelancer') {
                //$user = User::find($profile->user_id);
                $reviews = Review::where('receiver_id', $user->id)->get();
                $awards = !empty($profile->awards) ? unserialize($profile->awards) : array();
                $projects = !empty($profile->projects) ? unserialize($profile->projects) : array();
                $experiences = !empty($profile->experience) ? unserialize($profile->experience) : array();
                $education = !empty($profile->education) ? unserialize($profile->education) : array();
                $rating  = $reviews->sum('avg_rating') != 0 ? round($reviews->sum('avg_rating') / $reviews->count()) : 0;
                $joining_date = !empty($profile->created_at) ? Carbon::parse($profile->created_at)->format('M d, Y') : '';
                $jobs = Job::select('title', 'id')->get()->pluck('title', 'id');
                $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ? unserialize(auth()->user()->profile->saved_freelancer) : array();
                $badge = Helper::getUserBadge($user->id);
                $feature_class = !empty($badge) ? 'wt-featured' : '';
                $badge_color = !empty($badge) ? $badge->color : '';
                $badge_img  = !empty($badge) ? $badge->image : '';
                $amount = Payout::where('user_id', $user->id)->select('amount')->pluck('amount')->first();
                $employer_projects = Auth::user() ? Helper::getEmployerJobs(Auth::user()->id) : array();
                $payment_settings = SiteManagement::getMetaValue('payment_settings');
                $currency_symbol  = !empty($payment_settings[0]['currency']) ? $payment_settings[0]['symbol'] : '$';
                return View(
                    'front-end.users.freelancer-show',
                    compact(
                        'profile',
                        'amount',
                        'skills',
                        'user',
                        'job',
                        'reasons',
                        'reviews',
                        'avatar',
                        'banner',
                        'user_name',
                        'jobs',
                        'rating',
                        'education',
                        'experiences',
                        'projects',
                        'awards',
                        'joining_date',
                        'save_freelancer',
                        'auth_user',
                        'badge',
                        'feature_class',
                        'badge_color',
                        'badge_img',
                        'employer_projects',
                        'currency_symbol',
                        'current_date'
                    )
                );
            } elseif ($user->getRoleNames()->first() === 'employer') {
                $jobs = Job::where('user_id', $profile->user_id)->latest()->paginate(7);
                $followers = DB::table('followers')->where('following', $profile->user_id)->get();
                $save_employer = !empty(auth()->user()->profile->saved_employers) ? unserialize(auth()->user()->profile->saved_employers) : array();
                $save_jobs = !empty(auth()->user()->profile->saved_jobs) ? unserialize(auth()->user()->profile->saved_jobs) : array();
                return View(
                    'front-end.users.employer-show',
                    compact(
                        'profile',
                        'skills',
                        'user',
                        'job',
                        'reasons',
                        'avatar',
                        'banner',
                        'user_name',
                        'jobs',
                        'followers',
                        'save_employer',
                        'save_jobs',
                        'auth_user',
                        'current_date'
                    )
                );
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get filtered list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFilterlist()
    {
        $json = array();
        $filters = Helper::getSearchFilterList();
        if (!empty($filters)) {
            $json['type'] = 'success';
            $json['result'] = $filters;
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get searchable data.
     *
     * @param mixed $request request->attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getSearchableData(Request $request)
    {
        $json = array();
        if (!empty($request['type'])) {
            $searchables = Helper::getSearchableList($request['type']);
            if (!empty($searchables)) {
                $json['type'] = 'success';
                $json['searchables'] = $searchables;
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get search result.
     *
     * @param string $search_type search type
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getSearchResult($search_type = "")
    {
        $categories = array();
        $locations  = array();
        $languages  = array();
        $categories = Category::all();
        $locations  = Location::all();
        $languages  = Language::all();
        $skills     = Skill::all();
        $currency   = SiteManagement::getMetaValue('payment_settings');
        $symbol     = !empty($currency) ? Helper::currencyList($currency[0]['currency']) : array();
        $freelancer_skills = Helper::getFreelancerLevelList();
        $project_length = Helper::getJobDurationList();
        $Jobs_total_records = Job::count();
        $users_total_records = User::count();
        $keyword = !empty($_GET['s']) ? $_GET['s'] : '';
        $type = !empty($_GET['type']) ? $_GET['type'] : $search_type;
        $search_categories = !empty($_GET['category']) ? $_GET['category'] : array();
        $search_locations = !empty($_GET['locations']) ? $_GET['locations'] : array();
        $search_skills = !empty($_GET['skills']) ? $_GET['skills'] : array();
        $search_project_lengths = !empty($_GET['project_lengths']) ? $_GET['project_lengths'] : array();
        $search_languages = !empty($_GET['languages']) ? $_GET['languages'] : array();
        $search_employees = !empty($_GET['employees']) ? $_GET['employees'] : array();
        $search_hourly_rates = !empty($_GET['hourly_rate']) ? $_GET['hourly_rate'] : array();
        $search_freelaner_types = !empty($_GET['freelaner_type']) ? $_GET['freelaner_type'] : array();
        $search_english_levels = !empty($_GET['english_level']) ? $_GET['english_level'] : array();
        $current_date = Carbon::now()->toDateTimeString();
        if (!empty($_GET['type'])) {
            if ($type != 'job') {
                $search =  User::getSearchResult(
                    $type,
                    $keyword,
                    $search_locations,
                    $search_employees,
                    $search_skills,
                    $search_hourly_rates,
                    $search_freelaner_types,
                    $search_english_levels,
                    $search_languages
                );
                $users = count($search['users']) > 0 ? $search['users'] : '';
                $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ?
                    unserialize(auth()->user()->profile->saved_freelancer) : array();
                $save_employer = !empty(auth()->user()->profile->saved_employers) ?
                    unserialize(auth()->user()->profile->saved_employers) : array();
                if ($type === 'employer') {
                    return view(
                        'front-end.employers.index',
                        compact(
                            'users',
                            'locations',
                            'languages',
                            'freelancer_skills',
                            'project_length',
                            'keyword',
                            'type',
                            'users_total_records',
                            'save_employer',
                            'current_date'
                        )
                    );
                } elseif ($type === 'freelancer') {
                    return view(
                        'front-end.freelancers.index',
                        compact(
                            'type',
                            'users',
                            'categories',
                            'locations',
                            'languages',
                            'skills',
                            'project_length',
                            'keyword',
                            'users_total_records',
                            'save_freelancer',
                            'symbol',
                            'current_date'
                        )
                    );
                }
            } else {
                $results = Job::getSearchResult(
                    $keyword,
                    $search_categories,
                    $search_locations,
                    $search_skills,
                    $search_project_lengths,
                    $search_languages
                );
                $jobs = $results['jobs'];
                if (!empty($jobs)) {
                    return view(
                        'front-end.jobs.index',
                        compact(
                            'jobs',
                            'categories',
                            'locations',
                            'languages',
                            'freelancer_skills',
                            'project_length',
                            'Jobs_total_records',
                            'keyword',
                            'skills',
                            'type',
                            'current_date'
                        )
                    );
                }
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get Pass Reset Form
     *
     * @param mixed $verification_code verification_code
     *
     * @access public
     *
     * @return View
     */
    public function resetPasswordView($verification_code)
    {
        if (!empty($verification_code)) {
            session()->put(['verification_code' => $verification_code]);
            return View('front-end.reset-password');
        } else {
            abort(404);
        }
    }

    /**
     * Reset user password.
     *
     * @param mixed $request req->attr
     *
     * @access public
     *
     * @return View
     */
    public function resetUserPassword(Request $request)
    {
        if (Session::has('verification_code')) {
            $verification_code = Session::get('verification_code');
            if (!empty($request)) {
                $this->validate(
                    $request,
                    [
                        'new_password' => 'required',
                        'confirm_password' => 'required',
                    ]
                );
                $user_id = User::select('verification_code', 'id')
                    ->where('verification_code', $verification_code)
                    ->pluck('id')->first();
                $user = User::find($user_id);
                if ($request->new_password === $request->confirm_password) {
                    if ($verification_code === $user->verification_code) {
                        $user->password = Hash::make($request->confirm_password);
                        $user->verification_code = null;
                        $user->save();
                        Auth::logout();
                        session()->forget('verification_code');
                        return Redirect::to('/');
                    } else {
                        Session::flash('error', trans('lang.invalid_verify_code'));
                        return Redirect::back();
                    }
                } else {
                    Session::flash('error', trans('lang.pass_mismatched'));
                    return Redirect::back();
                }
            } else {
                Session::flash('error', trans('lang.something_wrong'));
                return Redirect::back();
            }
        } else {
            Session::flash('error', trans('lang.invalid_verify_code'));
            return Redirect::back();
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return View
     */
    public function checkProposalAuth()
    {
        $json = array();
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'freelancer') {
            $json['auth'] = true;
            return $json;
        } else {
            $json['auth'] = false;
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return View
     */
    public function getFreelancerExperience(Request $request)
    {
        $json = array();
        $id = $request['id'];
        $freelancer = User::find($id);
        if (!empty($freelancer)) {
            $json['type'] = 'success';
            $json['experience'] = unserialize($freelancer->profile->experience);
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return View
     */
    public function getFreelancerEducation(Request $request)
    {
        $json = array();
        $id = $request['id'];
        $freelancer = User::find($id);
        if (!empty($freelancer)) {
            $json['type'] = 'success';
            $json['education'] = unserialize($freelancer->profile->education);
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }
}
