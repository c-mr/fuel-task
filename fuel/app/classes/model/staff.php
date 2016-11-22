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

    // protected static $_observers = [
    //     'Orm\Observer_CreatedAt' => [
    //         'events' => ['before_insert'],
    //         'mysql_timestamp' => true,
    //     ],
    //     'Orm\Observer_UpdatedAt' => [
    //         'events' => ['before_update'],
    //         'mysql_timestamp' => true,
    //     ],
    // ];

    protected static $_table_name = 'staffs';

    /**
     * 入力チェック
     */
    public static function validate($factory, $id = null)
    {
        $val = Validation::forge($factory);

        // 追加validation呼出
        $val->add_callable('AddValidation');

        $val->add('staff_no', 'Staff No')
            ->add_rule('required')
            ->add_rule('unique', 'staffs.staff_no', $id)
            ->add_rule('exact_length', 7);

        $val->add('name', 'Name')
            ->add_rule('required')
            ->add_rule('max_length', 200);

        $val->add('department', 'Department')
            ->add_rule('required');

        $val->add('gender', 'Gender')
            ->add_rule('required');

        return $val;
    }

    /**
     * スタッフリストページネーション
     * @return [Object] ページネーションのコンフィグやテンプレートなど
     */
    public static function staff_list_pagination()
    {
        // ページネーション
        $sql = DB::query('SELECT count(*) AS count FROM `staffs` WHERE deleted_at IS NULL');


        $result= $sql->execute()->current();

        $total = $result['count'];

        $config = array(
            // 'pagination_url' => 'staff/index/',
            'total_items'   => $total,
            'uri_segment'   => 'p',
            'num_links'     => 4,
            'per_page'      => 7,
            'name'          => 'pagination',
            'show_first'    => true,
            'show_last'     => true,
        );

        return Pagination::forge('pagination', $config);
    }

    /**
     * スタッフリストSQL
     * @param  [Int]    $limit  [per_page]
     * @param  [Int]    $offset [limit]
     * @return [Object]         [SQL結果]
     */
    public static function staff_list_query($limit, $offset)
    {
        $sql = DB::query(sprintf(
                'SELECT * FROM `staffs` WHERE deleted_at IS NULL ORDER BY `id` DESC LIMIT %d OFFSET %d'
                , $limit
                , $offset
            ));


        return $sql->execute();
    }

    /**
     * 詳細画面SQL
     * @param  [Int]    $id  [SerialID]
     * @return [Object]      [SQL結果]
     */
    public static function staff_detail_query($id)
    {

        $sql = DB::query(sprintf('SELECT * FROM `staffs` WHERE `id` = %d', $id));


        return $sql->execute()->current();
    }

    /**
     * 新規登録SQL
     * @param  [Array]  $val [保存するデータ]
     * @return [Object]      [SQL結果]
     */
    public static function staff_insert_query($val)
    {
        $sql = DB::query(sprintf(
            'INSERT INTO `staffs` (`staff_no`, `name`, `department`, `gender`, `created_at`)'
            .' VALUES (\'%d\', \'%s\', \'%d\', \'%d\', now())'
            , $val['staff_no']
            , $val['name']
            , $val['department']
            , $val['gender']));

        return $sql->execute();
    }

    /**
     * 更新SQL
     * @param  [Int]    $id  [SerialID]
     * @param  [Array]  $val [保存するデータ]
     * @return [Object]      [SQL結果]
     */
    public static function staff_update_query($id, $val)
    {
        $sql = DB::query(sprintf(
            'UPDATE `staffs`'
            .' SET `staff_no` = \'%d\', `name` = \'%s\', `department` = \'%d\', `gender` = \'%d\', updated_at = now()'
            .' WHERE `id` = \'%d\''
            , $val['staff_no']
            , $val['name']
            , $val['department']
            , $val['gender']
            , $id));

        return $sql->execute();
    }

    /**
     * 削除SQL(論理削除)
     * @param  [Int]    $id  [SerialID]
     * @param  [Array]  $val [保存するデータ]
     * @return [Object]      [SQL結果]
     */
    public static function staff_delete_query($id)
    {
        $sql = DB::query(sprintf(
            'UPDATE `staffs` SET updated_at = now(), deleted_at = now() WHERE `id` = \'%d\''
            , $id));

        // SqlLog
        Log::write('ERROR', $sql);

        return $sql->execute();
    }

}