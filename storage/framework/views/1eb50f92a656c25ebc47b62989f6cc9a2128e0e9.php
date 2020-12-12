<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.your_details')); ?></h2>
</div>
<div class="lara-detail-form">
    <fieldset>
        <div class="form-group form-group-half">
            <?php echo Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ); ?>

        </div>
        <div class="form-group form-group-half">
            <?php echo Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ); ?>

        </div>
        <div class="form-group">
            <?php echo Form::text( 'tagline', e($tagline), ['class' =>'form-control', 'placeholder' => trans('lang.ph_add_tagline')] ); ?>

        </div>
        <div class="form-group">
            <?php echo Form::textarea( 'description', e($description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ); ?>

        </div>
    </fieldset>
</div>