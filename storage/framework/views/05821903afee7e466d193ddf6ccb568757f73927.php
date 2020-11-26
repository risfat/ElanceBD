<div class="wt-location wt-tabsinfo">
    <h6><?php echo e(trans('lang.download_app_img')); ?></h6>
    <div class="wt-settingscontent">
        <?php if(!empty($download_app_img)): ?>
            <?php $image = '/uploads/settings/home/'.$download_app_img; ?>
            <div class="wt-formtheme wt-userform">
                <div v-if="this.uploaded_download_app_img">
                    <upload-image 
                        :id="'download_app_img'" 
                        :img_ref="'download_app_ref'" 
                        :url="'<?php echo e(url('admin/upload-temp-image/download_app_img')); ?>'"
                        :name="'download_app_img'"
                        >
                    </upload-image>
                </div>
                <div class="wt-uploadingbox" v-else>
                    <figure><img src="<?php echo e(asset($image)); ?>" alt="<?php echo e(trans('lang.download_app_img')); ?>"></figure>
                    <div class="wt-uploadingbar">
                        <div class="dz-filename"><?php echo e($download_app_img); ?></div>
                        <em><?php echo e(trans('lang.file_size')); ?><a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_download_app_img')"></a></em>
                    </div>
                </div>
                <input type="hidden" name="home[0][download_app_img]" id="hidden_download_app_img" value="<?php echo e($download_app_img); ?>"> 
            </div>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <upload-image 
                    :id="'download_app_img'" 
                    :img_ref="'download_app'" 
                    :url="'<?php echo e(url('admin/upload-temp-image/download_app_img')); ?>'"
                    :name="'download_app_img'"
                    >
                </upload-image>
                <input type="hidden" name="home[0][download_app_img]" id="hidden_download_app_img"> 
            </div>
        <?php endif; ?>
    </div>
</div>
    
