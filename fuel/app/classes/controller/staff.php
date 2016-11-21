<?php

class Controller_Staff extends Controller_Hybrid
{

    private $staffs = ['staff_no', 'name', 'department', 'gender'];

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

        // ページネーション呼出
        $pagination = Model_Staff::staff_list_pagination();
        $view->set('pagination', $pagination);
        $view->set('staffs', Model_Staff::staff_list_query($pagination->per_page, $pagination->offset));

        $this->template->title = 'Staff &raquo; Index';
        $this->template->content = $view;
    }

    /**
     * 新規登録
     */
    public function action_add()
    {
        // 共通化した部分(_form.php)に送るものはglobal

        $view = \View::forge('staff/add');

        $view->set_global('title', "Staff Add");

        // 定義呼出
        Config::load('staff_master', true);
        $view->set_global('department_arr', Config::get('staff_master.department'));
        $view->set_global('gender_arr', Config::get('staff_master.gender'));

        // 入力チェック呼出
        $val = Model_Staff::validate('add');
        $view->set_global('val', $val);

        // POSTされた各データをフラッシュセッションに保存
        if (Input::method() == 'POST') {

            // セッションにフラッシュ変数をセット
            foreach ($this->staffs as $staff) {
                Session::set_flash($staff, Input::post($staff));
            }

            // confは新規と変更、共用なのでどちらかの判別fromのactionに渡す
            Session::set_flash('action', 'insert');

            // 入力確認画面へ遷移
            if ($val->run() && Security::check_token()) {
                Response::redirect('staff/conf');
            }

        }

        $this->template->title = 'Staff &raquo; Add';
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

        foreach ($this->staffs as $staff) {
            // セッションからフラッシュ変数を取出
           $view->set($staff, Session::get_flash($staff));
            // セッション変数を次のリクエストを維持
            Session::keep_flash($staff);
        }

        $view->set('action', Session::get_flash('action'));

        $this->template->title = 'Staff &raquo; Conf';
        $this->template->content = $view;
    }

    /**
     * DBに保存
     */
    public function action_insert()
    {
        if (Security::check_token()) {
            // postされたデータを取り出す
            $val = [
                'staff_no'        => Input::post('staff_no')
                , 'name'          => Input::post('name')
                , 'department'    => Input::post('department')
                , 'gender'        => Input::post('gender')
            ];

            // トランザクション
            try {
                DB::start_transaction();

                Model_Staff::staff_insert_query($val);

                DB::commit_transaction();

                Response::redirect('staff');
            } catch (\Exception $e) {
                DB::rollback_transaction();

                throw $e;
            }
        }
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

        // 定義呼出
        Config::load('staff_master', true);
        $view->set_global('department_arr', Config::get('staff_master.department'));
        $view->set_global('gender_arr', Config::get('staff_master.gender'));


        $view->set_global('staff', Model_Staff::staff_detail_query($id));

        // 入力チェック呼出
        $val = Model_Staff::validate('edit', $id);
        $view->set_global('val', $val);


        // POSTされた各データをフラッシュセッションに保存
        if (Input::method() == 'POST') {

            // セッションにフラッシュ変数をセット
            foreach ($this->staffs as $staff) {
                Session::set_flash($staff, Input::post($staff));
            }

            // confは新規と変更、共用なのでどちらかの判別fromのactionに渡す
            Session::set_flash('action', 'update');

            Session::set('id', $id);

            // 入力確認画面へ遷移
            if ($val->run() && Security::check_token()) {
                Response::redirect('staff/conf');
            }

        }

        $this->template->title = 'Staff &raquo; Edit';
        $this->template->content = $view;
    }

    /**
     * DB更新
     */
    public function action_update()
    {
        if (Security::check_token()) {
            $val = [
                'staff_no'        => Input::post('staff_no')
                , 'name'          => Input::post('name')
                , 'department'    => Input::post('department')
                , 'gender'        => Input::post('gender')
            ];


            $id = Session::get('id');
            Session::delete('id');

            // トランザクション
            try {
                DB::start_transaction();

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
     * DB削除
     */
    public function post_destory()
    {
        $id = Input::post('id');
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
