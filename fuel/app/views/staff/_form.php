<div class="form-group">
    <div class="col-sm-2">
        <label class="control-label" for="form_staff_no">Staff No</label>
    </div>
    <div class="col-sm-10">
        <input class="form-control" placeholder="Staff No" name="staff_no" value="<?= Input::post('staff_no', isset($staff) ? $staff['staff_no'] : '') ?>" type="text" id="form_staff_no" />
        <?php if($val->error('staff_no')):?>
            <p class="alert alert-warning"><?= $val->error('staff_no'); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2">
        <label class="control-label" for="form_name">Name</label>
    </div>
    <div class="col-sm-10">
        <input class="form-control" placeholder="Name" name="name" value="<?= Input::post('name', isset($staff) ? $staff['name'] : '') ?>" type="text" id="form_name" />
        <?php if($val->error('name')):?>
            <p class="alert alert-warning"><?= $val->error('name'); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2">
        <label class="control-label" for="form_department">Department</label>
    </div>
    <div class="col-sm-10">
        <select class="form-control" name="department" id="form_department">
            <option value="">Select</option>
            <?php foreach ($department_arr as $key => $value):?>
            <option value="<?= $key ?>" <?= Input::post('department', isset($staff) ? ($staff['department'] == $key ? ' selected="selected"' : '') : '') ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <?php if($val->error('department')):?>
            <p class="alert alert-warning"><?= $val->error('department'); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2">
        <label class="control-label" for="form_gender">Gender</label>
    </div>
    <div class="col-sm-10">
        <?php foreach ($gender_arr as $key => $value):?>
        <label class="radio-inline" for="form_gender_<?= $key ?>"><?= $value ?>
            <input id="form_gender_<?= $key ?>" name="gender" value="<?= $key ?>" type="radio" <?= Input::post('gender', isset($staff) ? ($staff['gender'] == $key ? ' checked="checked"' : '') : '') ?> />
        </label>
        <?php endforeach; ?>
        <?php if($val->error('gender')):?>
            <p class="alert alert-warning"><?= $val->error('gender'); ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <input class="btn btn-success" name="submit" value="Send" type="submit" id="form_submit" /> </div>
</div>