<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.add_socials')); ?></h2>
</div>
    <?php echo $__env->make('back-end.admin.settings.footer.socials', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id'
        =>'footer-setting-form', '@submit.prevent'=>'submitFooterSettings']); ?>

        <?php echo $__env->make('back-end.admin.settings.footer.logo', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="wt-location wt-tabsinfo">
            <div class="wt-tabscontenttitle">
                <h2><?php echo e(trans('lang.about_us_note')); ?></h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        <?php echo Form::textarea('footer[description]', e($footer_desc), array('class' => 'form-control')); ?>

                    </div>
                </div>
            </div>
            <div class="wt-tabscontenttitle">
                <h2><?php echo e(trans('lang.copyright_text')); ?></h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        <?php echo Form::text('footer[copyright]', e($footer_copyright), array('class' => 'form-control')); ?>

                    </div>
                </div>
            </div>
            <div class="wt-tabscontenttitle">
                <h2><?php echo e(trans('lang.footer_menu_1')); ?></h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        <?php echo Form::text('footer[menu_title_1]', $menu_title_1 ,array('class' => 'form-control', 'placeholder' => trans('lang.menu_title'))); ?>

                    </div>
                </div>
            </div>
            <div class="wt-settingscontent la-footer-settings">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        <span class="wt-select">
                            <?php echo Form::select('footer[menu_pages_1][]', $pages, $menu_pages_1 ,array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_pages'))); ?>

                        </span>
                    </div>
                </div>
            </div>
            <div class="wt-tabscontenttitle">
                <h2><?php echo e(trans('lang.footer_menu')); ?></h2>
            </div>
            <div class="wt-settingscontent">
                <div class="wt-formtheme wt-userform">
                    <div class="form-group">
                        <span class="wt-select">
                            <?php echo Form::select('footer[pages][]', $pages, $menu_pages ,array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_pages'))); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="wt-updatall la-updateall-holder">
            <?php echo Form::submit(trans('lang.btn_save'), ['class' => 'wt-btn']); ?>

        </div>
    <?php echo Form::close(); ?>

    <div class="wt-settingscontent">
        <?php echo $__env->make('back-end.admin.settings.footer.search-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
