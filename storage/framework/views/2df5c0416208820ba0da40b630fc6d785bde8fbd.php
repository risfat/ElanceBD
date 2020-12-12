<div class="wt-clicksavearea">
    <span><?php echo e(trans("lang.project_id")); ?>: <?php echo e($job->code); ?></span>
    <?php if(!empty($save_jobs)): ?>
        <a href="javascrip:void(0);" class="wt-clicksavebtn wt-clicksave wt-btndisbaled">
            <i class="fa fa-heart"></i> 
            <?php echo e(trans("lang.saved")); ?>

        </a>
    <?php else: ?>
        <div class="wt-clicksavearea">
            <a href="javascript:void(0);" id="profile-<?php echo e($job->id); ?>" v-bind:class="disable_btn" class="wt-clicksavebtn" @click.prevent="add_wishlist('profile-<?php echo e($job->id); ?>', <?php echo e($job->id); ?>, 'saved_jobs', '<?php echo e(trans("lang.saved")); ?>')" v-cloak>
                <i v-bind:class="heart_class"></i> 
                {{text}}
            </a>
        </div>
    <?php endif; ?>
</div>