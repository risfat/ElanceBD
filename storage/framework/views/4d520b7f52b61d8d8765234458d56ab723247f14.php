<?php echo $__env->make('back-end.admin.home-page-settings.banner-settings.background-image', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('back-end.admin.home-page-settings.banner-settings.banner-image', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="wt-location wt-tabsinfo">
    <h5><?php echo e(trans('lang.banner_title')); ?></h5>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('home[0][banner_title]', e($banner_title), array('class' => 'form-control')); ?>

            </div>
        </div>
        
    </div>
</div>
<div class="wt-location wt-tabsinfo">
    <h5><?php echo e(trans('lang.banner_subtitle')); ?></h5>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('home[0][banner_subtitle]', e($banner_subtitle), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
<div class="wt-location wt-tabsinfo">
    <h5><?php echo e(trans('lang.banner_desc')); ?></h5>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::textarea('home[0][banner_description]', e($banner_description), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
<div class="wt-location wt-tabsinfo">
    <h5><?php echo e(trans('lang.banner_video_link')); ?></h5>
    <span><?php echo e(trans('lang.video_note')); ?></span>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('home[0][video_link]', e($banner_video_link), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
<div class="wt-location wt-tabsinfo">
    <h5><?php echo e(trans('lang.video_title')); ?></h5>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('home[0][video_title]', e($banner_video_title), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
<div class="wt-location wt-tabsinfo">
    <h5><?php echo e(trans('lang.video_desc')); ?></h5>
    <div class="wt-settingscontent">
        <div class="wt-formtheme wt-userform">
            <div class="form-group">
                <?php echo Form::text('home[0][video_desc]', e($banner_video_desc), array('class' => 'form-control')); ?>

            </div>
        </div>
    </div>
</div>
