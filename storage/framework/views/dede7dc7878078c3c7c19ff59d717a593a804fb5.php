<div class="wt-tabcompanyinfo wt-tabsinfo">
    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.company_details')); ?></h2>
    </div>
    <div class="wt-accordiondetails">
        <div class="wt-radioboxholder">
            <div class="wt-title">
                <h4><?php echo e(trans('lang.no_of_employees')); ?></h4>
            </div>
            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="wt-radio">
                        <input id="wt-just-<?php echo e($key); ?>" type="radio" name="employees" value="<?php echo e($employee['value']); ?>" 
                        <?php echo e(($employee['value'] == $no_of_employees) ? 'checked' : ''); ?> >
                        <label for="wt-just-<?php echo e($key); ?>"><?php echo e($employee['title']); ?></label>
                </span> 
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($departments->count() > 0): ?>
            <div class="wt-radioboxholder">
                <div class="wt-title">
                    <h4><?php echo e(trans('lang.your_department')); ?></h4>
                </div>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="wt-radio">
                        <input id="wt-department-<?php echo e($department->id); ?>" type="radio" name="department" value="<?php echo e($department->id); ?>" 
                        <?php echo e(($department->id == $department_id) ? 'checked' : ''); ?>>
                        <label for="wt-department-<?php echo e($department->id); ?>"><?php echo e($department->title); ?></label>
                    </span>                                                        
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>  
    </div>
</div>