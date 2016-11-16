<?php

class Controller_Staff extends Controller_Template
{

    private $staffs = ['staff_no', 'name', 'department', 'gender'];

    /**
     * INDEX画面(一覧)
     */
    public function action_index()
    {
        $data['subnav'] = array('index'=> 'active' );
        $this->template->title = 'Staff &raquo; Index';

        // 定義呼出
        Config::load('staff_master', true);
        $data['department_arr'] = Config::get('staff_master.department');
        $data['gender_arr'] = Config::get('staff_master.gender');


        $pagination = Model_Staff::staff_list_pagination();
        $data['pagination'] = $pagination;

        $data['staffs'] = Model_Staff::staff_list_query($pagination->per_page, $pagination->offset);

        $this->template->content = View::forge('staff/index', $data);
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
        $data['act'] = "insert";

        // 入力チェック呼出
        $val = Model_Staff::validate('add');
        $data['val'] = $val;

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

        // 定義呼出
        Config::load('staff_master', true);
        $data['department_arr'] = Config::get('staff_master.department');
        $data['gender_arr'] = Config::get('staff_master.gender');


        $this->template->content = View::forge('staff/_form', $data);
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

        $new = Model_Staff::forge(
            [
                'staff_no'      => Input::post('staff_no'),
                'name'          => Input::post('name'),
                'department'    => Input::post('department'),
                'gender'        => Input::post('gender')
            ]
        );

        // トランザクション
        try {
            DB::start_transaction();

            $new->save();

            DB::commit_transaction();

            Response::redirect('staff');
        } catch (\Exception $e) {
            DB::rollback_transaction();

            throw $e;
        }

    }

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

    public function action_edit($id = null)
    {
        $data['subnav'] = array('edit'=> 'active' );
        $data['title'] = "Staff Edit";
        $data['act'] = "update";

        // 定義呼出
        Config::load('staff_master', true);
        $data['department_arr'] = Config::get('staff_master.department');
        $data['gender_arr'] = Config::get('staff_master.gender');

        $data['staff'] = Model_Staff::staff_detail_query($id);

        // 入力チェック呼出
        $val = Model_Staff::validate('add', $id);
        $data['val'] = $val;


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

        $this->template->title = 'Staff &raquo; Edit';
        $this->template->content = View::forge('staff/_form', $data);
    }

    public function action_update($id = null)
    {
        $data["subnav"] = array('update'=> 'active' );
        $this->template->title = 'Staff &raquo; Update';
        $this->template->content = View::forge('staff/update', $data);
    }

    public function action_destory()
    {
        $data['subnav'] = array('destory'=> 'active' );
        $this->template->title = 'Staff &raquo; Destory';
        $this->template->content = View::forge('staff/destory', $data);
    }

}
