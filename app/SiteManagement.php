<?php
/**
 * Class SiteManagement
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Validator;
use File;
use Storage;
use Illuminate\Support\Arr;
use Carbon\Carbon;

/**
 * Class SiteManagement
 *
 */
class SiteManagement extends Model
{
    /**
     * Add Fillables
     *
     * @access protected
     *
     * @var array $fillable
     *
     * @return mixed
     */
    protected $fillable = array('meta_key', 'meta_value	');

    /**
     * Get Meta Values form meta keys.
     *
     * @param string $meta_key meta_key
     *
     * @return \Illuminate\Http\Response
     */
    public static function getMetaValue($meta_key)
    {
        if (!empty($meta_key)) {
            $data = DB::table('site_managements')->select('meta_value')->where('meta_key', $meta_key)->get()->first();
            if (!empty($data)) {
                return unserialize($data->meta_value);
            }
        }
    }

    /**
     * Save email setttings
     *
     * @param string $email_data Email data
     *
     * @return \Illuminate\Http\Response
     */
    public static function saveEmailSettings($email_data)
    {
        $email_data_array = array();
        if (!empty($email_data)) {
            $old_path = Helper::PublicPath() . '/uploads/settings/temp';
            if (!file_exists($old_path)) {
                File::makeDirectory($old_path, $mode = 0777, true, true);
            }
            $new_path = Helper::PublicPath() . '/uploads/settings/email';
            foreach ($email_data as $key => $email) {
                $email_data_array[$key]['from_email'] = $email['from_email'];
                $email_data_array[$key]['from_email_id'] = $email['from_email_id'];
                $email_data_array[$key]['sender_name'] = $email['sender_name'];
                $email_data_array[$key]['sender_tagline'] = $email['sender_tagline'];
                $email_data_array[$key]['sender_url'] = $email['sender_url'];
                if (!empty($email['email_logo'])) {
                    if (file_exists($old_path . '/' . $email['email_logo'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $email['email_logo'];
                        rename($old_path . '/' . $email['email_logo'], $new_path . '/' . $filename);
                        $email_data_array[$key]['email_logo'] = $filename;
                    } else {
                        $email_data_array[$key]['email_logo'] = $email['email_logo'];
                    }
                }
                if (!empty($email['email_banner'])) {
                    if (file_exists($old_path . '/' . $email['email_banner'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $email['email_banner'];
                        rename($old_path . '/' . $email['email_banner'], $new_path . '/' . $filename);
                        $email_data_array[$key]['email_banner'] = $filename;
                    } else {
                        $email_data_array[$key]['email_banner'] = $email['email_banner'];
                    }
                }
                if (!empty($email['sender_avatar'])) {
                    if (file_exists($old_path . '/' . $email['sender_avatar'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $email['sender_avatar'];
                        rename($old_path . '/' . $email['sender_avatar'], $new_path . '/' . $filename);
                        $email_data_array[$key]['sender_avatar'] = $filename;
                    } else {
                        $email_data_array[$key]['sender_avatar'] = $email['sender_avatar'];
                    }
                }
            }
            $existing_data = SiteManagement::getMetaValue('email_data');
            if (!empty($existing_data)) {
                DB::table('site_managements')->where('meta_key', '=', 'email_data')->delete();
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'email_data', 'meta_value' => serialize($email_data_array),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            return 'success';
        }
    }

    /**
     * Save settings
     *
     * @param string $settings meta_key
     *
     * @return \Illuminate\Http\Response
     */
    public static function saveSettings($settings)
    {
        $settings_array = array();
        if (!empty($settings)) {
            $old_path = Helper::PublicPath() . '/uploads/settings/temp';
            $new_path = Helper::PublicPath() . '/uploads/settings/general';
            foreach ($settings as $key => $setting) {
                $settings_array[$key]['title'] = $setting['title'];
                $settings_array[$key]['email'] = $setting['email'];
                $settings_array[$key]['connects_per_job'] = $setting['connects_per_job'];
                $settings_array[$key]['gmap_api_key'] = $setting['gmap_api_key'];
                if (!empty($setting['logo'])) {
                    if (file_exists($old_path . '/' . $setting['logo'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $setting['logo'];
                        rename($old_path . '/' . $setting['logo'], $new_path . '/' . $filename);
                        $settings_array[$key]['logo'] = $filename;
                    } else {
                        $settings_array[$key]['logo'] = $setting['logo'];
                    }
                }
            }
            $existing_data = SiteManagement::getMetaValue('settings');
            if (!empty($existing_data)) {
                DB::table('site_managements')->where('meta_key', '=', 'settings')->delete();
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'settings', 'meta_value' => serialize($settings_array),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            return 'success';
        }
    }

    /**
     * Save footer settings
     *
     * @param string $footer_settings footer settings
     *
     * @return \Illuminate\Http\Response
     */
    public static function saveFooterSettings($footer_settings)
    {
        if (!empty($footer_settings)) {
            $old_path = Helper::PublicPath() . '/uploads/settings/temp';
            $new_path = Helper::PublicPath() . '/uploads/settings/footer';
            $filename = $footer_settings['footer_logo'];
            if (file_exists($old_path . '/' . $footer_settings['footer_logo'])) {
                if (!file_exists($new_path)) {
                    File::makeDirectory($new_path, $mode = 0777, true, true);
                }
                $filename = time() . '-' . $footer_settings['footer_logo'];
                rename($old_path . '/' . $footer_settings['footer_logo'], $new_path . '/' . $filename);
                $footer_settings['footer_logo'] = $filename;
            }
            $existing_data = SiteManagement::getMetaValue('footer_settings');
            if (!empty($existing_data)) {
                DB::table('site_managements')->where('meta_key', '=', 'footer_settings')->delete();
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'footer_settings', 'meta_value' => serialize($footer_settings),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            return 'success';
        }
    }

    /**
     * Save social settings
     *
     * @param string $request req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public static function saveSocialSettings($request)
    {
        $socials = $request;
        if (!empty($socials)) {
            foreach ($socials as $key => $value) {
                if (($value['title'] == 'select social icon' || $value['url'] == null)) {
                    return 'error';
                }
            }
            $existing_social = SiteManagement::getMetaValue('socials');
            if (!empty($existing_social)) {
                DB::table('site_managements')->where('meta_key', '=', 'socials')->delete();
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'socials', 'meta_value' => serialize($socials),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            return 'success';
        }
    }

    /**
     * Save search menu
     *
     * @param string $request req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public static function saveSearchMenu($request)
    {
        $json = array();
        $menu_title = $request['menu_title'];
        $menu = $request['search'];
        if (!empty($menu)) {
            $existing_menu_item = SiteManagement::getMetaValue('search_menu');
            if (!empty($existing_menu_item)) {
                DB::table('site_managements')->where('meta_key', '=', 'search_menu')->delete();
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'search_menu', 'meta_value' => serialize($menu),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'menu_title', 'meta_value' => $menu_title,
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            $json['type'] = 'success';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Save commision settings
     *
     * @param string $commision_settings commision settings
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCommisionSettings($commision_settings)
    {
        $commision_settings_array = array();
        if (!empty($commision_settings)) {
            foreach ($commision_settings as $key => $setting) {
                $commision_settings_array[$key]['commision'] = $setting['commision'];
                $commision_settings_array[$key]['min_payout'] = $setting['min_payout'];
                $commision_settings_array[$key]['payment_method'] = $setting['payment_method'];
            }
            $existing_data = SiteManagement::getMetaValue('commision');
            if (!empty($existing_data)) {
                DB::table('site_managements')->where('meta_key', '=', 'commision')->delete();
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'commision', 'meta_value' => serialize($commision_settings_array),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            return 'success';
        }
    }

    /**
     * Get Meta Values form meta keys.
     *
     * @param string $request meta_key
     *
     * @return \Illuminate\Http\Response
     */
    public function savePaymentSettings($request)
    {
        $client_id = $request['client_id'];
        $paypal_password = $request['paypal_password'];
        $paypal_secret = $request['paypal_secret'];
        $paypal_currency = $request['currency'];
        $payment_settings = array();
        $payment_settings[0]['client_id'] = $client_id;
        $payment_settings[0]['paypal_password'] = $paypal_password;
        $payment_settings[0]['paypal_secret'] = $paypal_secret;
        $payment_settings[0]['currency'] = $paypal_currency;
        if (!empty($payment_settings)) {
            $existing_payment_settings = SiteManagement::getMetaValue('payment_settings');
            if (!empty($existing_payment_settings)) {
                DB::table('site_managements')->where('meta_key', '=', 'payment_settings')->delete();
                Helper::changeEnv(
                    [
                        'PAYPAL_SANDBOX_API_USERNAME' => "",
                        'PAYPAL_SANDBOX_API_PASSWORD' => "",
                        'PAYPAL_SANDBOX_API_SECRET' => "",
                        'PAYPAL_LIVE_API_USERNAME' => "",
                        'PAYPAL_LIVE_API_PASSWORD' => "",
                        'PAYPAL_LIVE_API_SECRET' => "",
                        'PAYMENT_SYMBOL' => "USD",
                    ]
                );
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'payment_settings', 'meta_value' => serialize($payment_settings),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            Helper::changeEnv(
                [
                    'PAYPAL_LIVE_API_USERNAME' => $client_id,
                    'PAYPAL_LIVE_API_PASSWORD' => $paypal_password,
                    'PAYPAL_LIVE_API_SECRET' => $paypal_secret,
                    'PAYMENT_SYMBOL' => $paypal_currency,
                ]
            );
            return 'success';
        }
    }

    /**
     * Get Meta Values form meta keys.
     *
     * @param string $home_settings meta_key
     *
     * @return \Illuminate\Http\Response
     */
    public static function saveHomeSettings($home_settings, $request)
    {
        if (!empty($home_settings) || !empty($request)) {
            $old_path = Helper::PublicPath() . '/uploads/settings/temp';
            $new_path = Helper::PublicPath() . '/uploads/settings/home';
            foreach ($home_settings as $key => $home) {
                $home_settings[$key]['banner_title'] = $home['banner_title'];
                $home_settings[$key]['banner_subtitle'] = $home['banner_subtitle'];
                $home_settings[$key]['banner_description'] = $home['banner_description'];
                $home_settings[$key]['video_link'] = $home['video_link'];
                $home_settings[$key]['video_title'] = $home['video_title'];
                $home_settings[$key]['video_desc'] = $home['video_desc'];
                $home_settings[$key]['company_title'] = $home['company_title'];
                $home_settings[$key]['company_desc'] = $home['company_desc'];
                $home_settings[$key]['company_url'] = $home['company_url'];
                $home_settings[$key]['freelancer_title'] = $home['freelancer_title'];
                $home_settings[$key]['freelancer_desc'] = $home['freelancer_desc'];
                $home_settings[$key]['freelancer_url'] = $home['freelancer_url'];
                $home_settings[$key]['app_title'] = $home['app_title'];
                $home_settings[$key]['app_subtitle'] = $home['app_subtitle'];
                if (!empty($home['home_banner_image'])) {
                    if (file_exists($old_path . '/' . $home['home_banner_image'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $home['home_banner_image'];
                        rename($old_path . '/' . $home['home_banner_image'], $new_path . '/' . $filename);
                        $home_settings[$key]['home_banner_image'] = $filename;
                    }
                }
                if (!empty($home['home_banner'])) {
                    if (file_exists($old_path . '/' . $home['home_banner'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $home['home_banner'];
                        rename($old_path . '/' . $home['home_banner'], $new_path . '/' . $filename);
                        $home_settings[$key]['home_banner'] = $filename;
                    }
                }
                if (!empty($home['section_bg'])) {
                    if (file_exists($old_path . '/' . $home['section_bg'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $home['section_bg'];
                        rename($old_path . '/' . $home['section_bg'], $new_path . '/' . $filename);
                        $home_settings[$key]['section_bg'] = $filename;
                    }
                }
                if (!empty($home['download_app_img'])) {
                    if (file_exists($old_path . '/' . $home['download_app_img'])) {
                        if (!file_exists($new_path)) {
                            File::makeDirectory($new_path, $mode = 0777, true, true);
                        }
                        $filename = time() . '-' . $home['download_app_img'];
                        rename($old_path . '/' . $home['download_app_img'], $new_path . '/' . $filename);
                        $home_settings[$key]['download_app_img'] = $filename;
                    }
                }
            }
            $existing_data = SiteManagement::getMetaValue('home_settings');
            if (!empty($existing_data)) {
                DB::table('site_managements')->where('meta_key', '=', 'home_settings')->delete();
            }
            DB::table('site_managements')->insert(
                [
                    'meta_key' => 'home_settings', 'meta_value' => serialize($home_settings),
                    "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                ]
            );
            if (!empty($request['app_desc'])) {
                DB::table('site_managements')->where('meta_key', '=', 'app_desc')->delete();
                DB::table('site_managements')->insert(
                    [
                        'meta_key' => 'app_desc', 'meta_value' => $request['app_desc'],
                        "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                    ]
                );
            }
            if (!empty($request['app_android_link'])) {
                DB::table('site_managements')->where('meta_key', '=', 'app_android_link')->delete();
                DB::table('site_managements')->insert(
                    [
                        'meta_key' => 'app_android_link', 'meta_value' => $request['app_android_link'],
                        "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                    ]
                );
            }
            if (!empty($request['app_ios_link'])) {
                DB::table('site_managements')->where('meta_key', '=', 'app_ios_link')->delete();
                DB::table('site_managements')->insert(
                    [
                        'meta_key' => 'app_ios_link', 'meta_value' => $request['app_ios_link'],
                        "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                    ]
                );
            }
            return 'success';
        } else {
            return 'error';
        }
    }
}
