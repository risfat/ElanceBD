<?php echo Form::open(['url' => '', 'class' => 'wt-formtheme wt-skillsform', 'id'=>'social-management', '@submit.prevent'=>'submitSocialSettings']); ?>

    <fieldset class="social-icons-content">
        <?php if(!empty($social_unserialize_array)): ?>
            <?php $counter = 0 ?>
            <?php $__currentLoopData = $social_unserialize_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unserializeKey =>$unserializevalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="wrap-social-icons wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            <span class="wt-select">
                                <select name="social[<?php echo e($counter); ?>][title]" class="form-control">
                                    <option value="null" selected><?php echo e(trans('lang.select_social_icons')); ?></option>
                                    <?php $__currentLoopData = $social_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $selected = 'selected';
                                            $selected_value = $unserializevalue['title'] === $key ? $selected : '';
                                        ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e($selected_value); ?>><?php echo e($value['title']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </span> <?php echo Form::text('social['.$counter.'][url]', $unserializevalue['url'],
                            ['class' => 'form-control author_title']); ?>

                        </div>
                        <div class="form-group wt-rightarea">
                            <?php if($unserializeKey == 0 ): ?>
                                <span class="wt-addinfobtn" @click="addSocial"><i class="fa fa-plus"></i></span> <?php else: ?>
                                <span class="wt-addinfobtn wt-deleteinfo delete-social" data-check="<?php echo e($counter); ?>">
                                    <i class="fa fa-trash"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php $counter++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="wrap-social-icons wt-haslayout">
                <div class="form-group">
                    <div class="form-group-holder">
                        <span class="wt-select">
                            <select name="social[0][title]" class="form-control">
                                <option value="null" selected><?php echo e(trans('lang.select_social_icons')); ?></option>
                                <?php $__currentLoopData = $social_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($value['title']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </span>
                        <?php echo Form::text('social[0][url]', null, ['class' => 'form-control author_title',
                        'placeholder' => trans('lang.ph_social_url'),'v-model' => 'first_social_url']); ?>

                    </div>
                </div>
                <div class="form-group wt-rightarea">
                    <span class="wt-addinfo" @click="addSocial"><i class="fa fa-plus"></i></span>
                </div>
            </div>
        <?php endif; ?>
            <div v-for="(social, index) in socials" v-cloak>
                <div class="wrap-social-icons wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            <span class="wt-select">
                                    <select class="form-control" v-bind:name="'social['+[social.count]+'][title]'">
                                        <option><?php echo e(trans('lang.select_social')); ?></option>
                                        <?php $__currentLoopData = $social_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($value['title']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </span>
                            <input placeholder="<?php echo e(trans('lang.ph_social_url')); ?>" v-bind:name="'social['+[social.count]+'][url]'" type="text" class="form-control"
                                v-model="social.social_url">
                        </div>
                        <div class="form-group wt-rightarea">
                            <span class="wt-addinfo wt-deleteinfo wt-addinfobtn" @click="removeSocial(index)"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
    </fieldset>
    <div class="wt-updatall la-updateall-holder">
        <?php echo Form::submit(trans('lang.btn_submit'), ['class' => 'wt-btn wt-btnactive']); ?>

    </div>
<?php echo Form::close(); ?>

