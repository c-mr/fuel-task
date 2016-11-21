<?php

class Controller_Staff extends Controller_Template
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
        $data['subnav'] = array('add'=> 'active' );
        $this->template->title = 'Staff &raquo; Add';

        // タイトル
        $data['title'] = "Staff Add";

        // _form.php(共通化した部分)に送る
        $view = \View::forge('staff/_form');
        // 定義呼出
        Config::load('staff_master', true);
        $view->set_global('department_arr', Config::get('staff_master.department'));
        $view->set_global('gender_arr', Config::get('staff_master.gender'));
        // 入力チェック呼出
        $val = Model_Staff::validate('add');
        $view->set_global('val', $val);

        // POSTされた各データをフラッシュセッションに保存
        if (Input::method() == 'POST') {
            foreach ($this->staffs as $staff) {
                // セッションにフラッシュ変数をセット
                Session::set_flash($staff, Input::post($staff));
            }

            // confに渡す際に新規か変更かどっちのアクションか渡す
            Session::set_flash('act', Input::post('act'));

            // 入力確認画面へ遷移
            if ($val->run() && Security::check_token()) {
                Response::redirect('staff/conf');
            }

        }

        $this->template->content = View::forge('staff/add', $data);
    }

    /**
     * 確認画面
     */
    public function action_conf()
    {
        $this->template->title = 'Staff &raquo; Conf';

        $data['title'] = "Staff Conf";

        // 定義呼出
        Config::load('staff_master', true);
        $data['department_arr'] = Config::get('staff_master.department');
        $data['gender_arr'] = Config::get('staff_master.gender');

        foreach ($this->staffs as $staff) {
            // セッションからフラッシュ変数を取出
            $data[$staff] = Session::get_flash($staff);
            // セッション変数を次のリクエストを維持
            Session::keep_flash($staff);
        }

        $data['act'] = Session::get_flash('act');

        $this->template->content = View::forge('staff/conf', $data);
    }

    /**
     * DBに保存
     */
    public function action_insert()
    {
        $val = [
                'staff_no'      => Input::post('staff_no'),
                'name'          => Input::post('name'),
                'department'    => Input::post('department'),
                'gender'        => Input::post('gender')
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

    /**
     * 詳細画面
     * @param  int $id
     */
    public function action_detail($id = null)
    {
        $data['subnav'] = array('detail'=> 'active' );
        $this->template->title = 'Staff &raquo; Detail';

        $data['title'] = "Staff Detail";

        // 定義呼出
        Config::load('staff_master', true);
        $data['department_arr'] = Config::get('staff_master.department');
        $data['gender_arr'] = Config::get('staff_master.gender');

        $data['staff'] = Model_Staff::staff_detail_query($id);

        $this->template->content = View::forge('staff/detail', $data);
    }

    /**
     * 編集画面
     * @param  [int] $id
     */
    public function action_edit($id = null)
    {
        $data['subnav'] = array('edit'=> 'active' );
        $data['title'] = "Staff Edit";

        // _form.php(共通化した部分)に送る
        $view = \View::forge('staff/_form');
        // 定義呼出
        Config::load('staff_master', true);
        $view->set_global('department_arr', Config::get('staff_master.department'));
        $view->set_global('gender_arr', Config::get('staff_master.gender'));

        $view->set_global('staff', Model_Staff::staff_detail_query($id));

        // 入力チェック呼出
        $val = Model_Staff::validate('add', $id);
        $view->set_global('val', $val);

        // POSTされた各データをフラッシュセッションに保存
        if (Input::method() == 'POST') {
            foreach ($this->staffs as $staff) {
                // セッションフラッシュに変数をセット
                Session::set_flash($staff, Input::post($staff));
                // セッション変数を次のリクエストを維持
                Session::keep_flash($staff);
            }

            // confに渡す際に新規か変更かどっちのアクションか渡す
            Session::set_flash('act', Input::post('act'));

            Session::set('id', $id);

            // 入力確認画面へ遷移
            if ($val->run() && Security::check_token()) {
                Response::redirect('staff/conf');
            }

        }

        $this->template->title = 'Staff &raquo; Edit';
        $this->template->content = View::forge('staff/edit', $data);
    }

    public function action_update()
    {
        $val = [
                'staff_no'      => Input::post('staff_no'),
                'name'          => Input::post('name'),
                'department'    => Input::post('department'),
                'gender'        => Input::post('gender')
            ];


            $id = Session::get('id');
            Session::delete('id');

        // トランザクション
        try {
            DB::start_transaction();

            Model_Staff::staff_update_query($id, $val);

            DB::commit_transaction();

            Response::redirect('staff');
        } catch (\Exception $e) {
            DB::rollback_transaction();

            throw $e;
        }
    }

    public function action_destory()
    {
        $data['subnav'] = array('destory'=> 'active' );
        $this->template->title = 'Staff &raquo; Destory';
        $this->template->content = View::forge('staff/destory', $data);
    }

}
