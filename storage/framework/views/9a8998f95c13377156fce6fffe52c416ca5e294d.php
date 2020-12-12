
<?php $__env->startSection('content'); ?>
    <div class="badges-listing" id="badge-list">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <ul class="wt-jobalerts">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flash_msg">
                    <flash_messages :message_class="'danger'" :time ='10' :message="'<?php echo e($error); ?>'" v-cloak></flash_messages>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.edit_badge')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent la-editbadge">
                            <?php echo Form::open(['url' => url('admin/badges/update-badges/'.$badges->id.''),
                                'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory', 'id' => 'badges'] ); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text( 'badge_title', e($badges['title']), ['class' =>'form-control'] ); ?>

                                    </div>
                                    <div class="wt-settingscontent">
                                        <?php if(!empty($badges['image'])): ?>
                                            <div class="wt-formtheme wt-userform">
                                                <div v-if="this.uploaded_image">
                                                    <div class="test"></div>
                                                    <upload-image
                                                        :id="'badge_image'"
                                                        :img_ref="'badge_img'"
                                                        :url="'<?php echo e(url('admin/badges/upload-temp-image')); ?>'"
                                                        :name="'uploaded_image'"
                                                        >
                                                    </upload-image>
                                                    <?php echo Form::hidden( 'uploaded_image', '', ['id'=>'hidden_img'] ); ?>

                                                </div>
                                                <div class="form-group" v-else>
                                                    <ul class="wt-attachfile">
                                                        <li>
                                                            <span><?php echo e($badges['image']); ?></span>
                                                            <em>
                                                                <a class="dz-remove" href="javascript:void();" v-on:click.prevent="removeImage('hidden_img')" >
                                                                    <span class="lnr lnr-cross"></span>
                                                                </a>
                                                            </em>
                                                        </li>
                                                    </ul>
                                                    <input type="hidden" name="uploaded_image" id="hidden_img" value="<?php echo e($badges['image']); ?>">
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class = "wt-formtheme wt-userform">
                                                <upload-image
                                                    :id="'badge_image'"
                                                    :img_ref="'badge_ref'"
                                                    :url="'<?php echo e(url('admin/badges/upload-temp-image')); ?>'"
                                                    :name="'uploaded_image'"
                                                    >
                                                </upload-image>
                                                <?php echo Form::hidden( 'uploaded_image', '', ['id'=>'hidden_img'] ); ?>

                                            </div>

                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group la-color-picker">
                                        <verte display="widget" v-model="color" menuPosition="left" model="hex"></verte>
                                        <input type="hidden" name="color" :value="color">
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        <?php echo Form::submit(trans('lang.update_cat'), ['class' => 'wt-btn']); ?>

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