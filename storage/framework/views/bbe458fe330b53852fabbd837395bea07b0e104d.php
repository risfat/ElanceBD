<div class="wt-tabscontenttitle">
    <h2><?php echo e(trans('lang.import_demo')); ?></h2>
</div>
<?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform', 'id'
        =>'import-demo', '@submit.prevent'=>'']); ?>

    <div class="wt-selectdesign la-wt-demo">
        <ul>
            <li>
                <div class="wt-templateoption">
                    <div class="wt-designimg"><img src="<?php echo e(asset('images/demo-content/screenshot.jpg')); ?>" alt="<?php echo e(trans('lang.img')); ?>"></div>
                    <div class="la-designtitle-holder">
                        <div class="wt-designtitle">
                            <span><?php echo e(trans('lang.preview_demo')); ?></span>
                            <a target="_blank" href="http://amentotech.com/projects/worketic" class="wt-btn"><?php echo e(trans('lang.btn_preview')); ?></a>
                        </div>
                        <div class="wt-designtitle">
                            <span><?php echo e(trans('lang.refresh_site')); ?></span>
                            <a href="javascript:void(0)" v-on:click.prevent="importDemo('do you want to import demo content')" class="wt-btn"><?php echo e(trans('lang.btn_import_demo')); ?></a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
<?php echo Form::close(); ?>