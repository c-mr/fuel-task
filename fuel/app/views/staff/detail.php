<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="./">Staff List</a>
        </div>

        <div class="collapse navbar-collapse" id="navbarEexample1">
            <ul class="nav navbar-nav">
                <li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('staff/index','Index');?></li>
            </ul>
        </div>
    </div>
</nav>

<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-2"><?php echo Form::label('Staff No', 'staff_no', ['class' => 'control-label']); ?></div>
            <div class="col-sm-6"><?= $staff["staff_no"] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?php echo Form::label('Name', 'name', ['class' => 'control-label']); ?></div>
            <div class="col-sm-6"><?= $staff["name"] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"><?php echo Form::label('Department', 'department', ['class' => 'control-label']); ?></div>
            <div class="col-sm-6"><?= $department_arr[$staff["department"]] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"> <?php echo Form::label('Gender', 'gender', ['class' => 'control-label']); ?></div>
            <div class="col-sm-6"><?= $gender_arr[$staff["gender"]] ?></div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-12">
            </div>
        </div>

    </div>
</div>