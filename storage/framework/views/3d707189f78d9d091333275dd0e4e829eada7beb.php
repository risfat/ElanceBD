<?php $__env->startSection('content'); ?>
    <div class="skills-listing" id="skill-list">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='500000' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.add_skill')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open([
                                'url' => url('admin/store-skill'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory',
                                'id' => 'skills'
                                ]); ?>

                            <fieldset>
                                <div class="form-group">
                                    <?php echo Form::text( 'skill_title', null, ['class' =>'form-control'.($errors->has('skill_title') ? ' is-invalid' : ''),
                                    'placeholder' => trans('lang.ph_skill_title')] ); ?>

                                    <span class="form-group-description"><?php echo e(trans('lang.desc')); ?></span>
                                    <?php if($errors->has('skill_title')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('skill_title')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <?php echo Form::textarea( 'skill_desc', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ); ?>

                                    <span class="form-group-description"><?php echo e(trans('lang.cat_desc')); ?></span>
                                </div>
                                <div class="form-group wt-btnarea">
                                    <?php echo Form::submit(trans('lang.add_skill'), ['class' => 'wt-btn']); ?>

                                </div>
                            </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.skills')); ?></h2>
                            <?php echo Form::open(['url' => url('admin/skills/search'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']); ?>

                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>"
                                        class="form-control" placeholder="<?php echo e(trans('lang.ph_search_skills')); ?>">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                            <?php echo Form::close(); ?>

                        </div>
                        <?php if($skills->count() > 0): ?>
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
                                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="del-<?php echo e($skill->id); ?>" v-bind:id="skillID">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-<?php echo e($counter); ?>" type="checkbox" name="head">
                                                        <label for="wt-check-<?php echo e($counter); ?>"></label>
                                                    </span>
                                                </td>
                                                <td><?php echo e($skill->title); ?></td>
                                                <td><?php echo e($skill->slug); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="<?php echo e(url('admin/skills/edit-skills')); ?>/<?php echo e($skill->id); ?>" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($skill->id); ?>'" :message="'<?php echo e(trans("lang.ph_skill_delete_message")); ?>'" :url="'<?php echo e(url('admin/skills/delete-skills')); ?>'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($skills,'links') ): ?>
                                    <?php echo e($skills->links('pagination.custom')); ?>

                                <?php endif; ?>
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