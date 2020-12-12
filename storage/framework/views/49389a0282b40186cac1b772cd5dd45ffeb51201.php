<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.your_loc')); ?></h2>
</div>
<div class="wt-formtheme">
    <fieldset>
        <div class="form-group form-group-half">
            <span class="wt-select">
                <?php echo Form::select('location', $locations, Auth::user()->location_id ,array('class' => '', 'placeholder' => trans('lang.select_location'))); ?>

            </span>
        </div>
        <div class="form-group form-group-half">
            <?php echo Form::text( 'address', e($address), ['class' =>'form-control', 'placeholder' => trans('lang.your_address')] ); ?>

        </div>
        <?php if(!empty($longitude) && !empty($latitude)): ?>
            <div class="form-group wt-formmap">
                <div class="wt-locationmap">
                    <custom-map :latitude="<?php echo e($latitude); ?>" :longitude="<?php echo e($longitude); ?>"></custom-map>
                </div>
            </div>
        <?php endif; ?>
        <div class="form-group form-group-half">
            <?php echo Form::text( 'longitude', e($longitude), ['class' =>'form-control', 'placeholder' => trans('lang.enter_logitude')] ); ?>

        </div>
        <div class="form-group form-group-half">
            <?php echo Form::text( 'latitude', e($latitude), ['class' =>'form-control', 'placeholder' => trans('lang.enter_latitude')] ); ?>

        </div>
    </fieldset>
</div>