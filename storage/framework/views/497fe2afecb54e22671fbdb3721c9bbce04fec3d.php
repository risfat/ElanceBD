
<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 float-right" id="invoice_list">
                <div class="wt-dashboardbox wt-dashboardinvocies">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2><?php echo e(trans('lang.invoices')); ?></h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder wt-categoriesholder" id="printable_area">
                        <?php if(!empty($invoices) && $invoices->count() > 0): ?>
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="wt-checkbox">
                                                <input id="wt-name" type="checkbox" name="head">
                                                <label for="wt-name"></label>
                                            </span>
                                        </th>
                                        <th><?php echo e(trans('lang.invoice_id')); ?></th>
                                        <th><?php echo e(trans('lang.purchase_date')); ?></th>
                                        <th><?php echo e(trans('lang.expriry_date')); ?></th>
                                        <th><?php echo e(trans('lang.amount')); ?></th>
                                        <th><?php echo e(trans('lang.action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $package_options = unserialize($invoice->options);
                                            if ($package_options['duration'] === 10){
                                                    $expiry_date = (!empty($invoice) && !empty($invoice->created_at)) ? $invoice->created_at->addDays(4) : '';
                                            } elseif ($package_options['duration'] === 30){
                                                    $expiry_date = (!empty($invoice) && !empty($invoice->created_at)) ? $invoice->created_at->addDays(30): '';
                                            } elseif ($package_options['duration'] === 360){
                                                    $expiry_date = (!empty($invoice) && !empty($invoice->created_at)) ? $invoice->created_at->addDays(360) : '';
                                            }
                                        ?>
                                        <?php if(!empty($invoice)): ?>
                                            <tr>
                                                <td>
                                                    <span class="wt-checkbox">
                                                        <input id="wt-<?php echo e($invoice->id); ?>" type="checkbox" name="head">
                                                        <label for="wt-<?php echo e($invoice->id); ?>"></label>
                                                    </span>
                                                </td>
                                                <td><?php echo e($invoice->invoice_id); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($invoice->created_at)->format('M d, Y')); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($expiry_date)->format('M d, Y')); ?></td>
                                                <td><?php echo e(!empty($symbol) ? $symbol['symbol'] : '$'); ?><?php echo e($invoice->price); ?></td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a class="print-window wt-addinfo wt-skillsaddinfo" href="<?php echo e(url('show/invoice/'.$invoice->id)); ?>"><?php echo e(trans('lang.view_invoice')); ?></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php echo $__env->make('errors.no-record', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                        <?php if( method_exists($invoices,'links') ): ?>
                            <?php echo e($invoices->links('pagination.custom')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>