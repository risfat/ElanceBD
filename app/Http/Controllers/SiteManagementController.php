<?php
/**
 * Class SiteManagementController
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
use Session;
use Storage;
use App\Report;
use App\Job;
use App\Proposal;
use App\SiteManagement;
use App\Page;
use Illuminate\Support\Arr;

/**
 * Class SiteManagementController
 *
 */
class SiteManagementController extends Controller
{

    /**
     * Defining scope of variable
     *
     * @access public
     * @var    array $category
     */
    protected $settings;

    /**
     * Create a new controller instance.
     *
     * @param mixed $settings get sitemanagement model
     *
     * @return void
     */
    public function __construct(SiteManagement $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Show site settings form.
     *
     * @access public
     *
     * @return View
     */
    public function settings()
    {
        $client_id = '';
        $payment_password = '';
        $existing_payment_secret = '';
        $data = $this->settings::getMetaValue('email_data');
        $from_email = !empty($data[0]['from_email']) ? $data[0]['from_email'] : null;
        $from_email_id = !empty($data[0]['from_email_id']) ? $data[0]['from_email_id'] : null;
        $sender_name = !empty($data[0]['sender_name']) ? $data[0]['sender_name'] : null;
        $sender_tagline = !empty($data[0]['sender_tagline']) ? $data[0]['sender_tagline'] : null;
        $sender_url = !empty($data[0]['sender_url']) ? $data[0]['sender_url'] : null;
        $email_logo = !empty($data[0]['email_logo']) ? $data[0]['email_logo'] : null;
        $email_banner = !empty($data[0]['email_banner']) ? $data[0]['email_banner'] : null;
        $sender_avatar = !empty($data[0]['sender_avatar']) ? $data[0]['sender_avatar'] : null;
        $settings = $this->settings::getMetaValue('settings');
        $title = !empty($settings[0]['title']) ? $settings[0]['title'] : null;
        $email = !empty($settings[0]['email']) ? $settings[0]['email'] : null;
        $connects_per_job = !empty($settings[0]['connects_per_job']) ? $settings[0]['connects_per_job'] : null;
        $gmap_api_key = !empty($settings[0]['gmap_api_key']) ? $settings[0]['gmap_api_key'] : null;
        $logo = !empty($settings[0]['logo']) ? $settings[0]['logo'] : null;
        $payout_settings = $this->settings::getMetaValue('commision');
        $commision = !empty($payout_settings[0]['commision']) ? $payout_settings[0]['commision'] : null;
        $payment_gateway = !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : null;
        $min_payout = !empty($payout_settings[0]['min_payout']) ? $payout_settings[0]['min_payout'] : 0;
        $existing_payment_settings = $this->settings::getMetaValue('payment_settings');
        $client_id = !empty($existing_payment_settings[0]['client_id']) ? $existing_payment_settings[0]['client_id'] : '';
        $payment_password = !empty($existing_payment_settings[0]['paypal_password']) ? $existing_payment_settings[0]['paypal_password'] : '';
        $existing_payment_secret = !empty($existing_payment_settings[0]['paypal_secret']) ? $existing_payment_settings[0]['paypal_secret'] : '';
        $existing_currency = !empty($existing_payment_settings[0]['currency']) ? $existing_payment_settings[0]['currency'] : '';
        $footer_settings = $this->settings::getMetaValue('footer_settings');
        $footer_logo = !empty($footer_settings['footer_logo']) ? $footer_settings['footer_logo'] : null;
        $footer_desc = !empty($footer_settings['description']) ? $footer_settings['description'] : null;
        $footer_copyright = !empty($footer_settings['copyright']) ? $footer_settings['copyright'] : 'Worketic. All Rights Reserved.';
        $menu_pages = !empty($footer_settings['pages']) ? $footer_settings['pages'] : array();
        $menu_pages_1 = !empty($footer_settings['menu_pages_1']) ? $footer_settings['menu_pages_1'] : array();
        $menu_title_1 = !empty($footer_settings['menu_title_1']) ? $footer_settings['menu_title_1'] : '';
        $menu_title_2 = !empty($footer_settings['menu_title_2']) ? $footer_settings['menu_title_2'] : '';
        $pages = Page::select('title', 'id')->get()->pluck('title', 'id');
        $social_list = Helper::getSocialData();
        $social_unserialize_array = SiteManagement::getMetaValue('socials');
        $unserialize_menu_array = SiteManagement::getMetaValue('search_menu');
        $menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
        $currency = array_pluck(Helper::currencyList(), 'code', 'code');
        $payment_methods = Helper::getPaymentMethodList();
        return view(
            'back-end.admin.settings.index',
            compact(
                'from_email', 'from_email_id', 'sender_name',
                'sender_tagline', 'sender_url', 'email_logo', 'email_banner',
                'sender_avatar', 'title', 'email', 'logo', 'commision',
                'existing_payment_settings', 'connects_per_job', 'footer_logo',
                'footer_desc', 'social_list', 'social_unserialize_array',
                'footer_copyright', 'pages', 'menu_pages', 'menu_pages_1',
                'unserialize_menu_array', 'menu_title_1', 'menu_title_2', 'menu_title',
                'client_id', 'payment_password', 'existing_payment_secret',
                'currency', 'existing_currency', 'gmap_api_key', 'min_payout',
                'payment_methods', 'payment_gateway'
            )
        );
    }

    /**
     * Show home page settings form.
     *
     * @access public
     *
     * @return View
     */
    public function homePageSettings()
    {
        $home_settings = $this->settings::getMetaValue('home_settings');
        $banner_bg = !empty($home_settings[0]['home_banner']) ? $home_settings[0]['home_banner'] : null;
        $banner_bg_image = !empty($home_settings[0]['home_banner_image']) ? $home_settings[0]['home_banner_image'] : null;
        $banner_title = !empty($home_settings[0]['banner_title']) ? $home_settings[0]['banner_title'] : 'Hire expert freelancers';
        $banner_subtitle = !empty($home_settings[0]['banner_subtitle']) ? $home_settings[0]['banner_subtitle'] : 'for any job, Online';
        $banner_description = !empty($home_settings[0]['banner_description']) ? $home_settings[0]['banner_description'] : null;
        $banner_video_link = !empty($home_settings[0]['video_link']) ? $home_settings[0]['video_link'] : null;
        $banner_video_title = !empty($home_settings[0]['video_title']) ? $home_settings[0]['video_title'] : null;
        $banner_video_desc = !empty($home_settings[0]['video_desc']) ? $home_settings[0]['video_desc'] : null;
        $section_bg = !empty($home_settings[0]['section_bg']) ? $home_settings[0]['section_bg'] : null;
        $company_title = !empty($home_settings[0]['company_title']) ? $home_settings[0]['company_title'] : null;
        $company_desc = !empty($home_settings[0]['company_desc']) ? $home_settings[0]['company_desc'] : null;
        $company_url = !empty($home_settings[0]['company_url']) ? $home_settings[0]['company_url'] : null;
        $freelancer_title = !empty($home_settings[0]['freelancer_title']) ? $home_settings[0]['freelancer_title'] : null;
        $freelancer_desc = !empty($home_settings[0]['freelancer_desc']) ? $home_settings[0]['freelancer_desc'] : null;
        $freelancer_url = !empty($home_settings[0]['freelancer_url']) ? $home_settings[0]['freelancer_url'] : null;
        $download_app_img = !empty($home_settings[0]['download_app_img']) ? $home_settings[0]['download_app_img'] : null;
        $app_title = !empty($home_settings[0]['app_title']) ? $home_settings[0]['app_title'] : null;
        $app_subtitle = !empty($home_settings[0]['app_subtitle']) ? $home_settings[0]['app_subtitle'] : null;
        $app_desc = $this->settings::where('meta_key', 'app_desc')->select('meta_value')->pluck('meta_value')->first();
        $app_android_link = $this->settings::where('meta_key', 'app_android_link')->select('meta_value')->pluck('meta_value')->first();
        $app_ios_link = $this->settings::where('meta_key', 'app_ios_link')->select('meta_value')->pluck('meta_value')->first();
        return view(
            'back-end.admin.home-page-settings.index',
            compact(
                'banner_title', 'banner_subtitle', 'banner_description',
                'banner_video_link', 'banner_video_title', 'banner_video_desc',
                'banner_bg', 'banner_bg_image', 'company_title', 'company_desc',
                'company_url', 'freelancer_title', 'freelancer_desc',
                'freelancer_url', 'section_bg', 'download_app_img',
                'app_title', 'app_subtitle', 'app_desc', 'app_android_link',
                'app_ios_link'
            )
        );
    }

    /**
     * Store Email Settings
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeEmailSettings(Request $request)
    {
        $json = array();
        if (!empty($request['email_data'])) {
            $store_email_settings
                = $this->settings->saveEmailSettings($request['email_data']);
            if ($store_email_settings == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        }
    }


    /**
     * Store home settings
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeHomeSettings(Request $request)
    {
        $json = array();
        if (!empty($request)) {
            $store_home_settings = SiteManagement::saveHomeSettings($request['home'], $request);
            if ($store_home_settings == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        }
    }

    /**
     * Store general Settings
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeGeneralSettings(Request $request)
    {
        $json = array();
        if (!empty($request['settings'])) {
            $store_email_settings
                = $this->settings->saveSettings($request['settings']);
            if ($store_email_settings == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        }
    }

    /**
     * Store Footer Settings
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeFooterSettings(Request $request)
    {
        $json = array();
        if (!empty($request['footer'])) {
            $footer_settings = $this->settings->saveFooterSettings($request['footer']);
            if ($footer_settings == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
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
     * Store social settings
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeSocialSettings(Request $request)
    {
        $json = array();
        if (!empty($request['social'])) {
            $social_settings = $this->settings->saveSocialSettings($request['social']);
            if ($social_settings == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
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
     * Store search menu.
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeSearchMenu(Request $request)
    {
        $this->validate(
            $request,
            [
                'menu_title' => 'required',
                'search.*.title' => 'required',
                'search.*.url' => 'required',
            ]
        );
        $json = array();
        if (!empty($request)) {
            $search_menu = $this->settings->saveSearchMenu($request);
            if ($search_menu['type'] == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
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
     * Store commision settings
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storeCommisionSettings(Request $request)
    {

        $json = array();
        if (!empty($request['payment'])) {
            $default_settings = $this->settings->saveCommisionSettings($request['payment']);
            if ($default_settings == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
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
     * Store payment settings
     *
     * @param mixed $request get req attributes
     *
     * @access public
     *
     * @return View
     */
    public function storePaymentSettings(Request $request)
    {
        $this->validate(
            $request,
            [
                'client_id' => 'required',
                'paypal_password' => 'required',
                'paypal_secret' => 'required',
            ]
        );
        $json = array();
        if (!empty($request)) {
            $default_settings = $this->settings->savePaymentSettings($request);
            if ($default_settings == "success") {
                $json['type'] = 'success';
                $json['progressing'] = trans('lang.saving');
                $json['message'] = trans('lang.settings_saved');
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
     * Upload Image to temporary folder.
     *
     * @param mixed  $request   request attributes
     * @param string $file_name getfilename
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request, $file_name = '')
    {
        $path = Helper::PublicPath() . '/uploads/settings/temp/';
        if (!empty($request[$file_name])) {
            Helper::uploadSingleTempImage($path, $request[$file_name]);
        }
    }

    /**
     * Import Demo content.
     *
     * @return \Illuminate\Http\Response
     */
    public function importDemo()
    {
        \Artisan::call('migrate:fresh');
        \Artisan::call('db:seed');
        return redirect()->back();
    }

    /**
     * Remove Demo content.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeDemoContent()
    {
        \Artisan::call('migrate:fresh');
        \Artisan::call('db:seed --class=RoleTableSeeder');
        return redirect()->back();
    }
}
