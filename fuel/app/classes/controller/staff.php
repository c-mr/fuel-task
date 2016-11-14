<?php

class Controller_Staff extends Controller_Template
{

    private $staffs = ['staff_no', 'name', 'department', 'gender'];

    public function action_index()
    {
        $data["subnav"] = array('index'=> 'active' );
        $this->template->title = 'Staff &raquo; Index';

        // 定義呼出
        Config::load('staff_master', true);
        $data["department_arr"] = Config::get('staff_master.department');
        $data["gender_arr"] = Config::get('staff_master.gender');

        // ページネーション

        $total = DB::select(DB::expr('COUNT(*) as cnt'))->from('staffs')->execute()->as_array();
        // Debug::dump($total);

        $config = array(
            // 'pagination_url' => 'staff/index/',
            'total_items'    => $total[0]['cnt'],
            'uri_segment' => 'p',
            'num_links' => 4,
            'per_page' => 7,
            'name' => 'pagination',
            'show_first' => true,
            'show_last' => true,
        );
        $pagination = Pagination::forge('pagination', $config);

        $data['staffs'] = DB::select()
                        ->limit($pagination->per_page)
                        ->offset($pagination->offset)
                        ->from('staffs')
                        ->order_by('id', 'desc')
                        ->execute();

        $data['pagination'] = $pagination;

        // Debug::dump($pagination);
        $this->template->content = View::forge('staff/index', $data);
    }

    public function action_detail()
    {
        $data["subnav"] = array('detail'=> 'active' );
        $this->template->title = 'Staff &raquo; Detail';
        $this->template->content = View::forge('staff/detail', $data);
    }

    /**
     * 新規登録
     */
    public function action_add()
    {
        $data["subnav"] = array('add'=> 'active' );
        $this->template->title = 'Staff &raquo; Add';

        // タイトル
        $data["title"] = "Staff Add";

        // 入力チェック呼出
        $val = Model_Staff::validate('add');
        $data["val"] = $val;

        // POSTされた各データをフラッシュセッションに保存
        if (Input::method() == 'POST') {
            foreach ($this->staffs as $staff) {
                // セッションにフラッシュ変数をセット
                Session::set_flash($staff, Input::post($staff));
            }
            // Debug::dump($data);

            // 入力確認画面へ遷移
            if ($val->run() && Security::check_token()) {
                Response::redirect('staff/conf');
            }

        }

        // 定義呼出
        Config::load('staff_master', true);
        $data["department_arr"] = Config::get('staff_master.department');
        $data["gender_arr"] = Config::get('staff_master.gender');


        $this->template->content = View::forge('staff/add', $data);
    }

    /**
     * 確認画面
     */
    public function action_conf()
    {
        $this->template->title = 'Staff &raquo; Conf';

        $data["title"] = "Staff Conf";

        // 定義呼出
        Config::load('staff_master', true);
        $data["department_arr"] = Config::get('staff_master.department');
        $data["gender_arr"] = Config::get('staff_master.gender');


        foreach ($this->staffs as $staff) {
            // セッションからフラッシュ変数を取出
            $data[$staff] = Session::get_flash($staff);
            // セッション変数を次のリクエストを維持
            Session::keep_flash($staff);
        }
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

        $new->save();
        Response::redirect('staff/index');
    }

    public function action_edit()
    {
        $data["subnav"] = array('edit'=> 'active' );
        $this->template->title = 'Staff &raquo; Edit';
        $this->template->content = View::forge('staff/edit', $data);
    }

    public function action_update()
    {
        $data["subnav"] = array('update'=> 'active' );
        $this->template->title = 'Staff &raquo; Update';
        $this->template->content = View::forge('staff/update', $data);
    }

    public function action_destory()
    {
        $data["subnav"] = array('destory'=> 'active' );
        $this->template->title = 'Staff &raquo; Destory';
        $this->template->content = View::forge('staff/destory', $data);
    }

}
