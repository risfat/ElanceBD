 
<?php $__env->startSection('content'); ?>
    <?php $breadcrumbs = Breadcrumbs::generate('showPage',$page, $slug); ?> 
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                        <?php if(!empty($page)): ?>
                            <div class="wt-title">
                                <h2><?php echo e($page->title); ?></h2>
                            </div>
                        <?php endif; ?>
                        <?php if(count($breadcrumbs)): ?>
                            <ol class="wt-breadcrumb">
                                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <?php if($breadcrumb->url && !$loop->last): ?>
                                        <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
                                    <?php else: ?>
                                        <li class="active"><?php echo e($breadcrumb->title); ?></li>
                                    <?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ol>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($page)): ?>
        <div class="wt-contentwrappers">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                        <div class="wt-howitwork-hold wt-haslayout">
                            <div class="wt-haslayout wt-main-section">
                                <?php echo htmlspecialchars_decode(stripslashes($page->body)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?> 
        <?php echo $__env->make('errors.404', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front-end.master', ['body_class' => 'wt-innerbgcolor'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>