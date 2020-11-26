<?php $__env->startSection('content'); ?>
    <?php $breadcrumbs = Breadcrumbs::generate('searchResults'); ?>
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                        <div class="wt-title">
                            <h2><?php echo e(trans('lang.employers')); ?></h2>
                        </div>
                        <?php if(count($breadcrumbs)): ?>
                            <ol class="wt-breadcrumb">
                                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($breadcrumb->url && !$loop->last): ?>
                                        <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
                                    <?php else: ?>
                                        <li class="active"><?php echo e($breadcrumb->title); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ol>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wt-haslayout wt-main-section" id="user_profile">
        <?php if(Session::has('payment_message')): ?>
            <?php $response = Session::get('payment_message') ?>
            <div class="flash_msg">
                <flash_messages :message_class="'<?php echo e($response['code']); ?>'" :time ='5' :message="'<?php echo e($response['message']); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <div class="wt-haslayout">
            <div class="container">
                <div class="row">
                    <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 float-left">
                            <?php echo $__env->make('front-end.employers.filters', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                            <div class="wt-userlistingtitle">
                                <?php if(!empty($users)): ?>
                                    <span><?php echo e(trans('lang.01')); ?> <?php echo e($users->count()); ?> of <?php echo e(\App\User::role('employer')->count()); ?> results <?php if(!empty($keyword)): ?> for <em>"<?php echo e($keyword); ?>"</em> <?php endif; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="wt-companysinfoholder">
                                <div class="row">
                                    <?php if(!empty($users)): ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $verified_user = \App\User::select('user_verified')->where('id', $employer->id)->pluck('user_verified')->first();
                                            ?>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="wt-companysdetails">
                                                    <figure class="wt-companysimg">
                                                        <img src="<?php echo e(asset(Helper::getUserProfileBanner($employer->id, 'small'))); ?>" alt="Company">
                                                    </figure>
                                                    <div class="wt-companysinfo">
                                                        <figure><img src="<?php echo e(asset(Helper::getProfileImage($employer->id))); ?>" alt="Company"></figure>
                                                        <div class="wt-title">
                                                            <a href="<?php echo e(url('profile/'.$employer->slug)); ?>">
                                                            <?php if($verified_user === 1): ?>
                                                                <i class="fa fa-check-circle"></i> <?php echo e(trans('lang.verified_company')); ?></a>
                                                            <?php endif; ?>
                                                            <a href="<?php echo e(url('profile/'.$employer->slug)); ?>"><h2><?php echo e(Helper::getUserName($employer->id)); ?></h2></a>
                                                        </div>
                                                        <ul class="wt-postarticlemeta">
                                                            <li>
                                                                <a href="<?php echo e(url('profile/'.$employer->slug)); ?>">
                                                                    <span><?php echo e(trans('lang.open_jobs')); ?></span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo e(url('profile/'.$employer->slug)); ?>">
                                                                    <span><?php echo e(trans('lang.full_profile')); ?></span>
                                                                </a>
                                                            </li>
                                                            <?php if(in_array($employer->id, $save_employer)): ?>
                                                                <li class="wt-following wt-btndisbaled">
                                                                    <a href="javascript:void(0);">
                                                                        <?php echo e(trans('lang.following')); ?>

                                                                    </a>
                                                                </li>
                                                            <?php else: ?>
                                                                <li>
                                                                    <a href="javascript:void(0);" id="profile-<?php echo e($employer->id); ?>" @click.prevent="add_wishlist('profile-<?php echo e($employer->id); ?>', <?php echo e($employer->id); ?>, 'saved_employers', '<?php echo e(trans("lang.following")); ?>')" v-cloak>
                                                                        <span><?php echo e(trans('lang.click_to_follow')); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if( method_exists($users,'links') ): ?>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 la-employerpagintaion">
                                                <?php echo e($users->links('pagination.custom')); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('front-end.master', ['body_class' => 'wt-innerbgcolor'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>