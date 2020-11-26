<?php echo Form::open(['url' => '', 'class' => 'wt-formtheme wt-skillsform', 'id'=>'search-menu', '@submit.prevent'=>'submitSearchMenu']); ?>

    <div class="wt-tabscontenttitle">
        <h2><?php echo e(trans('lang.search_menu')); ?></h2>
    </div>
    <fieldset class="search-content">
        <?php if(!empty($unserialize_menu_array) && !empty($menu_title)): ?>
            <?php $counter = 0; ?>
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <?php echo Form::text('menu_title', $menu_title->meta_value,
                        array('class' => 'form-control', 'placeholder' => trans('lang.menu_title'))); ?>

                </div>
            </div>
            <?php $__currentLoopData = $unserialize_menu_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unserialize_key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="wrap-search wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            <?php echo Form::text('search['.$counter.'][title]', $value['title'], ['class' => 'form-control author_title']); ?>

                            <?php echo Form::text('search['.$counter.'][url]', $value['url'], ['class' => 'form-control author_title']); ?>

                        </div>
                        <div class="form-group wt-rightarea">
                            <?php if($unserialize_key == 0 ): ?>
                                <span class="wt-addinfobtn" @click="addSearchItem"><i class="fa fa-plus"></i></span> 
                            <?php else: ?>
                                <span class="wt-addinfobtn wt-deleteinfo delete-search" data-check="<?php echo e($counter); ?>">
                                    <i class="fa fa-trash"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php $counter++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    <?php echo Form::text('menu_title', null, array('class' => 'form-control', 'placeholder' => trans('lang.menu_title'))); ?>

                </div>
            </div>
            <div class="wrap-search wt-haslayout">
                <div class="form-group">
                    <div class="form-group-holder">
                        <?php echo Form::text('search[0][title]', null, ['class' => 'form-control author_title',
                            'placeholder' => trans('lang.ph_title'),'v-model' => 'first_search_title']); ?>

                        <?php echo Form::text('search[0][url]', null, ['class' => 'form-control author_title',
                            'placeholder' => trans('lang.ph_url'),'v-model' => 'first_search_url']); ?>

                    </div>
                    <div class="form-group wt-rightarea">
                        <span class="wt-addinfo" @click="addSearchItem"><i class="fa fa-plus"></i></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
            <div v-for="(search, index) in searches" v-cloak>
                <div class="wrap-search wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            <input placeholder="<?php echo e(trans('lang.ph_title')); ?>" v-bind:name="'search['+[search.count]+'][title]'"
                                type="text" class="form-control" v-model="search.search_title">
                            <input placeholder="<?php echo e(trans('lang.ph_url')); ?>" v-bind:name="'search['+[search.count]+'][url]'"
                                type="text" class="form-control" v-model="search.search_url">
                            <div class="form-group wt-rightarea">
                                <span class="wt-addinfo wt-deleteinfo wt-addinfobtn" @click="removeSearchItem(index)"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </fieldset>
    <div class="wt-updatall la-updateall-holder">
        <?php echo Form::submit(trans('lang.btn_submit'), ['class' => 'wt-btn wt-btnactive']); ?>

    </div>
<?php echo Form::close(); ?>

