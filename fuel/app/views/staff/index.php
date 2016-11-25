<form id="serach_form" class="form-horizontal" action="<?= Uri::current() ?>" accept-charset="utf-8" method="get" name="form">
    <div class="input-group">
        <span class="input-group-addon">Key Word</span>
        <input type="text" class="form-control" name="keyword" value="<?= e(Input::get('keyword') ? Input::get('keyword') : '') ?>" placeholder="Keyword">

        <span class="input-group-addon">
            <?php foreach ($gender_arr as $key => $value):?>
            <label style="padding-top: 0px;" class="radio-inline" for="form_gender_<?= $key ?>"><input id="form_gender_<?= $key ?>" name="gender" value="<?= $key ?>" type="radio"<?= Input::get('gender') == $key ? ' checked="checked"' : '' ?> /><?= $value ?></label>
            <?php endforeach; ?>
        </span>

        <span class="input-group-btn">
            <button type="button" class="btn btn-success" id="serach_button">Serach</button>
            <button type="button" class="btn btn-warning" id="reset_button">Reset</button>
        </span>
    </div>
</form>

<table id="staffs-table" class="table table-striped">
    <thead>
        <tr>
            <th>Staff No</th>
            <th>Name</th>
            <th>Department</th>
            <th>Gender</th>
            <th>&nbsp</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($staffs as $staff) {
?>
        <tr>
            <td><?= sprintf('%07d', $staff['staff_no']) ?></td>
            <td><?= $staff['name'] ?></td>
            <td><?= $department_arr[$staff['department']]; ?></td>
            <td><?= $gender_arr[$staff['gender']]; ?></td>
            <td><?php echo Html::anchor('staff/detail/'.$staff['id'],'Detail');?></td>
        </tr>
<?php
}
?>
    </tbody>
</table>

<?php echo Pagination::instance('pagination')->render(); ?>


<div class="row"><?php echo Html::anchor('staff/add','New Entry', ['class' => 'btn btn-primary']);?></div>

<?php echo Asset::js('staff.js'); ?>