<div class="wt-location wt-tabsinfo">
    <h5><?php echo e(trans('lang.home_banner_bg')); ?></h5>
    <div class="wt-settingscontent">
        <?php if(!empty($banner_bg)): ?>
            <?php $image = 'uploads/settings/home/'.$banner_bg; ?>
            <div class="wt-formtheme wt-userform">
                <div v-if="this.uploaded_banner_bg">
                    <upload-image 
                        :id="'home_banner'" 
                        :img_ref="'home_ref'" 
                        :url="'<?php echo e(url('admin/upload-temp-image/home_banner')); ?>'"
                        :name="'home_banner'"
                        >
                    </upload-image>
                </div>
                <div class="wt-uploadingbox" v-else>
                    <figure><img src="<?php echo e(asset($image)); ?>" alt="<?php echo e(trans('lang.home_banner')); ?>"></figure>
                    <div class="wt-uploadingbar">
                        <div class="dz-filename"><?php echo e($banner_bg); ?></div>
                        <em><?php echo e(trans('lang.file_size')); ?><a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_home_banner')"></a></em>
                    </div>
                </div>
                <input type="hidden" name="home[0][home_banner]" id="hidden_home_banner" value="<?php echo e($banner_bg); ?>"> 
            </div>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <upload-image 
                    :id="'home_banner'" 
                    :img_ref="'home_ref'" 
                    :url="'<?php echo e(url('admin/upload-temp-image/home_banner')); ?>'"
                    :name="'home_banner'"
                    >
                </upload-image>
                <input type="hidden" name="home[0][home_banner]" id="hidden_home_banner"> 
            </div>
        <?php endif; ?>
    </div>
</div>
    
