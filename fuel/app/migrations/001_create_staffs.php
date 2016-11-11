<?php

namespace Fuel\Migrations;

class Create_staffs
{
	public function up()
	{
		\DBUtil::create_table('staffs', array(
			'id' => array('type' => 'INTEGER'),
			'staff_no' => array('type' => 'INTEGER'),
			'name' => array('constraint' => 200, 'type' => 'VARCHAR'),
			'department' => array('type' => 'INTEGER'),
			'gender' => array('type' => 'SMALLINT'),
			'deleted_at' => array('type' => 'TIMESTAMP'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('staffs');
	}
}