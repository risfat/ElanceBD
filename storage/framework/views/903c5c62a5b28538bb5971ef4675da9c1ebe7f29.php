<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.your_details')); ?></h2>
</div>
<div class="wt-formtheme">
    <fieldset>
        <div class="form-group form-group-half">
            <span class="wt-select">
                <?php echo Form::select( 'gender', ['male' => 'Male', 'female' => 'Female'], e($gender), ['placeholder' => trans('lang.ph_select_gender')] ); ?>

            </span>
        </div>
        <div class="form-group form-group-half">
            <?php echo Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ); ?>

        </div>
        <div class="form-group form-group-half">
            <?php echo Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ); ?>

        </div>
        <div class="form-group form-group-half">
            <?php echo Form::number( 'hourly_rate', e($hourly_rate), ['class' =>'form-control', 'placeholder' => trans('lang.ph_service_hoyrly_rate')] ); ?>

        </div>
        <div class="form-group">
            <?php echo Form::text( 'tagline', e($tagline), ['class' =>'form-control', 'placeholder' => trans('lang.ph_add_tagline')] ); ?>

        </div>
        <div class="form-group">
            <?php echo Form::textarea( 'description', e($description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ); ?>

        </div>
    </fieldset>
</div>