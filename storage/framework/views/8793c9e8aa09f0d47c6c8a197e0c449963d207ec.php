<div class="wt-location wt-tabsinfo">
    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.email_sender_avatar')); ?></h2>
    </div>
    <div class="wt-settingscontent">
        <?php if(!empty($sender_avatar)): ?> 
            <?php $image = '/uploads/settings/email/'.$sender_avatar; ?>
            <div class="wt-formtheme wt-userform">
                <div v-if="this.uploaded_avatar">
                    <upload-image 
                        :id="'sender_avatar'" 
                        :img_ref="'email_ref'" 
                        :url="'<?php echo e(url('admin/upload-temp-image/sender_avatar')); ?>'" 
                        :name="'sender_avatar'"
                    >
                    </upload-image>
                </div>
                <div class="wt-uploadingbox" v-else>
                    <figure><img src="<?php echo e(asset($image)); ?>" alt="<?php echo e(trans('lang.profile_photo')); ?>"></figure>
                    <div class="wt-uploadingbar">
                        <div class="dz-filename"><?php echo e($sender_avatar); ?></div>
                        <em><?php echo e(trans('lang.file_size')); ?><a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_avatar')"></a></em>
                    </div>
                </div>
                <input type="hidden" name="email_data[0][sender_avatar]" id="hidden_avatar" value="<?php echo e($sender_avatar); ?>">
            </div>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <upload-image 
                    :id="'sender_avatar'" 
                    :img_ref="'email_ref'" 
                    :url="'<?php echo e(url('admin/upload-temp-image/sender_avatar')); ?>'" 
                    :name="'sender_avatar'">
                </upload-image>
                <input type="hidden" name="email_data[0][sender_avatar]" id="hidden_avatar">
            </div>
        <?php endif; ?>
    </div>
</div>