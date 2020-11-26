<?php $__env->startSection('content'); ?>
    <div class="cats-listing" id="cat-list">
        <?php if(Session::has('message')): ?>
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
            </div>
        <?php endif; ?>
        <section class="wt-haslayout wt-dbsectionspace la-addnewcats">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                    <div class="wt-dashboardbox la-category-box">
                        <div class="wt-dashboardboxtitle">
                            <h2><?php echo e(trans('lang.add_cat')); ?></h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <?php echo Form::open([ 
                                'url' => url('admin/store-category'), 
                                'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory', 'id'=> 'categories' 
                                ]); ?>

                                <fieldset>
                                    <div class="form-group">
                                        <?php echo Form::text( 'category_title', null, ['class' =>'form-control'.($errors->has('category_title') ? ' is-invalid' : ''), 'placeholder' => trans('lang.ph_cat_title')] ); ?>

                                        <span class="form-group-description"><?php echo e(trans('lang.desc')); ?></span>
                                        <?php if($errors->has('category_title')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('category_title')); ?></strong>
                                            </span>
                                        <?php endif; ?>  
                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea( 'category_abstract', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ); ?>

                                        <span class="form-group-description"><?php echo e(trans('lang.cat_desc')); ?></span>
                                    </div>
                                    <div class="wt-settingscontent">
                                        <div class = "wt-formtheme wt-userform">
                                            <upload-image 
                                                :id="'cat_image'" 
                                                :img_ref="'cat_ref'" 
                                                :url="'<?php echo e(url('admin/categories/upload-temp-image')); ?>'"
                                                :name="'uploaded_image'"
                                                >
                                            </upload-image>
                                            <?php echo Form::hidden( 'uploaded_image', '', ['id'=>'hidden_img'] ); ?>

                                        </div>
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        <?php echo Form::submit(trans('lang.add_cat'), ['class' => 'wt-btn']); ?>

                                    </div>
                                </fieldset>
                            <?php echo Form::close();; ?>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 float-right">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle wt-titlewithsearch">
                            <h2><?php echo e(trans('lang.cats')); ?></h2>
                            <?php echo Form::open(['url' => url('admin/categories/search'), 
                                'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']); ?>

                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>" 
                                        class="form-control" placeholder="<?php echo e(trans('lang.ph_search_cats')); ?>">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                            <?php echo Form::close(); ?>

                        </div>
                        <?php if($cats->count() > 0): ?>
                            <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                                <table class="wt-tablecategories">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span class="wt-checkbox">
                                                    <input id="wt-name" type="checkbox" name="head">
                                                    <label for="wt-name"></label>
                                                </span>
                                            </th>
                                            <th><?php echo e(trans('lang.cat_icon')); ?></th>
                                            <th><?php echo e(trans('lang.name')); ?></th>
                                            <th><?php echo e(trans('lang.slug')); ?></th>
                                            <th><?php echo e(trans('lang.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 0; ?>
                                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="del-<?php echo e($cat->id); ?>">
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-check-<?php echo e($counter); ?>" type="checkbox" name="head">
                                                        <label for="wt-check-<?php echo e($counter); ?>"></label>
                                                    </span>
                                                </td>
                                                <td data-th="Icon"><span class="bt-content"><figure><img src="<?php echo e(asset(\App\Helper::getCategoryImage($cat->image))); ?>" alt="<?php echo e($cat->title); ?>"></figure></span></td>
                                                <td><?php echo e($cat->title); ?></td>
                                                <td><?php echo e($cat->slug); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="<?php echo e(url('admin/categories/edit-cats')); ?>/<?php echo e($cat->id); ?>" class="wt-addinfo wt-skillsaddinfo">
                                                            <i class="lnr lnr-pencil"></i>
                                                        </a>
                                                        <delete :title="'<?php echo e(trans("lang.ph_delete_confirm_title")); ?>'" :id="'<?php echo e($cat->id); ?>'" :message="'<?php echo e(trans("lang.ph_cat_delete_message")); ?>'" :url="'<?php echo e(url('admin/categories/delete-cats')); ?>'"></delete>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php if( method_exists($cats,'links') ): ?>
                                    <?php echo e($cats->links('pagination.custom')); ?>

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