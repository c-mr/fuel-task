<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">
        <?php echo Form::open(['action'=>'staff/insert','class' => 'form-horizontal']); ?>

        <div class="form-group">
            <?php echo Form::label('Staff No', 'staff_no', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
                <?= $staff_no; ?>
                <?php echo Form::hidden('staff_no', $staff_no); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('Name', 'name', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
                <?= $name; ?>
                <?php echo Form::hidden('name', $name); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('Department', 'department', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
                <?= $department_arr[$department]; ?>
                <?php echo Form::hidden('department', $department); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('Gender', 'gender', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
                <?= $gender_arr[$gender]; ?>
                <?php echo Form::hidden('gender', $gender); ?>
            </div>
        </div>

          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
            <?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()); ?>
                <?php echo Form::hidden('act', $act); ?>

            <?php echo Form::submit('act', 'Send', ['class' => 'btn btn-success']); ?>&nbsp;&nbsp;
            <?php echo Form::submit('back', 'Back', ['class' => 'btn btn-default']); ?>
            </div>
          </div>

        <?php echo Form::close(); ?>
    </div>
</div>