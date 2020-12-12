
<?php $__env->startSection('content'); ?>
    <section class="wt-haslayout wt-dbsectionspace" id="settings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">
                <?php if(Session::has('message')): ?>
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'<?php echo e(Session::get('message')); ?>'" v-cloak></flash_messages>
                    </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <ul class="wt-jobalerts">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flash_msg">
                                <flash_messages :message_class="'danger'" :time ='10' :message="'<?php echo e($error); ?>'" v-cloak></flash_messages>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
                <div class="wt-dashboardbox">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2><?php echo e(trans('lang.email_templates')); ?></h2>
                        <?php echo Form::open(['url' => url('admin/email-templates'),
                            'method' => 'get', 'class' => 'wt-formtheme wt-formsearch']); ?>

                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="<?php echo e(!empty($_GET['keyword']) ? $_GET['keyword'] : ''); ?>"
                                        class="form-control" placeholder="<?php echo e(trans('lang.ph_search_templates')); ?>">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                        <?php echo Form::close(); ?>

                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                        <table class="wt-tablecategories">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('lang.title')); ?></th>
                                    <th><?php echo e(trans('lang.subject')); ?></th>
                                    <th><?php echo e(trans('lang.type')); ?></th>
                                    <th><?php echo e(trans('lang.role')); ?></th>
                                    <th><?php echo e(trans('lang.action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($template->title); ?></td>
                                        <td><?php echo e($template->subject); ?></td>
                                        <td><?php echo e($template->email_type); ?></td>
                                        <td><?php echo e(Helper::getRoleNameByRoleID($template->role_id)); ?></td>
                                        <td>
                                            <div class="wt-actionbtn">
                                                <a href="<?php echo e(url('admin/email-templates/'.$template->id)); ?>" class="wt-addinfo wt-skillsaddinfo"><i class="lnr lnr-pencil"></i></a>
                                                <a href="javascript:void(0);" v-on:click.prevent="emailContent('myModalRef-<?php echo e($key); ?>')" class="wt-addinfo wt-skillsaddinfo"><i class="lnr lnr-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <b-modal ref="myModalRef-<?php echo e($key); ?>" hide-footer title="Email Content" v-cloak>
                                        <div class="d-block text-center">
                                            <?php echo Form::open(['url' => '', 'class' =>'wt-formtheme wt-formfeedback', 'id' => 'update_content-'.$key,  '@submit.prevent'=>'']); ?>

                                                <div class="form-group">
                                                    <?php echo Form::textarea('email_content', $template->content, array('class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor'.$key) ); ?>

                                                </div>
                                            <?php echo Form::close(); ?>

                                         </div>
                                    </b-modal>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if( method_exists($templates,'links') ): ?>
                            <?php echo e($templates->links('pagination.custom')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('back-end.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>