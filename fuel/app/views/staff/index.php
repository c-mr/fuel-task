<table class="table table-striped">
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
