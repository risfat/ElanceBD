<?php

/**
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com amentotech
 * @link    http://www.amentotech.com
 */

// Authentication route
Auth::routes();
// Cache clear route
Route::get(
    'cache-clear',
    function () {
        $exitCode = \Artisan::call('cache:clear');
        $exitCode = \Artisan::call('route:clear');
        $exitCode = \Artisan::call('config:clear');
        $exitCode = \Artisan::call('view:clear');
        return redirect()->back();
    }
);
// Home
Route::get('/', 'HomeController@index')->name('home');
Route::get('job/{slug}', 'JobController@show')->name('jobDetail');
Route::get('profile/{slug}', 'PublicController@showUserProfile')->name('showUserProfile');
Route::get('categories', 'CategoryController@categoriesList')->name('categoriesList');
Route::get('page/{slug}', 'PageController@show')->name('showPage');
Route::post('store/project-offer', 'UserController@storeProjectOffers');
Route::get('jobs', 'JobController@listjobs')->name('jobs');
Route::get('user/password/reset/{verify_code}', 'PublicController@resetPasswordView')->name('getResetPassView');
Route::post('user/update/password', 'PublicController@resetUserPassword')->name('resetUserPassword');
// Authentication|Guest Routes
Route::post('register/login-register-user', 'PublicController@loginUser')->name('loginUser');
Route::post('register/verify-user-code', 'PublicController@verifyUserCode');
Route::post('register/form-step1-custom-errors', 'PublicController@RegisterStep1Validation');
Route::post('register/form-step2-custom-errors', 'PublicController@RegisterStep2Validation');
Route::get('search-results', 'PublicController@getSearchResult')->name('searchResults');
Route::post('user/add-wishlist', 'UserController@addWishlist');
// Admin Routes
Route::group(
    ['middleware' => ['role:admin']],
    function () {
        Route::get('admin/import-demo', 'SiteManagementController@importDemo');
        Route::get('admin/remove-demo', 'SiteManagementController@removeDemoContent');
        Route::get('admin/payouts', 'UserController@getPayouts')->name('adminPayouts');
        Route::get('users', 'UserController@userListing')->name('userListing');
        Route::get('admin/home-page-settings', 'SiteManagementController@homePageSettings')->name('homePageSettings');
        // Skill Routes
        Route::get('admin/skills', 'SkillController@index')->name('skills');
        Route::get('admin/skills/edit-skills/{id}', 'SkillController@edit')->name('editSkill');
        Route::post('admin/store-skill', 'SkillController@store');
        Route::post('admin/skills/update-skills/{id}', 'SkillController@update');
        Route::get('admin/skills/search', 'SkillController@index');
        Route::post('admin/skills/delete-skills', 'SkillController@destroy');
        // Department Routes
        Route::get('admin/departments', 'DepartmentController@index')->name('departments');
        Route::get('admin/departments/edit-dpts/{id}', 'DepartmentController@edit')->name('editDepartment');
        Route::post('admin/store-department', 'DepartmentController@store');
        Route::get('admin/departments/search', 'DepartmentController@index');
        Route::post('admin/departments/delete-dpts', 'DepartmentController@destroy');
        Route::post('admin/departments/update-dpts/{id}', 'DepartmentController@update');
        // Language Routes
        Route::get('admin/languages', 'LanguageController@index')->name('languages');
        Route::get('admin/languages/edit-langs/{id}', 'LanguageController@edit')->name('editLanguages');
        Route::post('admin/store-language', 'LanguageController@store');
        Route::get('admin/languages/search', 'LanguageController@index');
        Route::post('admin/languages/delete-langs', 'LanguageController@destroy');
        Route::post('admin/languages/update-langs/{id}', 'LanguageController@update');
        // Category Routes
        Route::get('admin/categories', 'CategoryController@index')->name('categories');
        Route::get('admin/categories/edit-cats/{id}', 'CategoryController@edit')->name('editCategories');
        Route::post('admin/store-category', 'CategoryController@store');
        Route::get('admin/categories/search', 'CategoryController@index');
        Route::post('admin/categories/delete-cats', 'CategoryController@destroy');
        Route::post('admin/categories/update-cats/{id}', 'CategoryController@update');
        Route::post('admin/categories/upload-temp-image', 'CategoryController@uploadTempImage');
        // Badges Routes
        Route::get('admin/badges', 'BadgeController@index')->name('badges');
        Route::get('admin/badges/edit-badges/{id}', 'BadgeController@edit')->name('editbadges');
        Route::post('admin/store-badge', 'BadgeController@store');
        Route::get('admin/badges/search', 'BadgeController@index');
        Route::post('admin/badges/delete-badges', 'BadgeController@destroy');
        Route::post('admin/badges/update-badges/{id}', 'BadgeController@update');
        Route::post('admin/badges/upload-temp-image', 'BadgeController@uploadTempImage');
        // Location Routes
        Route::get('admin/locations', 'LocationController@index')->name('locations');
        Route::get('admin/locations/edit-locations/{id}', 'LocationController@edit')->name('editLocations');
        Route::post('admin/store-location', 'LocationController@store');
        Route::post('admin/locations/delete-locations', 'LocationController@destroy');
        Route::post('/admin/locations/update-location/{id}', 'LocationController@update');
        Route::post('admin/get-location-flag', 'LocationController@getFlag');
        Route::post('admin/locations/upload-temp-image', 'LocationController@uploadTempImage');
        // Review Options Routes
        Route::get('admin/review-options', 'ReviewController@index')->name('reviewOptions');
        Route::get('admin/review-options/edit-review-options/{id}', 'ReviewController@edit')->name('editReviewOptions');
        Route::post('admin/store-review-options', 'ReviewController@store');
        Route::post('admin/review-options/delete-review-options', 'ReviewController@destroy');
        Route::post('admin/review-options/update-review-options/{id}', 'ReviewController@update');
        // Site Management Routes
        Route::get('admin/settings', 'SiteManagementController@Settings')->name('settings');
        Route::post('admin/store/email-settings', 'SiteManagementController@storeEmailSettings');
        Route::post('admin/store/home-settings', 'SiteManagementController@storeHomeSettings');
        Route::post('admin/store/settings', 'SiteManagementController@storeGeneralSettings');
        Route::post('admin/upload-temp-image/{file_name}', 'SiteManagementController@uploadTempImage');
        Route::post('admin/store/footer-settings', 'SiteManagementController@storeFooterSettings');
        Route::post('admin/store/social-settings', 'SiteManagementController@storeSocialSettings');
        Route::post('admin/store/search-menu', 'SiteManagementController@storeSearchMenu');
        Route::post('admin/store/commision-settings', 'SiteManagementController@storeCommisionSettings');
        Route::post('admin/store/payment-settings', 'SiteManagementController@storePaymentSettings');
        Route::get('admin/email-templates', 'EmailTemplateController@index')->name('emailTemplates');
        Route::get('admin/email-templates/{id}', 'EmailTemplateController@edit')->name('editEmailTemplates');
        Route::post('admin/email-templates/update-content', 'EmailTemplateController@updateTemplateContent');
        Route::post('admin/email-templates/update-templates/{id}', 'EmailTemplateController@update');
        // Pages Routes
        Route::get('admin/pages', 'PageController@index')->name('pages');
        Route::get('admin/create/pages', 'PageController@create')->name('createPage');
        Route::get('admin/pages/edit-page/{id}', 'PageController@edit')->name('editPage');

        Route::post('admin/store-page', 'PageController@store');
        Route::get('admin/pages/search', 'PageController@index');
        Route::post('admin/pages/delete-page', 'PageController@destroy');
        Route::post('admin/pages/update-page/{id}', 'PageController@update');
        //All Jobs
        Route::get('admin/jobs', 'JobController@jobsAdmin')->name('allJobs');
        //All packages
        Route::get('admin/packages', 'PackageController@create')->name('createPackage');
        Route::get('admin/packages/edit/{slug}', 'PackageController@edit')->name('editPackage');
        Route::post('admin/packages/update/{slug}', 'PackageController@update');
        Route::post('admin/store/package', 'PackageController@store');
        Route::post('admin/packages/delete-package', 'PackageController@destroy');
        Route::post('package/get-package-options', 'PackageController@getPackageOptions');

        Route::get('admin/profile', 'UserController@adminProfileSettings')->name('adminProfile');
        Route::post('admin/store-profile-settings', 'UserController@storeProfileSettings');
        Route::post('admin/upload-temp-image', 'UserController@uploadTempImage');
    }
);
//Employer Routes
Route::group(
    ['middleware' => ['role:employer']],
    function () {
        Route::post('skills/get-job-skills', 'SkillController@getJobSkills');
        Route::get('employer/dashboard/post-job', 'JobController@postJob')->name('employerPostJob');
        Route::get('employer/dashboard/manage-jobs', 'JobController@index')->name('employerManageJobs');
        Route::get('employer/jobs/{status}', 'EmployerController@showEmployerJobs');
        Route::get('employer/dashboard/job/{slug}/proposals', 'ProposalController@getJobProposals')->name('getProposals');
        Route::get('employer/dashboard', 'EmployerController@employerDashboard')->name('employerDashboard');
        Route::get('employer/profile', 'EmployerController@index')->name('employerPersonalDetail');
        Route::post('employer/upload-temp-image', 'EmployerController@uploadTempImage');
        Route::post('employer/store-profile-settings', 'EmployerController@storeProfileSettings');
        Route::post('job/post-job', 'JobController@store');
        Route::post('job/upload-temp-image', 'JobController@uploadTempImage');
        Route::post('user/submit-review', 'UserController@submitReview');
        Route::get('job/edit-job/{job_slug}', 'JobController@edit')->name('editJob');
        Route::post('job/get-stored-job-skills', 'JobController@getJobSkills');
        Route::post('job/get-job-settings', 'JobController@getAttachmentSettings');
        Route::post('job/update-job', 'JobController@update');
        Route::post('skills/get-job-skills', 'SkillController@getJobSkills');
        //job controller

        Route::post('proposal/hire-freelancer', 'ProposalController@hiredFreelencer');
    }
);
// Freelancer Routes
Route::group(
    ['middleware' => ['role:freelancer']],
    function () {
        Route::get('/get-freelancer-skills', 'SkillController@getFreelancerSkills');
        Route::get('/get-skills', 'SkillController@getSkills');
        Route::get('payouts', 'FreelancerController@getPayouts')->name('getFreelancerPayouts');
        Route::get('freelancer/dispute/{slug}', 'UserController@raiseDispute');
        Route::post('freelancer/store-dispute', 'UserController@storeDispute');
        Route::get('freelancer/dashboard/experience-education', 'FreelancerController@experienceEducationSettings')->name('experienceEducation');
        Route::get('freelancer/dashboard/project-awards', 'FreelancerController@projectAwardsSettings')->name('projectAwards');
        Route::get('freelancer/dashboard/payment-settings', 'FreelancerController@paymentSettings')->name('paymentSettings');
        Route::post('freelancer/store-profile-settings', 'FreelancerController@storeProfileSettings')->name('freelancerProfileSetting');
        Route::post('freelancer/store-experience-settings', 'FreelancerController@storeExperienceEducationSettings');
        Route::post('freelancer/store-payment-settings', 'FreelancerController@storePaymentSettings');
        Route::post('freelancer/store-project-award-settings', 'FreelancerController@storeProjectAwardSettings');
        Route::get('freelancer/get-freelancer-skills', 'FreelancerController@getFreelancerSkills');
        Route::get('freelancer/get-freelancer-experiences', 'FreelancerController@getFreelancerExperiences');
        Route::get('freelancer/get-freelancer-projects', 'FreelancerController@getFreelancerProjects');
        Route::get('freelancer/get-freelancer-educations', 'FreelancerController@getFreelancerEducations');
        Route::get('freelancer/get-freelancer-awards', 'FreelancerController@getFreelancerAwards');
        Route::get('freelancer/jobs/{status}', 'FreelancerController@showFreelancerJobs');
        Route::get('freelancer/job/{slug}', 'FreelancerController@showOnGoingJobDetail')->name('showOnGoingJobDetail');
        Route::get('freelancer/proposals', 'FreelancerController@showFreelancerProposals')->name('showFreelancerProposals');
        Route::get('freelancer/dashboard', 'FreelancerController@freelancerDashboard')->name('freelancerDashboard');
        Route::get('freelancer/profile', 'FreelancerController@index')->name('personalDetail');
        Route::post('freelancer/upload-temp-image', 'FreelancerController@uploadTempImage');
    }
);
// Employer|Freelancer Routes
Route::group(
    ['middleware' => ['role:employer|freelancer|admin']],
    function () {
        Route::post('proposal/upload-temp-image', 'ProposalController@uploadTempImage');
        Route::get('job/proposal/{job_slug}', 'ProposalController@createProposal')->name('createProposal');
        Route::get('profile/settings/manage-account', 'UserController@accountSettings')->name('manageAccount');
        Route::get('profile/settings/reset-password', 'UserController@resetPassword')->name('resetPassword');
        Route::post('profile/settings/request-password', 'UserController@requestPassword');
        Route::get('profile/settings/email-notification-settings', 'UserController@emailNotificationSettings')->name('emailNotificationSettings');
        Route::post('profile/settings/save-email-settings', 'UserController@saveEmailNotificationSettings');
        Route::post('profile/settings/save-account-settings', 'UserController@saveAccountSettings');
        Route::get('profile/settings/delete-account', 'UserController@deleteAccount')->name('deleteAccount');
        Route::post('profile/settings/delete-user', 'UserController@destroy');
        Route::post('admin/delete-user', 'UserController@deleteUser');
        Route::get('profile/settings/get-manage-account', 'UserController@getManageAccountData');
        Route::get('profile/settings/get-user-notification-settings', 'UserController@getUserEmailNotificationSettings');
        Route::get('{role}/saved-items', 'UserController@getSavedItems')->name('getSavedItems');
        Route::post('profile/get-wishlist', 'UserController@getUserWishlist');
        Route::post('job/add-wishlist', 'JobController@addWishlist');
        Route::get('proposal/{slug}/{status}', 'ProposalController@show');
        Route::post('proposal/download-attachments', 'UserController@downloadAttachments');
        Route::post('proposal/send-message', 'UserController@sendPrivateMessage');
        Route::post('proposal/get-private-messages', 'UserController@getPrivateMessage');
        Route::get('proposal/download/message-attachments/{id}', 'UserController@downloadMessageAttachments');
        Route::get('user/package/checkout/{id}', 'UserController@checkout');
        Route::get('employer/{type}/invoice', 'UserController@getEmployerInvoices')->name('employerInvoice');
        Route::get('freelancer/{type}/invoice', 'UserController@getFreelancerInvoices')->name('freelancerInvoice');
        Route::get('show/invoice/{id}', 'UserController@showInvoice');
    }
);
Route::post('job/get-wishlist', 'JobController@getWishlist');
Route::get('dashboard/packages/{role}', 'PackageController@index');
Route::get('package/get-purchase-package', 'PackageController@getPurchasePackage');
Route::get('paypal/redirect-url', 'PaypalController@getIndex');
Route::get('paypal/ec-checkout', 'PaypalController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'PaypalController@getExpressCheckoutSuccess');
Route::get('user/products/thankyou', 'UserController@thankyou');
Route::get('payment-process/{id}', 'EmployerController@employerPaymentProcess');
Route::get('search/get-search-filters', 'PublicController@getFilterlist');
Route::post('search/get-searchable-data', 'PublicController@getSearchableData');
Route::get('channels/{channel}/messages', 'MessageController@index')->name('message');
Route::post('channels/{channel}/messages', 'MessageController@store');
Route::post('message/send-private-message', 'MessageController@store');
Route::get('message-center', 'MessageController@index')->name('message');
Route::get('message-center/get-users', 'MessageController@getUsers');
Route::post('message-center/get-messages', 'MessageController@getUserMessages');
Route::post('message', 'MessageController@store')->name('message.store');
Route::get('get/{type}/{filename}/{id}', 'PublicController@getFile')->name('getfile');
Route::post('submit-report', 'UserController@storeReport');
Route::post('badge/get-color', 'BadgeController@getBadgeColor');
Route::get('check-proposal-auth-user', 'PublicController@checkProposalAuth');
Route::post('proposal/submit-proposal', 'ProposalController@store');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('get-freelancer-experiences', 'PublicController@getFreelancerExperience');
Route::post('get-freelancer-education', 'PublicController@getFreelancerEducation');
