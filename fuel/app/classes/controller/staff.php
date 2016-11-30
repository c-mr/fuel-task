<?php

class Controller_Staff extends Controller_Hybrid
{

    private $staffs = ['staff_no', 'name', 'department', 'gender', 'hire_date'];

    private $icon_configuration = [
        'randomize'        => true,
        'ext_whitelist'    => ['img', 'jpg', 'jpeg', 'gif', 'png'],
        'path'             => DOCROOT.'/assets/img/upload_icon/',
        // 'max_size'         => 300*300,
    ];

    /**
     * INDEX画面(一覧)
     */
    public function action_index()
    {
        $view = \View::forge('staff/index');

        // 定義呼出
        Config::load('staff_master', true);
        $view->set('department_arr', Config::get('staff_master.department'));
        $view->set('gender_arr', Config::get('staff_master.gender'));

        // 検索
        $keyword = Input::get('keyword');
        $gender = Input::get('gender');

        // 検索Where句作成
        $where = Model_Staff::staff_make_where($keyword, $gender);

        // 検索 初期値はIDで降順
        $sort_col = Input::get('col') ? Input::get('col') : 'id';
        $sort_key = Input::get('key') ? Input::get('key') : 'DESC';

        // ソートorder by 作成
        $order_by = Model_Staff::staff_make_order($sort_col, $sort_key);

        // ページネーション呼出
        $pagination = Model_Staff::staff_list_pagination($where);
        $view->set('pagination', $pagination);

        $result = Model_Staff::staff_list_query($pagination->per_page, $pagination->offset, $order_by, $where);
        $view->set('staffs', $result);

        $this->template->title = 'Staff &raquo; Index';
        $this->template->content = $view;
    }

    /**
     * 新規登録
     */
    public function action_add()
    {
        // 共通化した部分(_form.php)に送るものはglobalをつける

        $view = \View::forge('staff/add');

        $view->set_global('title', "Staff Add");

        Config::load('staff_master', true);
        $view->set_global('department_arr', Config::get('staff_master.department'));
        $view->set_global('gender_arr', Config::get('staff_master.gender'));

        // 入力チェック呼出
        $val = Model_Staff::validate('add');
        $upload_error = "";


        if (Input::method() == 'POST') {

            foreach ($this->staffs as $staff) {
                $value_arr[$staff] = Input::post($staff);
                $view->set_global($staff, Input::post($staff));
            }

            // confは新規と変更、共用なのでどちらかの判別fromのactionに渡す
            $value_arr['action'] = 'insert';

            if (is_uploaded_file($_FILES['icon_upload']['tmp_name'])) {

                Upload::process($this->icon_configuration);


                if (Upload::is_valid()) {
                    Upload::save();

                    $file = Upload::get_files(0);

                    $icon = Model_Staff::staff_icon_add($file);

                    $value_arr['icon_id'] = $icon['id'];
                    $value_arr['icon_filename'] = $icon['filename'];
                    $view->set_global('icon_filename', $icon['filename']);
                }

                foreach (Upload::get_errors() as $file) {
                    $upload_error = $file['errors'][0]['message'];
                }

            }



            // 入力確認画面へ遷移
            if ($val->run() && !$upload_error && Security::check_token()) {
                Session::set('value_arr', $value_arr);
                Response::redirect('staff/conf');
            }

        }

        $view->set_global('val', $val);
        $view->set_global('upload_error', $upload_error);

        $this->template->title = 'Staff &raquo; Add';
        $this->template->content = $view;
    }

    /**
     * 詳細画面
     * @param  [int] $id
     */
    public function action_detail($id = null)
    {
        $view = \View::forge('staff/detail');

        $view->set('title', "Staff Detail");

        // 定義呼出
        Config::load('staff_master', true);
        $view->set('department_arr', Config::get('staff_master.department'));
        $view->set('gender_arr', Config::get('staff_master.gender'));

        $view->set('staff', Model_Staff::staff_detail_query($id));
        $icon = Model_Staff::staff_icon_call($id);
        $view->set('icon_filename', $icon['filename']);




        $view->set('action', Session::get_flash('action'));

        $this->template->title = 'Staff &raquo; Detail';
        $this->template->content = $view;
    }

    /**
     * 編集画面
     * @param  [int] $id
     */
    public function action_edit($id = null)
    {
        // 共通化した部分(_form.php)に送るものはglobal
        $view = \View::forge('staff/edit');

        $view->set_global('title', "Staff Edit");

        Config::load('staff_master', true);
        $view->set_global('department_arr', Config::get('staff_master.department'));
        $view->set_global('gender_arr', Config::get('staff_master.gender'));

        // 入力チェック呼出
        $val = Model_Staff::validate('edit', $id);
        $upload_error = "";

        // POSTされた各データをフラッシュセッションに保存
        if (Input::method() == 'POST') {

            foreach ($this->staffs as $staff) {
                $value_arr[$staff] = Input::post($staff);
                $view->set_global($staff, Input::post($staff));
            }

            // confは新規と変更、共用なのでどちらかの判別fromのactionに渡す
            $value_arr['action'] = 'update';

            if (is_uploaded_file($_FILES['icon_upload']['tmp_name'])) {

                Upload::process($this->icon_configuration);


                if (Upload::is_valid()) {
                    Upload::save();

                    $file = Upload::get_files(0);

                    $icon = Model_Staff::staff_icon_add($file);

                    $value_arr['icon_id'] = $icon['id'];
                    $value_arr['icon_filename'] = $icon['filename'];
                    $view->set_global('icon_filename', $icon['filename']);
                }

                foreach (Upload::get_errors() as $file) {
                    $upload_error = $file['errors'][0]['message'];
                }

            }

            // 入力確認画面へ遷移
            if ($val->run() && !$upload_error && Security::check_token()) {
                Session::set('value_arr', $value_arr);
                Session::set('id', $id);
                Response::redirect('staff/conf');
            }

        }else{
            $staffs_detail = Model_Staff::staff_detail_query($id);
            Debug::dump($staffs_detail);
            foreach ($this->staffs as $staff) {
                $view->set_global($staff, $staffs_detail[$staff]);
            }
            $icon = Model_Staff::staff_icon_call($id);
            $view->set_global('icon_filename', $icon['filename']);
        }

        $view->set_global('val', $val);
        $view->set_global('upload_error', $upload_error);

        $this->template->title = 'Staff &raquo; Edit';
        $this->template->content = $view;
    }

    /**
     * 確認画面
     */
    public function action_conf()
    {
        $view = \View::forge('staff/conf');

        $view->set('title', "Staff Conf");


        // 定義呼出
        Config::load('staff_master', true);
        $view->set('department_arr', Config::get('staff_master.department'));
        $view->set('gender_arr', Config::get('staff_master.gender'));

        $value_arr = Session::get('value_arr');
        foreach ($value_arr as $key => $val) {
           $view->set($key, $val);
        }
        Session::delete('value_arr');

        $this->template->title = 'Staff &raquo; Conf';
        $this->template->content = $view;
    }

    /**
     * DBに保存
     */
    public function post_insert()
    {
        if (Security::check_token()) {
            // postされたデータを取り出す
            $val = [
                'staff_no'        => Input::post('staff_no')
                , 'name'          => Input::post('name')
                , 'department'    => Input::post('department')
                , 'gender'        => Input::post('gender')
                , 'hire_date'     => Input::post('hire_date')
            ];

            // トランザクション
            try {
                DB::start_transaction();

                $staff_id = Model_Staff::staff_insert_query($val);
                Model_Staff::staff_icon_link($staff_id, Input::post('icon_id'));

                DB::commit_transaction();

                Response::redirect('staff');
            } catch (\Exception $e) {
                DB::rollback_transaction();

                throw $e;
            }
        }
    }

    /**
     * DB更新
     */
    public function post_update()
    {
        if (Security::check_token()) {

            $id = Session::get('id');
            Session::delete('id');

            $val = [
                'staff_no'        => Input::post('staff_no')
                , 'name'          => Input::post('name')
                , 'department'    => Input::post('department')
                , 'gender'        => Input::post('gender')
                , 'hire_date'     => Input::post('hire_date')
            ];

            // トランザクション
            try {
                DB::start_transaction();

                if (Input::post('icon_id')!="") {
                    Model_Staff::staff_icon_link($id, Input::post('icon_id'));
                }

                Model_Staff::staff_update_query($id, $val);

                DB::commit_transaction();

                Response::redirect('staff/detail/'.$id);
            } catch (\Exception $e) {
                DB::rollback_transaction();

                throw $e;
            }
        }
    }

    /**
     * 確認画面から戻る
     */
    public function post_back()
    {
        if (Input::method() == 'POST' && Security::check_token()) {

            // IDのセッションがあれば編集画面へ戻る、無ければ新規の方に戻る
            if ( Session::get('id') )
            {
                $id = Session::get('id');
                Session::delete('id');

                $url = 'edit/'.$id;
            }else{
                $url = 'add';
            }

            // セッション期限延期
            foreach ($this->staffs as $staff)
            {
                Session::keep_flash($staff);
            }

            // 戻るからEditページ等を
            Session::set_flash('action', 'back');

            //入力画面にリダイレクト
            Response::redirect('staff/'.$url);
        }
    }

    /**
     * DB削除
     */
    public function post_destory($id)
    {
        if (Input::method() == 'POST' && Security::check_token()) {
            // トランザクション
            try {
                DB::start_transaction();

                Model_Staff::staff_delete_query($id);

                DB::commit_transaction();

                Response::redirect('staff');

            } catch (\Exception $e) {
                DB::rollback_transaction();

                throw $e;

            }
        }
    }


    /**
     * DB削除
     */
    public function post_serach()
    {
        if (Input::method() == 'POST' && Security::check_token()) {
            // トランザクション
            try {
                DB::start_transaction();

                Model_Staff::staff_delete_query($id);

                DB::commit_transaction();

                Response::redirect('staff');

            } catch (\Exception $e) {
                DB::rollback_transaction();

                throw $e;

            }
        }
    }

}