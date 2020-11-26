 
<?php $__env->startSection('content'); ?>
    <div class="locations-listing la-locations-listing" id="location">
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
                            <h2><?php echo e(trans('lang.add_location')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open(['url' => url('admin/store-location'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory', 'id'=>'location_form']); ?>

                            <fieldset>
                                <div class="form-group">
                                    <?php echo Form::text( 'title', null, ['class' =>'form-control'.($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_location_title'), 'id'=>'location_title']); ?>

                                    <span class="form-group-description"><?php echo e(trans('lang.desc')); ?></span>
                                    <?php if($errors->has('title')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('title')); ?></strong>
                                        </span>
                                    <?php endif; ?> 
                                </div>
                                <?php if(!empty($locations)): ?>
                                    <div class="form-group">
                                        <span class="wt-select">
                                            <select class="form-control" name="parent_location">
                                                <option value="0"><?php echo e(trans('lang.choose_parent_cat')); ?></option>
                                                <?php Helper::listTreeCategories(); ?>
                                            </select>
                                        </span>
                                        <span class="form-group-description"><?php echo e(trans('lang.parent_desc')); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <?php echo Form::textarea( 'abstract', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc'), 'id'=>'location_abstract']); ?>

                                    <span class="form-group-description"><?php echo e(trans('lang.cat_desc')); ?></span>
                                </div>
                                <div class="wt-settingscontent">
                                    <div class = "wt-formtheme wt-userform">
                                        <upload-image 
                                            :id="'location_image'" 
                                            :img_ref="'location_ref'" 
                                            :url="'<?php echo e(url('admin/locations/upload-temp-image')); ?>'"
                                            :name="'uploaded_image'"
                                            >
                                        </upload-image>
                                        <?php echo Form::hidden( 'uploaded_image', '', ['id'=>'hidden_img'] ); ?>

                                    </div>
                                </div>
                                <div class="form-group wt-btnarea">
                                    <?php echo Form::submit(trans('lang.add_location'), ['class' => 'wt-btn']); ?>

                                </div>
                            </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.locations')); ?></h2>
                            <form class="wt-formtheme wt-formsearch">
                                <fieldset>
                                    <div class="form-group">
                                        <input type="text" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>" 
                                        class="form-control" placeholder="<?php echo e(trans('lang.ph_search_locations')); ?>">
                                        <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <?php if($locations->count() > 0): ?>
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
                                            <th><?php echo e(trans('lang.icon')); ?></th>
                                            <th><?php echo e(trans('lang.name')); ?></th>
                                            <th><?php echo e(trans('lang.slug')); ?></th>
                                            <th><?php echo e(trans('lang.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($locations)): ?> 
                                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="del-<?php echo e($location->id); ?>" v-bind:id="locationID">
                                                    <td>
                                                        <span class="wt-checkbox">
                                                            <input id="wt-check-<?php echo e($location->slug); ?>" type="checkbox" name="head">
                                                            <label for="wt-check-<?php echo e($location->slug); ?>"></label>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <figure><img src="<?php echo e(asset(Helper::getLocationFlag($location->flag))); ?>" alt="<?php echo e(trans('lang.flag_img')); ?>"></figure>
                                                    </td>
                                                    <td><?php echo e($location->title); ?></td>
                                                    <td><?php echo e($location->slug); ?></td>
                                                    <td>
                                                        <div class="wt-actionbtn">
                                                            <a href="<?php echo e(url('admin/locations/edit-locations')); ?>/<?php echo e($location->id); ?>" class="wt-addinfo wt-skillsaddinfo"><i class="lnr lnr-pencil"></i></a>
                                                            <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($location->id); ?>'" :message="'<?php echo e(trans("lang.ph_location_delete_message")); ?>'" :url="'<?php echo e(url('admin/locations/delete-locations')); ?>'"></delete>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($locations,'links') ): ?> 
                                    <?php echo e($locations->links('pagination.custom')); ?> 
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