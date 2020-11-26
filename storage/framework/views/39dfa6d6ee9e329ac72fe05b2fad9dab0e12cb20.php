 
<?php $__env->startSection('content'); ?>
    <div class="pages-listing" id="pages-list">
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.add_page')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <form method="POST" action="<?php echo e(url('admin/store-page')); ?>" accept-charset="UTF-8" id="pages" class="wt-formtheme wt-formprojectinfo wt-formcategory" @submit.prevent="submitPage('<?php echo e($page_created); ?>')">
                                <?php echo csrf_field(); ?>
                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text( 'title', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_page_title')] ); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea( 'content', null, ['class' =>'form-control wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.ph_desc')]); ?>

                                    </div>
                                    <?php if($parent_page->count() > 1): ?>
                                    <div class="form-group">
                                        <span class="sj-select">
                                            <?php echo Form::select('parent_id', $parent_page, null ,array('class' => 'form-control jf-select2')); ?>

                                        </span>
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group wt-btnarea">
                                        <?php echo Form::submit(trans('lang.add_page'), ['class' => 'wt-btn']); ?>

                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>