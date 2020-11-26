<?php
/**
 * Class EmployerController.
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
use App\Helper;
use App\Department;
use App\Location;
use App\Profile;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\User;
use Session;
use App\Language;
use App\Category;
use App\Skill;
use App\Job;
use App\Proposal;
use DB;
use App\Package;
use App\EmailTemplate;
use App\Mail\FreelancerEmailMailable;
use App\Invoice;
use App\Item;
use Carbon\Carbon;
use App\Message;

/**
 * Class EmployerController
 */
class EmployerController extends Controller
{

    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $employer
     */
    protected $employer;

    /**
     * Create a new controller instance.
     *
     * @param instance $employer instance
     *
     * @return void
     */
    public function __construct(Profile $employer)
    {
        $this->employer = $employer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = $this->employer::where('user_id', Auth::user()->id)
            ->get()->first();
        $employees = Helper::getEmployeesList();
        $departments = Department::all();
        $locations = Location::pluck('title', 'id');
        $gender = !empty($profile->gender) ? $profile->gender : '';
        $tagline = !empty($profile->tagline) ? $profile->tagline : '';
        $description = !empty($profile->description) ? $profile->description : '';
        $banner = !empty($profile->banner) ? $profile->banner : '';
        $avater = !empty($profile->avater) ? $profile->avater : '';
        $address = !empty($profile->address) ? $profile->address : '';
        $longitude = !empty($profile->longitude) ? $profile->longitude : '';
        $latitude = !empty($profile->latitude) ? $profile->latitude : '';
        $no_of_employees = !empty($profile->no_of_employees) ? $profile->no_of_employees : '';
        $department_id = !empty($profile->department_id) ? $profile->department_id : '';
        $packages = DB::table('items')->where('subscriber', Auth::user()->id)->count();
        $package_options = Package::select('options')->where('role_id', Auth::user()->id)->first();
        $options = !empty($package_options) ? unserialize($package_options['options']) : array();
        return view(
            'back-end.employer.profile-settings.personal-detail.index',
            compact(
                'employees',
                'departments',
                'locations',
                'gender',
                'tagline',
                'description',
                'banner',
                'avater',
                'address',
                'longitude',
                'latitude',
                'no_of_employees',
                'department_id',
                'options',
                'packages'
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
            $image_size = array(
                'small' => array(
                    'width' => 350,
                    'height' => 172,
                ),
                'medium' => array(
                    'width' => 1140,
                    'height' => 400,
                ),
            );
            $profile_image = $request['hidden_banner_image'];
            return Helper::uploadTempImageWithSize($path, $profile_image, '', $image_size);
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
            $request, [
                'first_name'    => 'required',
                'last_name'    => 'required',
            ]
        );
        if (!empty($request)) {
            $user_id = Auth::user()->id;
            $this->employer->storeProfile($request, $user_id);
            $json['type'] = 'success';
            $json['process'] = trans('lang.saving_profile');
            return $json;
        }
    }

    /**
     * Show Employer Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function employerDashboard()
    {
        $ongoing_jobs = array();
        $employer_id = Auth::user()->id;
        $package_item = Item::where('subscriber', $employer_id)->first();
        $package = !empty($package_item) ? Package::find($package_item->product_id) : array();
        $option = !empty($package) && !empty($package['options']) ? unserialize($package['options']) : '';
        $expiry = !empty($option) && !empty($package_item) ? $package_item->created_at->addDays($option['duration']) : '';
        $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
        $message_status = Message::where('status', 0)->where('receiver_id', $employer_id)->count();
        $notify_class = $message_status > 0 ? 'wt-insightnoticon' : '';
        if (Auth::user()) {
            $ongoing_jobs = Auth::user()->jobs->where('status', 'hired')->take(8);
            return view(
                'back-end.employer.dashboard',
                compact(
                    'ongoing_jobs',
                    'expiry_date',
                    'notify_class'
                )
            );
        }
    }

    /**
     * Show Employer Jobs.
     *
     * @param string $status job status
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmployerJobs($status)
    {
        $ongoing_jobs = array();
        $employer_id = Auth::user()->id;
        if (Auth::user()) {
            $ongoing_jobs = Job::where('user_id', $employer_id)->latest()->where('status', 'hired')->paginate(7);
            $completed_jobs = Job::where('user_id', $employer_id)->latest()->where('status', 'completed')->paginate(7);
            $cancelled_jobs = Job::where('user_id', $employer_id)->latest()->where('status', 'cancelled')->paginate(7);

            if (!empty($status) && $status === 'hired') {
                return view(
                    'back-end.employer.jobs.ongoing',
                    compact(
                        'ongoing_jobs'
                    )
                );
            } elseif (!empty($status) && $status === 'completed') {
                return view(
                    'back-end.employer.jobs.completed',
                    compact(
                        'completed_jobs'
                    )
                );
            }
        }
    }

    /**
     * Employer Payment Process.
     *
     * @param string $id proposal ID
     *
     * @return \Illuminate\Http\Response
     */
    public function employerPaymentProcess($id)
    {
        if (Auth::user() && !empty($id)) {
            if (Auth::user()) {
                $user_id = Auth::user()->id;
                $employer = User::find($user_id);
                $proposal = Proposal::where('id', $id)->get()->first();
                $job = $proposal->job;
                $freelancer = User::find($proposal->freelancer_id);
                $freelancer_name = Helper::getUserName($proposal->freelancer_id);
                $profile = User::find($proposal->freelancer_id)->profile;
                $attachments = !empty($proposal->attachments) ? unserialize($proposal->attachments) : '';
                $user_image = !empty($profile) ? $profile->avater : '';
                $profile_image = !empty($user_image) ? '/uploads/users/' . $proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
                $rating = !empty($profile->rating) ? $profile->rating : 'Not Rated Yet';
                return view(
                    'back-end.employer.jobs.checkout',
                    compact(
                        'job',
                        'freelancer_name',
                        'profile_image',
                        'proposal'
                    )
                );
            }
        } else {
            abort(404);
        }
    }
}
