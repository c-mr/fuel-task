<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-2"><?php echo Form::label('Staff No', 'staff_no', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10"><?= $staff['staff_no'] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?php echo Form::label('Name', 'name', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10"><?= $staff['name'] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?php echo Form::label('Department', 'department', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10"><?= $department_arr[$staff['department']] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"> <?php echo Form::label('Gender', 'gender', ['class' => 'control-label']); ?></div>
            <div class="col-sm-10"><?= $gender_arr[$staff['gender']] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php echo Html::anchor('./staff/edit/'.$staff['id'],'Edit', ['class' => 'btn btn-primary']);?>
            </div>
        </div>

    </div>
</div>