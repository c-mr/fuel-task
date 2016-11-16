<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">
        <?php echo Form::open(['class' => 'form-horizontal']); ?>

        <div class="form-group">
            <div class="col-sm-2"><?php echo Form::label('Staff No', 'staff_no', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10">
                <?php echo Form::input('staff_no', Input::post('staff_no', isset($staff) ? sprintf('%07d', $staff['staff_no']) : '') , ['class' => 'form-control', 'placeholder'=>'Staff No']); ?>
                <?php if($val->error('staff_no')):?>
                    <p class="alert alert-warning"><?php echo $val->error('staff_no'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2"><?php echo Form::label('Name', 'name', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10">
                <?php echo Form::input('name', Input::post('name', isset($staff) ? $staff['name'] : ''), ['class' => 'form-control', 'placeholder'=>'Name']); ?>
                <?php if($val->error('name')):?>
                    <p class="alert alert-warning"><?php echo $val->error('name'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2"><?php echo Form::label('Department', 'department', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10">
                <?php echo Form::select('department', Input::post('department', isset($staff) ? $staff['department'] : ''), ['' => 'Select']+$department_arr, ['class' => 'form-control', 'placeholder'=>'Department']); ?>
                <?php if($val->error('department')):?>
                    <p class="alert alert-warning"><?php echo $val->error('department'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2"><?php echo Form::label('Gender', 'gender', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10">
                <?php foreach ($gender_arr as $key => $value) { ?>
                    <?php echo Form::label($value.Form::radio('gender', $key, Input::post('gender', isset($staff) ? $staff['gender'] : ''), ['id' => 'form_gender'.$key]), 'gender'.$key, ['class' => 'radio-inline']); ?>
                <?php }; ?>
                <?php if($val->error('gender')):?>
                    <p class="alert alert-warning"><?php echo $val->error('gender'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
            <?php echo Form::hidden('act', $act); ?>
            <?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()); ?>
            <?php echo Form::submit('submit', 'Send', ['class' => 'btn btn-success']); ?>
            </div>
        </div>

        <?php echo Form::close(); ?>
    </div>
</div>