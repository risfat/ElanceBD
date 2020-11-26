<?php

/**
 * Class SiteManagementSeeder.
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Class SiteManagementSeeder
 */
class SiteManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_managements')->insert(
            [
                [
                    'meta_key' => 'home_settings',
                    'meta_value' => 'a:1:{i:0;a:18:{s:11:"home_banner";s:14:"banner-img.jpg";s:17:"home_banner_image";s:10:"img-01.png";s:12:"banner_title";s:23:"Hire expert freelancers";s:15:"banner_subtitle";s:19:"for any job, Online";s:18:"banner_description";s:101:"Consectetur adipisicing elit sed dotem eiusmod tempor incuntes ut labore etdolore maigna aliqua enim.";s:10:"video_link";s:43:"https://www.youtube.com/watch?v=B-ph2g5o2K4";s:11:"video_title";s:17:"See For Yourself!";s:10:"video_desc";s:43:"How it works & experience the ultimate joy.";s:10:"section_bg";s:10:"banner.jpg";s:13:"company_title";s:16:"Start As Company";s:12:"company_desc";s:172:"Consectetur adipisicing elit sed dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua enim poskina ilukita ylokem lokateise ination voluptate velit esse cillum.";s:11:"company_url";s:1:"#";s:16:"freelancer_title";s:19:"Start As Freelancer";s:15:"freelancer_desc";s:172:"Consectetur adipisicing elit sed dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua enim poskina ilukita ylokem lokateise ination voluptate velit esse cillum.";s:14:"freelancer_url";s:1:"#";s:16:"download_app_img";s:14:"mobile-img.png";s:9:"app_title";s:20:"Limitless Experience";s:12:"app_subtitle";s:30:"Roam Around With Your Business";}}',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'app_desc',
                    'meta_value' => '<p>Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua enim poskina ilukita ylokem lokateise ination voluptate velit esse cillum dolore eu fugiat nulla pariatur lokaim urianewce.</p>
                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborumed perspiciatis.</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'app_android_link',
                    'meta_value' => 'https://play.google.com/store/apps/details?id=com.app.amento.worketic',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'app_ios_link',
                    'meta_value' => '#',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'socials',
                    'meta_value' => 'a:5:{i:0;a:2:{s:5:"title";s:8:"facebook";s:3:"url";s:1:"#";}i:1;a:2:{s:5:"title";s:7:"twitter";s:3:"url";s:1:"#";}i:2;a:2:{s:5:"title";s:7:"youtube";s:3:"url";s:1:"#";}i:3;a:2:{s:5:"title";s:9:"instagram";s:3:"url";s:1:"#";}i:4;a:2:{s:5:"title";s:10:"googleplus";s:3:"url";s:1:"#";}}',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'footer_settings',
                    'meta_value' => 'a:6:{s:11:"footer_logo";s:20:"1554450384-flogo.png";s:11:"description";s:187:"Dotem eiusmod tempor incune utnaem labore etdolore maigna aliqua enim poskina ilukita ylokem lokateise ination voluptate velit esse cillum dolore eu fugiat nulla pariatur lokaim urianewce";s:9:"copyright";s:61:"Copyright © 2020 Team xTmos, All Right Reserved RisfBD";s:12:"menu_title_1";s:7:"Company";s:12:"menu_pages_1";a:3:{i:0;s:1:"2";i:1;s:1:"3";i:2;s:1:"4";}s:5:"pages";a:3:{i:0;s:1:"2";i:1;s:1:"3";i:2;s:1:"4";}}',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'commision',
                    'meta_value' => 'a:1:{i:0;a:3:{s:9:"commision";s:2:"20";s:10:"min_payout";s:3:"250";s:14:"payment_method";s:6:"paypal";}}',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'menu_title',
                    'meta_value' => 'Explore More',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'search_menu',
                    'meta_value' => 'a:4:{i:0;a:2:{s:5:"title";s:18:"Freelancers in USA";s:3:"url";s:70:"http://amentotech.com/projects/worketic/search-results?type=freelancer";}i:1;a:2:{s:5:"title";s:21:"Freelancers in Turkey";s:3:"url";s:96:"http://amentotech.com/projects/worketic/search-results?type=freelancer&s=&locations%5B%5D=turkey";}i:2;a:2:{s:5:"title";s:11:"Jobs in USA";s:3:"url";s:96:"http://amentotech.com/projects/worketic/search-results?type=job&s=&locations%5B%5D=united-states";}i:3;a:2:{s:5:"title";s:9:"Find Jobs";s:3:"url";s:63:"http://amentotech.com/projects/worketic/search-results?type=job";}}',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'settings',
                    'meta_value' => 'a:1:{i:0;a:5:{s:5:"title";s:8:"Worketic";s:5:"email";s:20:"exprotest3@gmail.com";s:16:"connects_per_job";N;s:12:"gmap_api_key";N;s:4:"logo";s:19:"1555333800-logo.png";}}',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'meta_key' => 'email_data',
                    'meta_value' => 'a:1:{i:0;a:7:{s:10:"from_email";s:16:"info@noreply.com";s:13:"from_email_id";s:16:"info@noreply.com";s:11:"sender_name";s:6:"Amento";s:14:"sender_tagline";s:17:"Your Work Partner";s:10:"sender_url";s:39:"http://amentotech.com/projects/worketic";s:10:"email_logo";s:22:"1555743744-favicon.png";s:12:"email_banner";s:21:"1555743744-banner.jpg";}}',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
