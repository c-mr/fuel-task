<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-2"><label class="control-label" for="form_staff_no">Staff No</label></div>
            <div class="col-sm-10"><?= sprintf('%07d', $staff['staff_no']) ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"><label class="control-label" for="form_name">Name</label></div>
            <div class="col-sm-10"><?= $staff['name'] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"><label class="control-label" for="form_department">Department</label></div>
            <div class="col-sm-10"><?= $department_arr[$staff['department']] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-2"><label class="control-label" for="form_gender">Gender</label></div>
            <div class="col-sm-10"><?= $gender_arr[$staff['gender']] ?></div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php echo Html::anchor('staff/edit/'.$staff['id'],'Edit', ['class' => 'btn btn-primary']);?>
            <form class="form-horizontal" action="<?= Uri::create('staff/destory') ?>" name="delete_form" accept-charset="utf-8" method="post">
                <input name="fuel_csrf_token" value="<?= Security::fetch_token() ?>" type="hidden" id="form_fuel_csrf_token" />
                <input name="id" value="<?= $staff['id'] ?>" type="hidden" id="id" />
                <input class="btn btn-danger" name="delete_button" value="Delete" type="button" id="delete_button" />
            </form>
            </div>
        </div>

    </div>
</div><?php echo Asset::js('del_submit.js'); ?>