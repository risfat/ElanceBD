<?php if( Schema::hasTable('site_managements')): ?>
    <?php
        $footer = \App\SiteManagement::getMetaValue('footer_settings');
        $search_menu = \App\SiteManagement::getMetaValue('search_menu');
        $menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
    ?>
    <?php if(!empty($footer)): ?>
        <footer id="wt-footer" class="wt-footer wt-haslayout">
            <div class="wt-footerholder wt-haslayout">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="wt-footerlogohold">
                                
                                    <strong class="wt-logo"><a href="<?php echo e(url('/')); ?>"><b>ElanceBD</b></a></strong>
                               
                                <?php if(!empty($footer['description'])): ?>
                                    <div class="wt-description">
                                        <p><?php echo e(str_limit($footer['description'], 150)); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php Helper::displaySocials(); ?>
                            </div>
                        </div>
                        <?php if(!empty($footer['menu_title_1']) || !empty($footer['menu_pages_1'])): ?>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-footercol wt-widgetcompany">
                                    <?php if(!empty($footer['menu_title_1'])): ?>
                                        <div class="wt-fwidgettitle">
                                            <h3><?php echo e($footer['menu_title_1']); ?></h3>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($footer['menu_pages_1'])): ?>
                                        <ul class="wt-fwidgetcontent">
                                            <?php $__currentLoopData = $footer['menu_pages_1']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu_1_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php  $page = \App\Page::where('id', $menu_1_page)->first(); ?>
                                                <?php if(!empty($page)): ?>
                                                    <li><a href="<?php echo e(url('page/'.$page->slug)); ?>"><?php echo e($page->title); ?></a></li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($search_menu) || !empty($menu_title)): ?>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-footercol wt-widgetcompany">
                                    <?php if(!empty($menu_title)): ?>
                                        <div class="wt-fwidgettitle">
                                            <h3><?php echo e($menu_title->meta_value); ?></h3>
                                        </div>
                                    <?php endif; ?>
                                    <ul class="wt-fwidgetcontent">
                                        <?php $__currentLoopData = $search_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a href="<?php echo url($page['url']); ?>"><?php echo e($page['title']); ?></a></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="wt-haslayout wt-footerbottom">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <p class="wt-copyrights"><span>Copyright © 2020 Team xTmos, All Right Reserved RisfBD</p>
                            <?php if(!empty($footer['pages'])): ?>
                                <nav class="wt-addnav">
                                    <ul>
                                        <?php $__currentLoopData = $footer['pages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $page = \App\Page::where('id', $menu_page)->first(); ?>
                                            <?php if(!empty($page)): ?>
                                                <li><a href="<?php echo e(url('page/'.$page->slug)); ?>"><?php echo e($page->title); ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    <?php endif; ?>
<?php endif; ?>
