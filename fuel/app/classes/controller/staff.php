<?php

class Controller_Staff extends Controller_Template
{

    private $staffs = ['staff_no', 'name', 'department', 'gender'];

    /**
     * INDEX画面(一覧)
     */
    public function action_index()
    {
        $data["subnav"] = array('index'=> 'active' );
        $this->template->title = 'Staff &raquo; Index';

        // 定義呼出
        Config::load('staff_master', true);
        $data["department_arr"] = Config::get('staff_master.department');
        $data["gender_arr"] = Config::get('staff_master.gender');

        // ページネーション
        $result = DB::select('*')
                ->from('staffs')
                ->execute();
        $total = count($result);
        // Debug::dump($total);

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
        $data["subnav"] = array('detail'=> 'active' );
        $this->template->title = 'Staff &raquo; Detail';

        $data["title"] = "Staff Detail";

        // 定義呼出
        Config::load('staff_master', true);
        $data["department_arr"] = Config::get('staff_master.department');
        $data["gender_arr"] = Config::get('staff_master.gender');

        $data['staff'] = DB::select()
                        ->where('id', $id)
                        ->from('staffs')
                        ->execute()
                        ->current();

        // Debug::dump($data);

        $this->template->content = View::forge('staff/detail', $data);
    }

    public function action_edit($id = null)
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
