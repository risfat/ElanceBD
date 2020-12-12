 
<?php $__env->startSection('content'); ?>
    <div class="edit-location" id="location">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.edit_location')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open(['url' => url('admin/locations/update-location/'.$locations->id.''), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory']); ?>

                                <fieldset>
                                    <?php echo Form::hidden( 'location', e($locations->id), ['id'=>'uploaded_id'] ); ?>

                                    <div class="form-group">
                                        <?php echo Form::text( 'title', e($locations->title), ['class' =>'form-control'.($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_location_title'),
                                        'id'=>'location_title'] ); ?>

                                        <span class="form-group-description"><?php echo e(trans('lang.desc')); ?></span>
                                        <?php if($errors->has('title')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('title')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if(!empty($store_locations)): ?>
                                        <div class="form-group">
                                            <span class="wt-select">
                                                <select name="child_location" id="parent">
                                                    <?php $__currentLoopData = $store_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store_location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php 
                                                            if ($store_location->id == $locations->id ) {
                                                                $selected = 'selected';    
                                                            } else {
                                                                $selected = '';    
                                                            }
                                                        ?> 
                                                        <option value="<?php echo e($store_location->id); ?>" <?php echo e($selected); ?>><?php echo e($store_location->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </span>
                                            <span class="form-group-description"><?php echo e(trans('lang.parent_desc')); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <?php echo Form::textarea( 'abstract', e($locations->description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc'),
                                        'id'=>'location_abstract'] ); ?>

                                        <span class="form-group-description"><?php echo e(trans('lang.cat_desc')); ?></span>
                                    </div>
                                    <div class="wt-settingscontent">
                                        <?php if(!empty($locations->flag)): ?>
                                            <div class="wt-formtheme wt-userform">
                                                <div v-if="this.uploaded_image">
                                                    <upload-image 
                                                        :id="'location_image'" 
                                                        :img_ref="'location_ref'" 
                                                        :url="'<?php echo e(url('admin/locations/upload-temp-image')); ?>'"
                                                        :name="'uploaded_image'"
                                                        >
                                                    </upload-image>
                                                    <?php echo Form::hidden( 'uploaded_image', '', ['id'=>'hidden_img'] ); ?>

                                                </div>
                                                <div class="form-group" v-else>
                                                    <ul class="wt-attachfile">
                                                        <li>
                                                            <span><?php echo e($locations->flag); ?></span> 
                                                            <em>File size: <span data-dz-size></span>
                                                                <a class="dz-remove" href="javascript:void();" v-on:click.prevent="removeImage('hidden_img')" >
                                                                    <span class="lnr lnr-cross"></span>
                                                                </a>
                                                            </em>
                                                        </li>
                                                    </ul>
                                                    <input type="hidden" name="uploaded_image" id="hidden_img" value="<?php echo e($locations->flag); ?>"> 
                                                </div> 
                                            </div>
                                        <?php else: ?>
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
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        <?php echo Form::submit(trans('lang.update_location'), ['class' => 'wt-btn']); ?>

                                    </div>
                                </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>