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
        <?php echo Form::open(['class' => 'form-horizontal']);?>

        <div class="form-group">
            <?php echo Form::label('Staff No', 'staff_no', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
            <?php echo Form::input('staff_no', Session::get_flash('staff_no'), ['class' => 'form-control']);?>

            <?php if($val->error('staff_no')):?>
                <p class="alert alert-warning"><?php echo $val->error('staff_no');?></p>
            <?php endif;?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('Name', 'name', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
            <?php echo Form::input('name', Session::get_flash('name'), ['class' => 'form-control']);?>

            <?php if($val->error('name')):?>
                <p class="alert alert-warning"><?php echo $val->error('name');?></p>
            <?php endif;?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('Department', 'department', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
            <?php echo Form::select('department', Session::get_flash('department'), ['' => 'Select']+$department_arr,['class' => 'form-control']);?>

            <?php if($val->error('department')):?>
                <p class="alert alert-warning"><?php echo $val->error('department');?></p>
            <?php endif;?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('Gender', 'gender', ['class' => 'col-sm-4 control-label']); ?>
            <div class="col-sm-8">
                <?php foreach ($gender_arr as $key => $value) { ?>
                    <?php echo Form::label($value.Form::radio('gender', $key, Session::get_flash('gender'), ['id' => 'form_gender'.$key]), 'gender'.$key, ['class' => 'radio-inline']); ?>
                <?php }; ?>

            <?php if($val->error('gender')):?>
                <p class="alert alert-warning"><?php echo $val->error('gender');?></p>
            <?php endif;?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
            <?php echo Form::submit('submit', 'Send', ['class' => 'btn btn-success']);?>

            <?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
            </div>
        </div>

        <?php echo Form::close();?>
    </div>
</div>