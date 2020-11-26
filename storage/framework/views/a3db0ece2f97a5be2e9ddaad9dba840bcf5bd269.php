 
<?php $__env->startSection('content'); ?>
    <div class="langs-listing" id="lang-list">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?> 
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.add_lang')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open(['url' => url('admin/store-language'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory','id' =>
                            'languages']); ?>

                            <fieldset>
                                <div class="form-group">
                                    <?php echo Form::text( 'language_title', null, ['class' =>'form-control'.($errors->has('language_title') ? ' is-invalid' : ''), 
                                    'placeholder' => trans('lang.ph_lang_title')] ); ?>

                                    <span class="form-group-description"><?php echo e(trans('lang.desc')); ?></span>
                                    <?php if($errors->has('language_title')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('language_title')); ?></strong>
                                        </span>
                                    <?php endif; ?> 
                                </div>
                                <div class="form-group">
                                    <?php echo Form::textarea( 'language_desc', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ); ?>

                                    <span class="form-group-description"><?php echo e(trans('lang.cat_desc')); ?></span>
                                </div>
                                <div class="form-group wt-btnarea">
                                    <?php echo Form::submit(trans('lang.add_lang'), ['class' => 'wt-btn']); ?>

                                </div>
                            </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.langs')); ?></h2>
                            <?php echo Form::open(['url' => url('admin/languages/search'), 'method' => 'get', 'class' =>'wt-formtheme wt-formsearch']); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>" 
                                            class="form-control" placeholder="<?php echo e(trans('lang.ph_search_langs')); ?>">
                                        <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                    </div>
                                </fieldset>
                            <?php echo Form::close(); ?>

                        </div>
                        <?php if($langs->count() > 0): ?>
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
                                        <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="del-<?php echo e($lang->id); ?>" v-bind:id="langID">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-<?php echo e($counter); ?>" type="checkbox" name="head">
                                                        <label for="wt-check-<?php echo e($counter); ?>"></label>
                                                    </span>
                                                </td>
                                                <td><?php echo e($lang->title); ?></td>
                                                <td><?php echo e($lang->slug); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="<?php echo e(url('admin/languages/edit-langs')); ?>/<?php echo e($lang->id); ?>" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($lang->id); ?>'" :message="'<?php echo e(trans("lang.ph_lang_delete_message")); ?>'" :url="'<?php echo e(url('admin/languages/delete-langs')); ?>'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($langs,'links') ): ?> <?php echo e($langs->links('pagination.custom')); ?> <?php endif; ?>
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