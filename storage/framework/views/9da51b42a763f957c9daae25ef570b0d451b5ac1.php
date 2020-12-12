
<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left" id="packages">
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle">
                        <h2><?php echo e(trans('lang.packages')); ?></h2>
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
                        <?php if(!empty($packages) && $packages->count() > 0): ?>
                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php  $options = unserialize($package->options); ?> 
                                <?php if(!empty($package)): ?>
                                    <div class="wt-package wt-baiscpackage">
                                        <?php if(!empty($package->title || $package->subtitle )): ?>
                                            <div class="wt-packagehead">
                                                <h3><?php echo e($package->title); ?></h3>
                                                <span><?php echo e($package->subtitle); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="wt-packagecontent">
                                            <ul class="wt-packageinfo">
                                                <li class="wt-packageprice"><span><sup>$</sup><?php echo e($package->cost); ?><sub>\ <?php echo e(Helper::getPackageDurationList($options['duration'])); ?></sub></span></li>
                                                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php  
                                                        if ($key == 'banner_option' || $key == 'private_chat') {
                                                            $class = $option == true ? 'ti-check' : 'ti-na'; 
                                                        }
                                                    ?> 
                                                    <?php if($key == 'banner_option' || $key == 'private_chat'): ?>
                                                        <li><span><i class="<?php echo e($class); ?>"></i></span></li>
                                                    <?php elseif($key == 'duration'): ?> 
                                                        <li><span> <?php echo e(Helper::getPackageDurationList($options['duration'])); ?></span></li>
                                                    <?php elseif($key == 'badge'): ?>
                                                        <li><span> <?php echo e(Helper::getBadgeTitle($package->badge_id)); ?></span></li>
                                                    <?php else: ?>
                                                        <li><span> <?php echo e($option); ?></span></li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                            <?php if(Auth::user()->getRoleNames()[0] != "admin"): ?>
                                                <?php if(in_array($package->id, $purchase_packages)): ?> 
                                                    <a class="wt-btn" href="javascript:void(0);" style="pointer-events:none"><span><?php echo e(trans('lang.purchased')); ?></span></a>  
                                                <?php else: ?> 
                                                    <a class="wt-btn" v-on:click.prevent="getPurchasePackage('<?php echo e($package->id); ?>')" href="javascript:void(0);"><span><?php echo e(trans('lang.buy_now')); ?></span></a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 float-left">
                                <div class="wt-jobalerts">
                                    <div class="alert alert-warning alert-dismissible fade show">
                                        <em>Alert:</em> <span> Your are currently on trial package</span>
                                        <a href="javascript:void(0)" class="wt-alertbtn warning">Buy Now</a>
                                        <a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left">
                                <div class="row justify-content-md-center">
                                    <div class="wt-sectionhead wt-textcenter">
                                        <div class="wt-sectiontitle">
                                            <h1><i class="ti-face-sad"></i></h1>
                                            <span><?php echo e(trans('lang.no_pkg_found')); ?></span>
                                        </div>
                                        <a href="<?php echo e(url('/')); ?>" class="btn btn-default wt-btn"><span class="ti-home"></span> <?php echo e(trans('lang.home')); ?></a>
                                    </div>
                                </div> 
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>