<?php echo Form::open(['url' => url('search-results'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']); ?>

    <input type="hidden" value="<?php echo e($type); ?>" name="type">
    <aside id="wt-sidebar" class="wt-sidebar">
        <div class="wt-widget wt-startsearch">
            <div class="wt-widgettitle">
                <h2><?php echo e(trans('lang.start_search')); ?></h2>
            </div>
            <div class="wt-widgetcontent">
                <div class="wt-formtheme wt-formsearch">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" name="s" class="form-control" placeholder="<?php echo e(trans('lang.ph_search_employer')); ?>" value="<?php echo e($keyword); ?>">
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2><?php echo e(trans('lang.location')); ?></h2>
            </div>
            <div class="wt-widgetcontent">
                <div class="wt-formtheme wt-formsearch">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control filter-records" placeholder="<?php echo e(trans('lang.search_loc')); ?>">
                            <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                        </div>
                    </fieldset>
                    <fieldset>
                        <?php if(!empty($locations)): ?>
                            <div class="wt-checkboxholder wt-verticalscrollbar">
                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $checked = ( !empty($_GET['locations']) && in_array($location->slug, $_GET['locations'])) ? 'checked' : '' ?>
                                    <span class="wt-checkbox">
                                        <input id="location-<?php echo e($location->slug); ?>" type="checkbox" name="locations[]" value="<?php echo e($location->slug); ?>" <?php echo e($checked); ?>>
                                        <label for="location-<?php echo e($location->slug); ?>"> <img src="<?php echo e(asset(App\Helper::getLocationFlag($location->flag))); ?>" alt="<?php echo e(trans('lang.img')); ?>"> 
                                            <?php echo e($location->title); ?>

                                        </label>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2><?php echo e(trans('lang.no_of_employee')); ?></h2>
            </div>
            <div class="wt-widgetcontent">
                <div class="wt-formtheme wt-formsearch">
                    <fieldset>
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            <?php $__currentLoopData = Helper::getEmployeesList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $checked = ( !empty($_GET['employees']) && in_array($employee['value'], $_GET['employees'])) ? 'checked' : '' ?>
                                <span class="wt-checkbox">
                                    <input id="employee-<?php echo e($employee['value']); ?>" type="checkbox" name="employees[]" value="<?php echo e($employee['value']); ?>" <?php echo e($checked); ?>>
                                    <label for="employee-<?php echo e($employee['value']); ?>"><?php echo e($employee['title']); ?></label>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgetcontent">
                <div class="wt-applyfilters">
                    <span><?php echo e(trans('lang.apply_filter')); ?><br> <?php echo e(trans('lang.changes_by_you')); ?></span>
                    <?php echo Form::submit(trans('lang.btn_apply_filters'), ['class' => 'wt-btn']); ?>

                </div>
            </div>
        </div>
    </aside>
<?php echo form::close();; ?>