<div class="wt-location wt-tabsinfo">
    <h6><?php echo e(trans('lang.sec_bg_img')); ?></h6>
    <div class="wt-settingscontent">
        <?php if(!empty($section_bg)): ?>
            <?php $image = '/uploads/settings/home/'.$section_bg; ?>
            <div class="wt-formtheme wt-userform">
                <div v-if="this.uploaded_section_bg">
                    <upload-image 
                        :id="'section_bg'" 
                        :img_ref="'section_ref'" 
                        :url="'<?php echo e(url('admin/upload-temp-image/section_bg')); ?>'"
                        :name="'section_bg'"
                        >
                    </upload-image>
                </div>
                <div class="wt-uploadingbox" v-else>
                    <figure><img src="<?php echo e(asset($image)); ?>" alt="<?php echo e(trans('lang.sec_bg_img')); ?>"></figure>
                    <div class="wt-uploadingbar">
                        <div class="dz-filename"><?php echo e($section_bg); ?></div>
                        <em><?php echo e(trans('lang.file_size')); ?><a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_section_bg')"></a></em>
                    </div>
                </div>
                <input type="hidden" name="home[0][section_bg]" id="hidden_section_bg" value="<?php echo e($section_bg); ?>"> 
            </div>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <upload-image 
                    :id="'section_bg'" 
                    :img_ref="'section_ref'" 
                    :url="'<?php echo e(url('admin/upload-temp-image/section_bg')); ?>'"
                    :name="'section_bg'"
                    >
                </upload-image>
                <input type="hidden" name="home[0][section_bg]" id="hidden_section_bg"> 
            </div>
        <?php endif; ?>
    </div>
</div>
    
