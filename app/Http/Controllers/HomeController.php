<?php
/**
 * Class HomeController.
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
use App\Category;
use App\Skill;
use App\Location;
use App\SiteManagement;
use App\Language;

/**
 * Class HomeController
 *
 */
class HomeController extends Controller
{
    /**
     * Show the home page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_page_settings = !empty(SiteManagement::getMetaValue('home_settings')) ? SiteManagement::getMetaValue('home_settings') : array();
        $banner_settings = !empty($home_page_settings) ? $home_page_settings[0] : array();
        $banner  = !empty($banner_settings['home_banner']) ? $banner_settings['home_banner'] : '';
        $banner_inner_image  = !empty($banner_settings['home_banner_image']) ? $banner_settings['home_banner_image'] : '';
        $banner_title  = !empty($banner_settings['banner_title']) ? $banner_settings['banner_title'] : 'Hire expert freelancers';
        $banner_subtitle  = !empty($banner_settings['banner_subtitle']) ? $banner_settings['banner_subtitle'] : 'for any job, Online';
        $banner_description  = !empty($banner_settings['banner_description']) ? $banner_settings['banner_description'] : 'Consectetur adipisicing elit sed dotem eiusmod tempor incuntes ut labore etdolore maigna aliqua enim';
        $banner_video_link  = !empty($banner_settings['video_link']) ? $banner_settings['video_link'] : 'https://www.youtube.com/watch?v=B-ph2g5o2K4';
        $banner_video_title  = !empty($banner_settings['video_title']) ? $banner_settings['video_title'] : 'See For Yourself!';
        $banner_video_desc  = !empty($banner_settings['video_desc']) ? $banner_settings['video_desc'] : 'How it works & experience the ultimate joy.';
        $section_bg = !empty($home_page_settings[0]['section_bg']) ? $home_page_settings[0]['section_bg'] : null;
        $company_title = !empty($home_page_settings[0]['company_title']) ? $home_page_settings[0]['company_title'] : null;
        $company_desc = !empty($home_page_settings[0]['company_desc']) ? $home_page_settings[0]['company_desc'] : null;
        $company_url = !empty($home_page_settings[0]['company_url']) ? $home_page_settings[0]['company_url'] : '#';
        $freelancer_title = !empty($home_page_settings[0]['freelancer_title']) ? $home_page_settings[0]['freelancer_title'] : null;
        $freelancer_desc = !empty($home_page_settings[0]['freelancer_desc']) ? $home_page_settings[0]['freelancer_desc'] : null;
        $freelancer_url = !empty($home_page_settings[0]['freelancer_url']) ? $home_page_settings[0]['freelancer_url'] : '#';
        $download_app_img = !empty($home_page_settings[0]['download_app_img']) ? $home_page_settings[0]['download_app_img'] : '';
        $app_title = !empty($home_page_settings[0]['app_title']) ? $home_page_settings[0]['app_title'] : '';
        $app_subtitle = !empty($home_page_settings[0]['app_subtitle']) ? $home_page_settings[0]['app_subtitle'] : '';
        $app_desc = SiteManagement::where('meta_key', 'app_desc')->select('meta_value')->pluck('meta_value')->first();
        $app_android_link = SiteManagement::where('meta_key', 'app_android_link')->select('meta_value')->pluck('meta_value')->first();
        $app_ios_link = SiteManagement::where('meta_key', 'app_ios_link')->select('meta_value')->pluck('meta_value')->first();
        $categories = Category::latest()->get()->take(8);
        $skills = Skill::latest()->get()->take(8);
        $locations = Location::latest()->get()->take(8);
        $languages = Language::latest()->get()->take(8);
        return view(
            'front-end.index',
            compact(
                'categories', 'banner_settings', 'banner', 'banner_inner_image',
                'banner_title', 'banner_subtitle', 'banner_description',
                'banner_video_link', 'banner_video_desc', 'banner_video_title',
                'section_bg', 'company_title', 'company_desc', 'company_url',
                'freelancer_title', 'freelancer_desc', 'freelancer_url',
                'download_app_img', 'app_title', 'app_subtitle', 'app_desc',
                'app_android_link', 'app_ios_link', 'skills', 'locations',
                'languages'
            )
        );
    }
}
