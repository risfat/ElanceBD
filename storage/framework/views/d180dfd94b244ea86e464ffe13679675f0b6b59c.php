<div class="wt-location wt-tabsinfo">
    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.profile_photo')); ?></h2>
    </div>
    <div class="wt-settingscontent">
        <?php if(!empty($avater)): ?>
            <?php $image = '/uploads/users/'.Auth::user()->id.'/'.$avater; ?>
            <div class="wt-formtheme wt-userform">
                <div v-if="this.uploaded_image">
                    <upload-image 
                        :id="'avater_id'" 
                        :img_ref="'avater_ref'" 
                        :url="'<?php echo e(url('admin/upload-temp-image')); ?>'" 
                        :name="'hidden_avater_image'"
                    >
                    </upload-image>
                </div>
                <div class="wt-uploadingbox" v-else>
                    <figure><img src="<?php echo e(asset($image)); ?>" alt="<?php echo e(trans('lang.profile_photo')); ?>"></figure>
                    <div class="wt-uploadingbar">
                        <div class="dz-filename"><?php echo e($avater); ?></div>
                        <em><?php echo e(trans('lang.file_size')); ?><a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_avater')"></a></em>
                    </div>
                </div>
                <input type="hidden" name="hidden_avater_image" id="hidden_avater" value="<?php echo e($avater); ?>">
            </div>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <upload-image 
                    :id="'avater_id'" 
                    :img_ref="'avater_ref'" 
                    :url="'<?php echo e(url('admin/upload-temp-image')); ?>'" 
                    :name="'hidden_avater_image'"
                >
                </upload-image>
                <input type="hidden" name="hidden_avater_image" id="hidden_avater">
            </div>
        <?php endif; ?>
    </div>
</div>