<div class="wt-widget la-empinfo-holder">
    <div class="wt-companysdetails">
        <figure class="wt-companysimg">
            <img src="<?php echo e(asset(Helper::getUserProfileBanner($job->employer->id, 'small'))); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>">
        </figure>
        <div class="wt-companysinfo">
            <figure><img src="<?php echo e(asset(Helper::getProfileImage($job->employer->id))); ?>" alt="<?php echo e(trans('lang.profile_img')); ?>"></figure>
            <div class="wt-title">
                <?php if($job->employer->user_verified === 1): ?>
                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>"><i class="fa fa-check-circle"></i> <?php echo e(trans('lang.verified_company')); ?></a>
                <?php endif; ?>
                <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>"><h2><?php echo e(Helper::getUserName($job->employer->id)); ?></h2></a>
            </div>
            <ul class="wt-postarticlemeta">
                <li>
                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
                        <span><?php echo e(trans('lang.open_jobs')); ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(url('profile/'.$job->employer->slug)); ?>">
                        <span><?php echo e(trans('lang.full_profile')); ?></span>
                    </a>
                </li>
                <?php if(!empty($save_employers)): ?>
                    <li class="wt-btndisbaled">
                        <a href="javascript:void(0);">
                            <span v-cloak><?php echo e(trans("lang.following")); ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <li v-bind:class="disable_follow">
                        <a href="javascript:void(0);" id="profile-<?php echo e($job->employer->id); ?>" @click.prevent="add_wishlist('profile-<?php echo e($job->employer->id); ?>', <?php echo e($job->employer->id); ?>, 'saved_employers', '<?php echo e(trans("lang.following")); ?>')" v-cloak>
                            <span v-cloak>{{follow_text}}</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
