<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2><?php echo e(trans('lang.package')); ?></h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-packages">
                        <div class="wt-package wt-packagedetails">
                            <div class="wt-packagehead">
                            </div>
                            <div class="wt-packagecontent">
                                <ul class="wt-packageinfo">
                                    <?php $__currentLoopData = $package_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <li <?php if($options == 'Price'): ?> class="wt-packageprices" <?php endif; ?>><span><?php echo e($options); ?></span></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <?php  
                            $options = unserialize($package->options);
                            $banner = $options['banner_option'] = 1 ? 'ti-check' : 'ti-na';
                            $chat = $options['private_chat'] = 1 ? 'ti-check' : 'ti-na';
                        ?> 
                        <div class="wt-package wt-baiscpackage">
                            <div class="wt-packagehead">
                                <h3><?php echo e($package->title); ?></h3>
                                <span><?php echo e($package->subtitle); ?></span>
                            </div>
                            <div class="wt-packagecontent">
                                <ul class="wt-packageinfo">
                                    <li class="wt-packageprice"><span><sup>$</sup><?php echo e($package->cost); ?><sub>\ <?php echo e($options['duration']); ?></sub></span></li>
                                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php  
                                            if ($key == 'banner_option' || $key == 'private_chat') {
                                                $class = $option == true ? 'ti-check' : 'ti-na'; 
                                            }
                                        ?> 
                                        <?php if($key == 'banner_option' || $key == 'private_chat'): ?>
                                            <li><span><i class="<?php echo e($class); ?>"></i></span></li>
                                        <?php else: ?> 
                                            <li><span> <?php echo e($option); ?></span></li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <?php
                                    session()->put(['product_id' => e($package->id)]);  
                                    session()->put(['product_title' => e($package->title)]); 
                                    session()->put(['product_price' => e($package->cost)]); 
                                    session()->put(['type' => 'package']); 
                                ?>
                                <a class="wt-btn" href="<?php echo e(url('bkash/ec-checkout')); ?>"><span><?php echo e(trans('Bkash')); ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>