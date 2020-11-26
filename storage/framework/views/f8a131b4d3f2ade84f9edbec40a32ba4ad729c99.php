<div class="wt-location wt-tabsinfo">
    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.email_logo')); ?></h2>
    </div>
    <div class="wt-settingscontent">
        <?php if(!empty($email_logo)): ?> 
            <?php $image = '/uploads/settings/email/'.$email_logo; ?>
            <div class="wt-formtheme wt-userform">
                <div v-if="this.uploaded_logo">
                    <upload-image 
                        :id="'email_logo'" 
                        :img_ref="'email_ref'"
                        :url="'<?php echo e(url('admin/upload-temp-image/email_logo')); ?>'" 
                        :name="'email_logo'"
                    >
                    </upload-image>
                </div>
                <div class="wt-uploadingbox" v-else>
                    <figure><img src="<?php echo e(asset($image)); ?>" alt="<?php echo e(trans('lang.email_logo')); ?>"></figure>
                    <div class="wt-uploadingbar">
                        <div class="dz-filename"><?php echo e($email_logo); ?></div>
                        <em><?php echo e(trans('lang.file_size')); ?><a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_logo')"></a></em>
                    </div>
                </div>
                <input type="hidden" name="email_data[0][email_logo]" id="hidden_logo" value="<?php echo e($email_logo); ?>">
            </div>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <upload-image 
                    :id="'email_logo'" 
                    :img_ref="'email_ref'" 
                    :url="'<?php echo e(url('admin/upload-temp-image/email_logo')); ?>'" 
                    :name="'email_logo'"
                >
                </upload-image>
                <input type="hidden" name="email_data[0][email_logo]" id="hidden_logo">
            </div>
        <?php endif; ?>
    </div>
</div>