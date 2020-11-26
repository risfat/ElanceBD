<div class="wt-widget wt-reportjob">
    <div class="wt-widgettitle">
        <h2><?php echo e(trans('lang.report_job')); ?></h2>
    </div>
    <div class="wt-widgetcontent">
        <?php echo Form::open(['url' => url('submit-report'), 'class' =>'wt-formtheme wt-formreport', 'id' => 'submit-report',  '@submit.prevent'=>'submitReport("'.$job->id.'","job-report")']); ?>

            <fieldset>
                <div class="form-group">
                    <span class="wt-select">
                        <?php echo Form::select('reason', \Illuminate\Support\Arr::pluck($reasons, 'title'), null ,array('class' => '', 'placeholder' => trans('lang.select_reason'), 'v-model' => 'report.reason')); ?>

                    </span>
                </div>
                <div class="form-group">
                    <?php echo Form::textarea( 'description', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc'), 'v-model' => 'report.description'] ); ?>

                </div>
                <div class="form-group wt-btnarea">
                    <?php echo Form::submit(trans('lang.btn_submit'), ['class' => 'wt-btn', 'id'=>'submit-profile']); ?>

                </div>
            </fieldset>
        <?php echo form::close();; ?>

    </div>
</div>
