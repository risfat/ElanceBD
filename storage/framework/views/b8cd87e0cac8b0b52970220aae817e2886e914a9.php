 
<?php $__env->startSection('content'); ?>
    <div class="pages-listing" id="pages-list">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?> <?php if($errors->any()): ?>
            <ul class="wt-jobalerts">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flash_msg">
                    <flash_messages :message_class="'danger'" :time='10' :message="'<?php echo e($error); ?>'" v-cloak></flash_messages>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.add_page')); ?></h2>
                            <div class="wt-rightarea">
                                <a href="<?php echo e(url('admin/create/pages')); ?>" class="wt-btn"><?php echo e(trans('lang.create_page')); ?></a>
                            </div>
                        </div>
                        <?php if($pages->count() > 0): ?>
                            <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                                <table class="wt-tablecategories">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="wt-checkbox">
                                                    <input id="wt-name" type="checkbox" name="head">
                                                    <label for="wt-name"></label>
                                                </span>
                                            </th>
                                            <th><?php echo e(trans('lang.name')); ?></th>
                                            <th><?php echo e(trans('lang.slug')); ?></th>
                                            <th><?php echo e(trans('lang.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 0; ?> 
                                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="del-<?php echo e($page->id); ?>" v-bind:id="pageID">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-<?php echo e($counter); ?>" type="checkbox" name="head">
                                                        <label for="wt-check-<?php echo e($counter); ?>"></label>
                                                    </span>
                                                </td>
                                                <td><?php echo e($page->title); ?></td>
                                                <td><?php echo e($page->slug); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="<?php echo e(url('admin/pages/edit-page')); ?>/<?php echo e($page->id); ?>" class="wt-addinfo wt-pages">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($page->id); ?>'" :message="'<?php echo e(trans("lang.ph_page_delete_message")); ?>'" :url="'<?php echo e(url('admin/pages/delete-page')); ?>'"></delete>                                                    
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?> 
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($pages,'links') ): ?> <?php echo e($pages->links('pagination.custom')); ?> <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>