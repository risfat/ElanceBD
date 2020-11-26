
<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">
                <?php if(Session::has('message')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
                    </div>
                <?php endif; ?>
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2><?php echo e(trans('lang.manage_users')); ?></h2>
                        <form class="wt-formtheme wt-formsearch">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>"
                                        class="form-control" placeholder="<?php echo e(trans('lang.ph_search_users')); ?>">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                        <table class="wt-tablecategories">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('lang.user_name')); ?></th>
                                    <th><?php echo e(trans('lang.role')); ?></th>
                                    <th><?php echo e(trans('lang.action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $user = \App\User::find($user_data['id']); ?>
                                    <?php if($user->getRoleNames()->first() != 'admin'): ?>
                                        <tr>
                                            <td><?php echo e(ucwords(\App\Helper::getUserName($user->id))); ?></td>
                                            <td><?php echo e($user->getRoleNames()->first()); ?></td>
                                            <td>
                                                <div class="wt-actionbtn">
                                                    <a href="javascript:void()" v-on:click.prevent="deleteUser(<?php echo e($user->id); ?>)" class="wt-deleteinfo wt-skillsaddinfo"><i class="fa fa-trash"></i></a>
                                                    <a href="<?php echo e(url('profile/'.$user->slug)); ?>" class="wt-addinfo wt-skillsaddinfo"><i class="lnr lnr-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if( method_exists($users,'links') ): ?>
                            <?php echo e($users->links('pagination.custom')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>