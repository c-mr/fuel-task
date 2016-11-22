<?php

class Model_Staff
{
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
        $sql = DB::query('SELECT count(*) AS count FROM staffs WHERE deleted_at IS NULL');


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
        $sql = DB::query(
            'SELECT * FROM staffs'
            .' WHERE deleted_at IS NULL'
            .' ORDER BY id DESC'
            .' LIMIT :limit'
            .' OFFSET :offset'
        );

        // SQLインジェクション対策（複数の値をbindする時はparametersでも可)
        $sql->parameters(['limit' => $limit, 'offset' => $offset]);

        return $sql->execute();
    }

    /**
     * 詳細画面SQL
     * @param  [Int]    $id  [SerialID]
     * @return [Object]      [SQL結果]
     */
    public static function staff_detail_query($id)
    {
        $sql = DB::query('SELECT * FROM staffs WHERE id = :id');

        // SQLインジェクション対策(bind)
        $sql->bind('id', $id);


        return $sql->execute()->current();
    }

    /**
     * 新規登録SQL
     * @param  [Array]  $val [保存するデータ]
     * @return [Object]      [SQL結果]
     */
    public static function staff_insert_query($val)
    {
        $sql = DB::query(
            'INSERT INTO staffs (staff_no, name, department, gender, created_at)'
            .' VALUES (:staff_no, :name, :department, :gender, now())'
        );

        // SQLインジェクション対策(bind)
        $sql->bind('staff_no', $val['staff_no']);
        $sql->bind('name', $val['name']);
        $sql->bind('department', $val['department']);
        $sql->bind('gender', $val['gender']);

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
        $sql = DB::query(
            'UPDATE staffs'
            .' SET staff_no = :staff_no,'
            .' name = :name,'
            .' department = :department,'
            .' gender = :gender,'
            .' updated_at = now()'
            .' WHERE id = :id'
        );

        // SQLインジェクション対策(bind)
        $sql->bind('staff_no', $val['staff_no']);
        $sql->bind('name', $val['name']);
        $sql->bind('department', $val['department']);
        $sql->bind('gender', $val['gender']);
        $sql->bind('id', $id);

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
        $sql = DB::query(
            'UPDATE staffs SET updated_at = now(), deleted_at = now() WHERE id = :id'
        );

        // SQLインジェクション対策(bind)
        $sql->bind('id', $id);

        // SqlLog
        Log::write('ERROR', $sql);

        return $sql->execute();
    }

}