 
<?php $__env->startSection('content'); ?>
    <div class="packages-listing" id="packages">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace la-addpackages">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.add_packages')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open([ 'url' => url('admin/store/package'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory', 'id' => 'packages', '@submit.prevent' => 'submitPackage', 'id' => 'package_form' ]); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text( 'package_title', null, ['class' =>'form-control'.($errors->has('package_title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_pkg_title')] ); ?>

                                        <?php if($errors->has('package_title')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('package_title')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::text( 'package_subtitle', null, ['class' =>'form-control '.($errors->has('package_subtitle') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_pkg_subtitle')] ); ?>

                                        <?php if($errors->has('package_subtitle')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('package_subtitle')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::number( 'package_price', null, ['class' =>'form-control '.($errors->has('package_price') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_pkg_price')] ); ?>

                                        <?php if($errors->has('package_price')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('package_price')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group<?php echo e($errors->has('roles') ? ' is-invalid' : ''); ?>">
                                        <span class="wt-select">
                                            <select name="roles" v-model="user_role" v-on:change="selectedRole(user_role)">
                                                <option value="" disabled=""><?php echo e(trans('lang.select_users')); ?></option>
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($role['id']); ?>"><?php echo e($role['name']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </span>
                                        <?php if($errors->has('roles')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('roles')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div v-if="employer_options" v-cloak>
                                        <div class="form-group">
                                            <?php echo Form::text('employer[jobs]', null, array('class' => 'form-control'.($errors->has('employer[jobs]') ? ' is-invalid' : ''), 'placeholder' => trans('lang.no_of_jobs'), 'v-model'=>'package.jobs')); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo Form::text('employer[featured_jobs]', null, array('class' => 'form-control'.($errors->has('employer[featured_jobs]') ? ' is-invalid' : ''), 'placeholder' => trans('lang.no_of_featuredjobs'), 'v-model'=>'package.featured_jobs')); ?>

                                        </div>
                                        <div class="form-group <?php echo e($errors->has('employer[duration]') ? ' is-invalid' : ''); ?>">
                                            <span class="wt-select">
                                                <select name="employer[duration]">
                                                    <option value="" disabled=""><?php echo e(trans('lang.select_duration')); ?></option>
                                                        <?php $__currentLoopData = $durations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $duration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($key); ?>"><?php echo e(Helper::getPackageDurationList($key)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <switch_button v-model="banner_option"><?php echo e(trans('lang.show_banner_opt')); ?></switch_button>
                                            <input type="hidden" :value="banner_option" name="employer[banner_option]">
                                        </div>
                                        <div class="form-group">
                                            <switch_button v-model="private_chat"><?php echo e(trans('lang.enabale_disable_pvt_chat')); ?></switch_button>
                                            <input type="hidden" :value="private_chat" name="employer[private_chat]">
                                        </div>
                                        <?php if($employer_trial->count() == 0): ?>
                                            <div class="form-group">
                                                <span class="wt-checkbox">
                                                    <input id="trial" type="checkbox" name="trial">
                                                    <label for="trial"><span><?php echo e(trans('lang.enable_trial')); ?></span></label>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div v-if="freelancer_options" v-cloak>
                                        <div class="form-group">
                                            <?php echo Form::text('freelancer[no_of_connects]', null, array('class' => 'form-control', 'placeholder' => trans('lang.no_of_connects'), 'v-model'=>'package.conneects')); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo Form::text('freelancer[no_of_skills]', null, array('class' => 'form-control', 'placeholder' => trans('lang.no_of_skills'), 'v-model'=>'package.skills')); ?>

                                        </div>
                                        <div class="form-group">
                                            <span class="wt-select">
                                                <select name="freelancer[duration]">
                                                    <option value="" disabled=""><?php echo e(trans('lang.select_duration')); ?></option>
                                                    <?php $__currentLoopData = $durations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $duration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>"><?php echo e(Helper::getPackageDurationList($key)); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <span class="wt-select">
                                                <?php echo Form::select('freelancer[badge]', $badges, null, array('placeholder' => trans('lang.select_badge'))); ?>

                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <switch_button v-model="banner_option"><?php echo e(trans('lang.show_banner_opt')); ?></switch_button>
                                            <input type="hidden" :value="banner_option" name="freelancer[banner_option]">
                                        </div>
                                        <div class="form-group">
                                            <switch_button v-model="private_chat"><?php echo e(trans('lang.enabale_disable_pvt_chat')); ?></switch_button>
                                            <input type="hidden" :value="private_chat" name="freelancer[private_chat]">
                                        </div>
                                        <?php if($freelancer_trial->count() == 0): ?>
                                            <div class="form-group">
                                                <span class="wt-checkbox">
                                                    <input id="trial" type="checkbox" name="trial">
                                                    <label for="trial"><span><?php echo e(trans('lang.enable_trial')); ?></span></label>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        <?php echo Form::submit(trans('lang.add_packages'), ['class' => 'wt-btn']); ?>

                                    </div>
                                </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.packages')); ?></h2>
                            <?php echo Form::open(['url' => url('admin/packages/search'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" name="s" value="<?php echo e(!empty($_GET['s']) ? $_GET['s'] : ''); ?>" class="form-control" placeholder="<?php echo e(trans('lang.ph_search_packages')); ?>">
                                        <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                    </div>
                                </fieldset>
                            <?php echo Form::close(); ?>

                        </div>
                        <?php if(!empty($packages) || $packages->count() > 0): ?>
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
                                            <th><?php echo e(trans('lang.type')); ?></th>
                                            <th><?php echo e(trans('lang.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 0; ?> 
                                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="del-<?php echo e($package->id); ?>" v-bind:id="packageID">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-<?php echo e($counter); ?>" type="checkbox" name="head">
                                                        <label for="wt-check-<?php echo e($counter); ?>"></label>
                                                    </span>
                                                </td>
                                                <td><?php echo e($package->title); ?></td>
                                                <td><?php echo e($package->slug); ?></td>
                                                <td><?php echo e(Helper::getRoleName($package->role_id)); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="<?php echo e(url('admin/packages/edit')); ?>/<?php echo e($package->slug); ?>" class="wt-addinfo wt-packagesaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($package->id); ?>'" :message="'<?php echo e(trans("lang.ph_pkg_delete_message")); ?>'" :url="'<?php echo e(url('admin/packages/delete-package')); ?>'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?> 
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($packages,'links') ): ?> <?php echo e($packages->links('pagination.custom')); ?> <?php endif; ?>
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