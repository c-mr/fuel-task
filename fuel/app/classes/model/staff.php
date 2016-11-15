<?php

class Model_Staff extends \Orm\Model
{
    protected static $_properties = [

        'id',
        'staff_no',
        'name',
        'department',
        'gender',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    protected static $_table_name = 'staffs';

    //バリデーション
    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        // 追加validation呼出
        $val->add_callable('AddValidation');
        $val->add('staff_no', 'Staff No')
                    ->add_rule('required')
                    ->add_rule('unique', 'staffs.staff_no')
                    ->add_rule('exact_length', 7);
        $val->add('name', 'Name')->add_rule('required')
                    ->add_rule('max_length', 200);
        $val->add('department', 'Department')->add_rule('required');
        $val->add('gender', 'Gender')->add_rule('required');
        return $val;
    }
}
