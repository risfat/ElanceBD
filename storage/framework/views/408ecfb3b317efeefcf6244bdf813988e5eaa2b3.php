<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 float-right" id="invoice_list">
                <div class="wt-dashboardbox wt-dashboardinvocies">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2><?php echo e(trans('lang.payouts')); ?></h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder wt-categoriesholder">
                        <table class="wt-tablecategories">
                            <thead>
                                <tr>
                                    <th>
                                        <span class="wt-checkbox">
                                            <input id="wt-name" type="checkbox" name="head">
                                            <label for="wt-name"></label>
                                        </span>
                                    </th>
                                    <th><?php echo e(trans('lang.user_name')); ?></th>
                                    <th><?php echo e(trans('lang.amount')); ?></th>
                                    <th><?php echo e(trans('lang.payment_method')); ?></th>
                                    <th><?php echo e(trans('lang.processing_date')); ?></th>
                                </tr>
                            </thead>
                            <?php if($payouts->count() > 0): ?>
                                <tbody>
                                    <?php $__currentLoopData = $payouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span class="wt-checkbox">
                                                    <input id="wt-<?php echo e($key); ?>" type="checkbox" name="head">
                                                    <label for="wt-<?php echo e($key); ?>"></label>
                                                </span>
                                            </td>
                                            <td><?php echo e(Helper::getUserName($payout->user_id)); ?></td>
                                            <td><?php echo e(Helper::currencyList($payout->currency)['symbol']); ?><?php echo e($payout->amount); ?></td>
                                            <td><?php echo e($payout->payment_method); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($payout->created_at)->format('M d, Y')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            <?php endif; ?>
                        </table>
                        <?php if($payouts->count() === 0): ?>
                            <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                        <?php if( method_exists($payouts,'links') ): ?> 
                            <?php echo e($payouts->links('pagination.custom')); ?> 
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>