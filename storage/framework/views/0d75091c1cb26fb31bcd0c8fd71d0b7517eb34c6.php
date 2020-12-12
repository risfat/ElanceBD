
<?php $__env->startSection('content'); ?>
    <div class="cats-listing" id="cat-list">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 float-left">
                    <div class="wt-dashboardbox  la-color-picker-form-wrapper">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.add_badge')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open([ 'url' => url('admin/store-badge'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory','id'=> 'categories']); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text( 'badge_title', null, ['class' =>'form-control'.($errors->has('badge_title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_badge_title')] ); ?>

                                        <span class="form-group-description"><?php echo e(trans('lang.desc')); ?></span>
                                        <?php if($errors->has('badge_title')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('badge_title')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="wt-settingscontent">
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
                                    </div>
                                    <div class="form-group la-color-picker">
                                        <verte display="widget" v-model="color" menuPosition="left" model="hex"></verte>
                                        <input type="hidden" name="color" :value="color">
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        <?php echo Form::submit(trans('lang.add_badge'), ['class' => 'wt-btn']); ?>

                                    </div>
                                </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.badges')); ?></h2>
                            <?php echo Form::open(['url' => url('admin/badges/search'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <input type="search" name="s" value="<?php echo e(!empty($_GET['s']) ? $_GET['s'] : ''); ?>" class="form-control" placeholder="<?php echo e(trans('lang.ph_search_badges')); ?>">
                                        <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                    </div>
                                </fieldset>
                            <?php echo Form::close(); ?>

                        </div>
                        <?php if($badges->count() > 0): ?>
                            <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                                <table class="wt-tablecategories la-badges">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="wt-checkbox">
                                                    <input id="wt-name" type="checkbox" name="head">
                                                    <label for="wt-name"></label>
                                                </span>
                                            </th>
                                            <th><?php echo e(trans('lang.badge_icon')); ?></th>
                                            <th><?php echo e(trans('lang.name')); ?></th>
                                            <th><?php echo e(trans('lang.slug')); ?></th>
                                            <th><?php echo e(trans('lang.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 0; ?>
                                        <?php $__currentLoopData = $badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="del-<?php echo e($badge->id); ?>">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-<?php echo e($counter); ?>" type="checkbox" name="head">
                                                        <label for="wt-check-<?php echo e($counter); ?>"></label>
                                                    </span>
                                                </td>
                                                <td data-th="Icon"><span class="bt-content"><figure style="background-color:<?php echo e($badge->color); ?>"><img src="<?php echo e(asset(Helper::getBadgeImage($badge->image))); ?>" alt="<?php echo e($badge->title); ?>"></figure></span></td>
                                                <td><?php echo e($badge->title); ?></td>
                                                <td><?php echo e($badge->slug); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="<?php echo e(url('admin/badges/edit-badges')); ?>/<?php echo e($badge->id); ?>" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($badge->id); ?>'" :message="'<?php echo e(trans("lang.ph_badge_delete_message")); ?>'" :url="'<?php echo e(url('admin/badges/delete-badges')); ?>'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($badges,'links') ): ?>
                                    <?php echo e($badges->links('pagination.custom')); ?>

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