<?php

/**
 * Class Helper
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
use Intervention\Image\Facades\Image;
use File;
use Storage;
use Spatie\Permission\Models\Role;
use DB;
use function GuzzleHttp\json_encode;
use APP\Category;
use APP\Location;
use Auth;
use App\Item;
use App\Payout;
use App\Proposal;
use App\User;
use App\SiteManagement;
use App\Badge;

/**
 * Class Helper
 *
 */
class Helper extends Model
{
    /**
     * Set slug before saving in DB
     *
     * @access public
     *
     * @return array
     */
    public static function getGender()
    {
        $gender = ['male' => 'Male', 'female' => 'Female'];
        return $gender;
    }

    /**
     * Generate random code
     *
     * @param integer $limit Limit of numbers
     *
     * @access public
     *
     * @return array
     */
    public static function generateRandomCode($limit)
    {
        if (!empty($limit) && is_numeric($limit)) {
            return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
        }
    }

    /**
     * Get employees list
     *
     * @access public
     *
     * @return array
     */
    public static function getEmployeesList()
    {
        $list = array(
            '1' => array(
                'title' => trans('lang.employee_list.just_me'),
                'search_title' => 'Less Than Two',
                'value' => 1,
            ),
            '2' => array(
                'title' => trans('lang.employee_list.2_9'),
                'search_title' => 'Less Than 10',
                'value' => 10,
            ),
            '3' => array(
                'title' => trans('lang.employee_list.10_99'),
                'search_title' => 'Less Than 100',
                'value' => 100,
            ),
            '4' => array(
                'title' => trans('lang.employee_list.100_499'),
                'search_title' => 'Less Than 500',
                'value' => 500,
            ),
            '5' => array(
                'title' => trans('lang.employee_list.500_100'),
                'search_title' => 'Less Than 1000',
                'value' => 1000,
            ),
            '6' => array(
                'title' => trans('lang.employee_list.500_1000'),
                'search_title' => 'More Than 1000',
                'value' => 5000,
            ),
        );
        return $list;
    }

    /**
     * Get location flag
     *
     * @param image $image location flag
     *
     * @access public
     *
     * @return string
     */
    public static function getLocationFlag($image)
    {
        if (!empty($image)) {
            return '/uploads/locations/' . $image;
        } else {
            return 'uploads/locations/img-09.png';
        }
    }

    /**
     * Get category image
     *
     * @param image $image location flag
     *
     * @access public
     *
     * @return string
     */
    public static function getCategoryImage($image)
    {
        if (!empty($image)) {
            return '/uploads/categories/' . $image;
        } else {
            return 'uploads/categories/img-09.png';
        }
    }

    /**
     * Get badge Image
     *
     * @param image $image badge Image
     *
     * @access public
     *
     * @return string
     */
    public static function getBadgeImage($image)
    {
        if (!empty($image)) {
            return '/uploads/badges/' . $image;
        } else {
            return '';
        }
    }

    /**
     * Get background image
     *
     * @param image $image location flag
     *
     * @access public
     *
     * @return string
     */
    public static function getBackgroundImage($image)
    {
        if (!empty($image)) {
            return '/uploads/settings/home/' . $image;
        } else {
            return 'images/banner-bg.jpg';
        }
    }

    /**
     * Get banner image
     *
     * @param image $image location flag
     * @param image $size  image size
     *
     * @access public
     *
     * @return string
     */
    public static function getBannerImage($image, $size = "")
    {
        if (!empty($image)) {
            if (!empty($size)) {
                return '/uploads/settings/home/' . $size . '-' . $image;
            } else {
                return '/uploads/settings/home/' . $image;
            }
        } else {
            return 'images/banner-img.png';
        }
    }

    /**
     * Get download app image
     *
     * @param image $image download app image
     *
     * @access public
     *
     * @return string
     */
    public static function getDownloadAppImage($image)
    {
        if (!empty($image)) {
            return '/uploads/settings/home/' . $image;
        } else {
            return 'images/mobile-img.png';
        }
    }

    /**
     * Get Header logo image
     *
     * @param image $image header logo
     *
     * @access public
     *
     * @return string
     */
    public static function getHeaderLogo($image)
    {
        if (!empty($image)) {
            return '/uploads/settings/general/' . $image;
        } else {
            return 'images/logo.png';
        }
    }

    /**
     * Get footer logo image
     *
     * @param image $image download app image
     *
     * @access public
     *
     * @return string
     */
    public static function getFooterLogo($image)
    {
        if (!empty($image)) {
            return '/uploads/settings/footer/' . $image;
        } else {
            return 'images/flogo.png';
        }
    }

    /**
     * Store Temporary profile images
     *
     * @param mixed $temp_path Temporary Path.
     * @param mixed $image     Image.
     * @param mixed $file_name file name
     *
     * @return json response
     */
    public static function uploadTempImage($temp_path, $image, $file_name = "")
    {
        $json = array();
        if (!empty($image)) {
            $file_original_name = $image->getClientOriginalName();
            $parts = explode('.', $file_original_name);
            $extension = end($parts);
            $extension = $image->getClientOriginalExtension();
            if ($extension === "jpg" || $extension === "png") {
                $file_original_name = !empty($file_name) ? $file_name : $file_original_name;
                // create directory if not exist.
                if (!file_exists($temp_path)) {
                    File::makeDirectory($temp_path, $mode = 0777, true, true);
                }
                // generate small image size
                $small_img = Image::make($image);
                $small_img->fit(
                    36,
                    36,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $small_img->save($temp_path . '/small-' . $file_original_name);
                // generate medium image size
                $medium_img = Image::make($image);
                $medium_img->fit(
                    100,
                    100,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $medium_img->save($temp_path . '/medium-' . $file_original_name);
                // save original image size
                $img = Image::make($image);
                $img->save($temp_path . '/' . $file_original_name);
                $json['message'] = trans('lang.img_uploaded');
                $json['type'] = 'success';
                return $json;
            } else {
                $json['message'] = trans('lang.img_jpg_png');
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['message'] = trans('lang.image not found');
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Store Temporary images
     *
     * @param mixed $temp_path  Temporary Path.
     * @param mixed $image      Image.
     * @param mixed $file_name  File Name.
     * @param mixed $image_size Image Size.
     *
     * @return json response
     */
    public static function uploadTempImageWithSize($temp_path, $image, $file_name = "", $image_size = array())
    {
        $json = array();
        if (!empty($image)) {
            $file_original_name = $image->getClientOriginalName();
            $parts = explode('.', $file_original_name);
            $extension = end($parts);
            $extension = $image->getClientOriginalExtension();
            if ($extension === "jpg" || $extension === "png") {
                $file_original_name = !empty($file_name) ? $file_name : $file_original_name;
                // create directory if not exist.
                if (!file_exists($temp_path)) {
                    File::makeDirectory($temp_path, $mode = 0777, true, true);
                }
                if (!empty($image_size)) {
                    foreach ($image_size as $key => $size) {
                        $small_img = Image::make($image);
                        $small_img->fit(
                            $size['width'],
                            $size['height'],
                            function ($constraint) {
                                $constraint->upsize();
                            }
                        );
                        $small_img->save($temp_path . $key . '-' . $file_original_name);
                    }
                }
                // save original image size
                $img = Image::make($image);
                $img->save($temp_path . '/' . $file_original_name);
                $json['message'] = trans('lang.img_uploaded');
                $json['type'] = 'success';
                return $json;
            } else {
                $json['message'] = trans('lang.img_jpg_png');
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['message'] = trans('lang.image not found');
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Upload image to new path
     *
     * @param mixed $image    Image.
     * @param mixed $old_path Old path.
     * @param mixed $new_path New path.
     * @param mixed $counter  Counter.
     *
     * @return $json response
     */
    public static function uploadTempToNewPath($image, $old_path, $new_path, $counter = '')
    {
        if (!empty($image)) {
            $filename = $image;
            if (Storage::disk('local')->exists($old_path . '/' . $image)) {
                if (!file_exists($new_path)) {
                    File::makeDirectory($new_path, $mode = 0777, true, true);
                }
                $filename = time() . $counter . '-' . $image;
                Storage::move($old_path . '/' . $image, $new_path . '/' . $filename);
                Storage::move($old_path . '/small-' . $image, $new_path . '/small-' . $filename);
                Storage::move($old_path . '/medium-' . $image, $new_path . '/medium-' . $filename);
            }
            return $filename;
        }
    }

    /**
     * Get English Level List
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getEnglishLevelList($key = "")
    {
        $list = array(
            'basic'             => trans('lang.basic'),
            'conversational'    => trans('lang.conversational'),
            'fluent'            => trans('lang.fluent'),
            'native'            => trans('lang.native'),
            'professional'      => trans('lang.professional'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Project List
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getProjectLevel($key = "")
    {
        $list = array(
            'basic'     => trans('lang.project_level.basic'),
            'medium'    => trans('lang.project_level.medium'),
            'expensive' => trans('lang.project_level.expensive'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Project Type
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getProjectType($key = "")
    {
        $list = array(
            'projects' => trans('lang.projecttype.projects'),
            'hourly'  => trans('lang.projecttype.hourly'),
            'fixed' => trans('lang.projecttype.fixed'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Project Status
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getProjectStatus($key = "")
    {
        $list = array(
            'completed' => trans('lang.project_status.completed'),
            'cancelled' => trans('lang.project_status.cancelled'),
            'hired'     => trans('lang.project_status.hired'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Job Duration List
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getJobDurationList($key = "")
    {
        $list = array(
            'weekly' => trans('lang.job_duration.weekly'),
            'monthly' => trans('lang.job_duration.monthly'),
            'three_month' => trans('lang.job_duration.three_month'),
            'six_month' => trans('lang.job_duration.six_month'),
            'more_than_six' => trans('lang.job_duration.more_than_six'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Job Types List
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getJobTypesList($key = "")
    {
        $list = array(
            'all' => trans('lang.jobtype.all'),
            'featured' => trans('lang.jobtype.featured'),
            'fixed' => trans('lang.jobtype.fixed'),
            'hourly' => trans('lang.jobtype.hourly'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Hourly Rate
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getHourlyRate($key = "")
    {
        $list = array(
            '0-5' => trans('lang.freelancer_hourly_rate.0_5'),
            '5-10' => trans('lang.freelancer_hourly_rate.5_10'),
            '10-20' => trans('lang.freelancer_hourly_rate.10_20'),
            '20-30' => trans('lang.freelancer_hourly_rate.20_30'),
            '30-40' => trans('lang.freelancer_hourly_rate.30_40'),
            '40-50' => trans('lang.freelancer_hourly_rate.40_50'),
            '50-60' => trans('lang.freelancer_hourly_rate.50_60'),
            '60-70' => trans('lang.freelancer_hourly_rate.60_70'),
            '70-80' => trans('lang.freelancer_hourly_rate.70_80'),
            '90-0' => trans('lang.freelancer_hourly_rate.90_0'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Job Completion Time
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getJobCompletionTimeList($key = "")
    {
        $list = array(
            'one_month' => trans('lang.job_completion.one_month'),
            'two_month' => trans('lang.job_completion.two_month'),
            'three_month' => trans('lang.job_completion.three_month'),
            'four_month' => trans('lang.job_completion.four_month'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Freelancer Level
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getFreelancerLevelList($key = "")
    {
        $list = array(
            'independent'       => trans('lang.freelancer_level.independent'),
            'agency'            => trans('lang.freelancer_level.agency'),
            'rising_talent'     => trans('lang.freelancer_level.rising_talent'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Report Reasons
     *
     * @access public
     *
     * @return array
     */
    public static function getReportReasons()
    {
        $list = array(
            '1' => array(
                'title' => trans('lang.report_reasons.fake'),
                'value' => 'fake',
            ),
            '2' => array(
                'title' => trans('lang.report_reasons.behaviour'),
                'value' => 'behavior',
            ),
            '3' => array(
                'title' => trans('lang.report_reasons.other'),
                'value' => 'Other',
            ),
        );
        return $list;
    }

    /**
     * Get Delete Acc Reasons
     *
     * @access public
     *
     * @return array
     */
    public static function getDeleteAccReason($key = "")
    {
        $list = array(
            'not_satisfied' => trans('lang.del_acc_reason.not_satisfied'),
            'not_good_support' => trans('lang.del_acc_reason.no_good_supp'),
            'Others' => trans('lang.del_acc_reason.others'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Package Duration List
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getPackageDurationList($key = "")
    {
        $list = array(
            '10' => trans('lang.pckge_duration.10'),
            '30' => trans('lang.pckge_duration.30'),
            '360' => trans('lang.pckge_duration.360'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get Freelancer Badge
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getFreelancerBadgeList($key = "")
    {
        $list = array(
            'gold'   => trans('lang.badge.gold'),
            'silver' => trans('lang.badge.silver'),
            'brown'  => trans('lang.badge.brown'),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Upload multiple attachments.
     *
     * @param mixed $uploadedFile uploaded file
     * @param mixed $path         path of file
     *
     * @return relation
     */
    public static function uploadTempMultipleAttachments($uploadedFile, $path)
    {
        if (!file_exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $filename = $uploadedFile->getClientOriginalName();
        Storage::disk('local')->putFileAs(
            $path,
            $uploadedFile,
            $filename
        );
        return 'success';
    }

    /**
     * Get username
     *
     * @param integer $user_id ID
     *
     * @access public
     *
     * @return array
     */
    public static function getUserName($user_id)
    {
        if (!empty($user_id)) {
            return User::find($user_id)->first_name . ' ' . User::find($user_id)->last_name;
        } else {
            return '';
        }
    }

    /**
     * Get role name by ID
     *
     * @param integer $role_id ID
     *
     * @access public
     *
     * @return array
     */
    public static function getRoleName($role_id)
    {
        return Role::find($role_id)->name;
    }

    /**
     * Get package options
     *
     * @param string $role Role
     *
     * @access public
     *
     * @return array
     */
    public static function getPackageOptions($role)
    {
        if (!empty($role)) {
            if ($role == 'employer') {
                $list = array(
                    '0' => trans('lang.emp_pkg_opt.price'),
                    '1' => trans('lang.emp_pkg_opt.no_of_jobs'),
                    '2' => trans('lang.emp_pkg_opt.no_of_featured_job'),
                    '3' => trans('lang.emp_pkg_opt.pkg_duration'),
                    '4' => trans('lang.emp_pkg_opt.banner'),
                    '5' => trans('lang.emp_pkg_opt.pvt_cht'),
                );
            } elseif ($role == 'freelancer') {
                $list = array(
                    '0' => trans('lang.freelancer_pkg_opt.price'),
                    '1' => trans('lang.freelancer_pkg_opt.no_of_credits'),
                    '2' => trans('lang.freelancer_pkg_opt.no_of_skills'),
                    '3' => trans('lang.freelancer_pkg_opt.pkg_duration'),
                    '4' => trans('lang.freelancer_pkg_opt.badge'),
                    '5' => trans('lang.freelancer_pkg_opt.banner'),
                    '6' => trans('lang.freelancer_pkg_opt.pvt_cht'),
                );
            }
            return $list;
        }
    }

    /**
     * Get role by userID
     *
     * @param integer $user_id UserID
     *
     * @access public
     *
     * @return array
     */
    public static function getRoleByUserID($user_id)
    {
        $role = DB::table('model_has_roles')->select('role_id')->where('model_id', $user_id)
            ->first();
        return $role->role_id;
    }

    /**
     * Get role by roleID
     *
     * @param integer $role_id RoleID
     *
     * @access public
     *
     * @return array
     */
    public static function getRoleNameByRoleID($role_id)
    {
        $role = \Spatie\Permission\Models\Role::where('id', $role_id)
            ->first();
        if (!empty($role)) {
            return $role->name;
        } else {
            return '-';
        }
    }

    /**
     * Change the .env file Data.
     *
     * @param array $data array
     *
     * @return array
     */
    public static function changeEnv($data = array())
    {
        if (count($data) > 0) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach ((array)$data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get search filters
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getSearchFilterList($key = "")
    {
        $list = array(
            '0' => array(
                'title' => trans('lang.search_filter_list.freelancer'),
                'value' => 'freelancer',
            ),
            '1' => array(
                'title' => trans('lang.search_filter_list.jobs'),
                'value' => 'job',
            ),
            '2' => array(
                'title' => trans('lang.search_filter_list.employers'),
                'value' => 'employer',
            ),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get search filters
     *
     * @param string $type type
     *
     * @access public
     *
     * @return array
     */
    public static function getSearchableList($type)
    {
        $json = array();
        if ($type == 'freelancer') {
            $freelancs = User::role('freelancer')->select(
                DB::raw("CONCAT(users.first_name,' ',users.last_name) AS name"),
                "slug"
            )->get()->toArray();
            $json = $freelancs;
        }
        if ($type == 'employer') {
            $employers = User::role('employer')->select(
                DB::raw("CONCAT(users.first_name,' ',users.last_name) AS name"),
                "slug"
            )->get()->toArray();
            $json = $employers;
        }
        if ($type == 'job') {
            $jobs = DB::table("jobs")
                ->select(
                    "title AS name",
                    "slug"
                )->get()->toArray();
            $json = $jobs;
        }
        return $json;
    }

    /**
     * Get social media data
     *
     * @access public
     *
     * @return array
     */
    public static function getSocialData()
    {
        $social = array(
            'facebook' => array(
                'title' => trans('lang.social_icons.fb'),
                'color' => '#3b5999',
                'icon' => 'fa fa-facebook-f',
            ),
            'twitter' => array(
                'title' => trans('lang.social_icons.twitter'),
                'color' => '#55acee',
                'icon' => 'fab fa-twitter',
            ),
            'youtube' => array(
                'title' => trans('lang.social_icons.youtube'),
                'color' => '#0077B5',
                'icon' => 'fab fa-youtube',
            ),
            'instagram' => array(
                'title' => trans('lang.social_icons.insta'),
                'color' => '#dd4b39',
                'icon' => 'fab fa-instagram',
            ),
            'googleplus' => array(
                'title' => trans('lang.social_icons.gplus'),
                'color' => '#dd4b39',
                'icon' => 'fab fa-google-plus-g',
            )
        );
        return $social;
    }

    /**
     * Display socials
     *
     * @access public
     *
     * @return array
     */
    public static function displaySocials()
    {
        $output = "";
        $social_unserialize_array = SiteManagement::getMetaValue('socials');
        $social_list = Helper::getSocialData();
        if (!empty($social_unserialize_array)) {
            $output .= "<ul class='wt-socialiconssimple wt-socialiconfooter'>";
            foreach ($social_unserialize_array as $key => $value) {
                if (array_key_exists($value['title'], $social_list)) {
                    $socialList = $social_list[$value['title']];
                    $output .= "<li class='wt-{$value['title']}'><a href = '{$value["url"]}'><i class='fa {$socialList["icon"]}' ></i></a></li>";
                }
            }
            $output .= "</ul>";
        }
        echo $output;
    }

    /**
     * Get user profile image
     *
     * @param integer $user_id user_id
     *
     * @access public
     *
     * @return array
     */
    public static function getProfileImage($user_id)
    {
        $profile_image = User::find($user_id)->profile->avater;
        return !empty($profile_image) ? '/uploads/users/' . $user_id . '/' . $profile_image : '/images/user.jpg';
    }

    /**
     * Get user profile image
     *
     * @param integer $user_id user_id
     * @param integer $size    size
     *
     * @access public
     *
     * @return array
     */
    public static function getUserProfileBanner($user_id, $size = '')
    {
        $profile_banner = User::find($user_id)->profile->banner;
        if (!empty($profile_banner)) {
            if (!empty($size)) {
                return '/uploads/users/' . $user_id . '/' . $size . '-' . $profile_banner;
            } else {
                return '/uploads/users/' . $user_id . '/' . $profile_banner;
            }
        } elseif (!empty(Auth::user()) && Auth::user()->getRoleNames()->first() === 'freelancer') {
            if (!empty($size)) {
                return 'images/' . $size . '-frbanner-1920x400.jpg';
            } else {
                return 'images/frbanner-1920x400.jpg';
            }
        } elseif (!empty(Auth::user()) && Auth::user()->getRoleNames()->first() === 'employer') {
            if (!empty($size)) {
                return 'images/' . $size . '-e-1110x300.jpg';
            } else {
                return 'images/e-1110x300.jpg';
            }
        }
    }


    /**
     * Get user profile image
     *
     * @param integer $user_id user_id
     *
     * @access public
     *
     * @return array
     */
    public static function getProfileBanner($user_id)
    {
        $banner = User::find($user_id)->profile->banner;
        return !empty($banner) ? '/uploads/users/' . $user_id . '/' . $banner : 'images/embanner-350x172.jpg';
    }

    /**
     * Upload Attachments.
     *
     * @param mixed $path         path     path
     * @param mixed $uploadedFile uploaded uploadedFile
     *
     * @return relation
     */
    public static function uploadSingleTempImage($path, $uploadedFile)
    {
        if (!empty($uploadedFile)) {
            $file_original_name = $uploadedFile->getClientOriginalName();
            $parts = explode('.', $file_original_name);
            $extension = end($parts);
            $extension = $uploadedFile->getClientOriginalExtension();
            if ($extension === "jpg" || $extension === "png") {
                // create directory if not exist.
                if (!file_exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                // generate small image size
                $image = Image::make($uploadedFile);
                $image->save($path . $file_original_name);

                $json['message'] = trans('lang.img_uploaded');
                $json['type'] = 'success';
                return $json;
            } else {
                $json['message'] = trans('lang.img_jpg_png');
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['message'] = trans('lang.image not found');
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Get project image
     *
     * @param string  $image   Image
     * @param integer $user_id UserID
     *
     * @access public
     *
     * @return array
     */
    public static function getProjectImage($image, $user_id)
    {
        return !empty($image) ? '/uploads/users/' . $user_id . '/' . $image : 'images/projects/img-01.jpg';
    }

    /**
     * List category in tree format
     *
     * @param integer $parent_id  Image
     * @param string  $cat_indent UserID
     *
     * @access public
     *
     * @return array
     */
    public static function listTreeCategories($parent_id = 0, $cat_indent = '')
    {
        $parent_cat = Location::select('title', 'id', 'parent')->where('parent', $parent_id)->get()->toArray();
        foreach ($parent_cat as $key => $value) {
            echo '<option value="' . $value['id'] . '">' . $cat_indent . $value['title'] . '</option>';
            self::listTreeCategories($value['id'], $cat_indent . '—');
        }
    }

    /**
     * Get total jobs
     *
     * @param string $status Status
     *
     * @access public
     *
     * @return array
     */
    public static function getTotalJobs($status = '')
    {
        if (Auth::user()) {
            if (!empty($status)) {
                return Auth::user()->jobs->where('status', $status)->count();
            } else {
                return Auth::user()->jobs->count();
            }
        }
    }

    /**
     * Get proposal Balance
     *
     * @param int $user_id User ID
     * @param int $status  Status
     *
     * @return \Illuminate\Http\Response
     */
    public static function getProposalsBalance($user_id, $status)
    {
        $commision = SiteManagement::getMetaValue('commision');
        $admin_commission = !empty($commision[0]['commision']) ? $commision[0]['commision'] : 0;
        $balance =  Proposal::select('amount')
            ->where('freelancer_id', $user_id)
            ->where('status', $status)->sum('amount');
        $total_amount = !empty($balance) ? $balance - ($balance / 100) * $admin_commission : 0;
        return $total_amount;
    }

    /**
     * Get proposal
     *
     * @param int $user_id User ID
     * @param int $status  Status
     *
     * @return \Illuminate\Http\Response
     */
    public static function getProposals($user_id, $status)
    {
        return Proposal::select('job_id')->latest()->where('freelancer_id', $user_id)->where('status', $status)->get();
    }

    /**
     * Get public path
     *
     * @return \Illuminate\Http\Response
     */
    public static function publicPath()
    {
        $path = public_path();
        if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] != '127.0.0.1') {
            $path = getcwd();
        }
        return $path;
    }

    /**
     * Get size
     *
     * @param integer $bytes bytes
     *
     * @return \Illuminate\Http\Response
     */
    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Format file name
     *
     * @param string $file_name filename
     *
     * @return \Illuminate\Http\Response
     */
    public static function formateFileName($file_name)
    {
        $file =  strstr($file_name, '-');
        return substr($file, 1);
    }

    /**
     * Currency list
     *
     * @param string $code code
     *
     * @access public
     *
     * @return array
     */
    public static function currencyList($code = "")
    {
        $currency_array = array(
            'USD' => array(
                'code' => 'USD',
                'name' => trans('lang.currency.usd'),
                'symbol' => '$',
            ),
            'GBP' => array(
                'code' => 'GBP',
                'name' => trans('lang.currency.gpb'),
                'symbol' => '£',
            ),
        );

        if (!empty($code) && array_key_exists($code, $currency_array)) {
            return $currency_array[$code];
        } else {
            return $currency_array;
        }
    }

    /**
     * Display email warning
     *
     * @access public
     *
     * @return array
     */
    public static function displayEmailWarning()
    {
        $output = "";
        $settings = SiteManagement::getMetaValue('settings');
        if (empty($settings[0]['email']) && auth()->user()->getRoleNames()->first() === 'admin') {
            $output .= '<div class="wt-jobalertsholder float-right">';
            $output .= '<ul id="wt-jobalerts">';
            $output .= '<li class="alert alert-danger alert-dismissible fade show">';
            $output .= '<span>';
            $output .= trans('lang.ph_email_warning');
            $output .= '</span>';
            $output .= '<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></a>';
            $output .= '</li>';
            $output .= '</ul>';
            $output .= '</div>';
        }
        echo $output;
    }

    /**
     * Get badge
     *
     * @param integer $user_id UserID
     *
     * @access public
     *
     * @return array
     */
    public static function getUserBadge($user_id)
    {
        if (!empty($user_id)) {
            $user = User::find($user_id);
            if (!empty($user->badge_id)) {
                return Badge::where('id', $user->badge_id)->first();
            } else {
                return '';
            }
        }
    }

    /**
     * Get payment method list
     *
     * @param string $key key
     *
     * @access public
     *
     * @return array
     */
    public static function getPaymentMethodList($key = "")
    {
        $list = array(
            '0' => array(
                'title' => trans('lang.payment_methods.paypal'),
                'value' => 'paypal',
            ),
        );
        if (!empty($key) && array_key_exists($key, $list)) {
            return $list[$key];
        } else {
            return $list;
        }
    }

    /**
     * Get employer jobs
     *
     * @param string $user_id key
     *
     * @access public
     *
     * @return array
     */
    public static function getEmployerJobs($user_id)
    {
        if (!empty($user_id)) {
            $user = User::find($user_id);
            if ($user->getRoleNames()->first() === 'employer') {
                return Job::select('title', 'id')->where('user_id', $user_id)->get()->pluck('title', 'id');
            } else {
                return array();
            }
        } else {
            return trans('lang.no_jobs_found');
        }
    }

    /**
     * Get google map api key
     *
     * @access public
     *
     * @return array
     */
    public static function getGoogleMapApiKey()
    {
        $settings =  SiteManagement::getMetaValue('settings');
        if (!empty($settings[0]['gmap_api_key'])) {
            return $settings[0]['gmap_api_key'];
        } else {
            return '';
        }
    }

    /**
     * Update payouts
     *
     * @access public
     *
     * @return array
     */
    public static function updatePayouts()
    {
        $payout_settings = SiteManagement::getMetaValue('commision');
        $min_payount = !empty($payout_settings[0]['min_payout']) ? $payout_settings[0]['min_payout'] : '';
        $payment_gateway = !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : 'paypal';
        $payment_settings = SiteManagement::getMetaValue('payment_settings');
        $currency  = !empty($payment_settings[0]['currency']) ? $payment_settings[0]['currency'] : 'USD';
        $query = Proposal::select('freelancer_id', DB::raw('sum(amount) earning'))->where('status', 'completed')
            ->groupBy('freelancer_id')
            ->get();
        if ($query->count() > 0) {
            foreach ($query as $q) {
                if ($q->earning >= $min_payount) {
                    $user = User::find($q->freelancer_id);
                    if (!empty($user->profile->payout_id)) {
                        $total_earning = Self::getProposalsBalance($q->freelancer_id, 'completed');
                        $user_payout = Payout::select('id')->where('user_id', $q->freelancer_id)
                            ->get()->first();
                        if (!empty($user_payout->id)) {
                            $payout = Payout::find($user_payout->id);
                        } else {
                            $payout = new Payout();
                        }
                        $payout->user()->associate($q->freelancer_id);
                        $payout->amount = $total_earning;
                        $payout->payment_method = $payment_gateway;
                        $payout->currency = $currency;
                        $payout->paypal_id = $user->profile->payout_id;
                        $payout->status = 'pending';
                        $payout->save();
                    }
                }
            }
        }
    }

    /**
     * Get images
     *
     * @access public
     *
     * @return string
     */
    public static function getImages($path, $image, $default)
    {
        if (file_exists($path . '/' . $image)) {
            echo '<img src="' . url($path . '/' . $image) . '" alt="' . trans('lang.img') . '">';
        } else {
            echo '<span class="lnr lnr-' . $default . '"></span>';
        }
    }

    /**
     * Get package expiry image
     * 
     * @param string $path  path
     * 
     * @param string $image image
     *
     * @access public
     *
     * @return string
     */
    public static function getDashExpiryImages($path, $image)
    {
        if (file_exists($path . '/' . $image)) {
            return url($path . '/' . $image);
        } else {
            return '';
        }
    }

    /**
     * Get package expiry image
     *
     * @param int $badge_id badge_id
     * 
     * @access public
     *
     * @return string
     */
    public static function getBadgeTitle($badge_id)
    {
        $badge = Badge::find($badge_id);
        if (!empty($badge)) {
            return $badge->title;
        }
    }
}
