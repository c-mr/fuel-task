<?php

namespace Fuel\Migrations;

class Create_staffs
{
	public function up()
	{
		\DBUtil::create_table('staffs', array(
			'id' => array('type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'staff_no' => array('type' => 'int', 'null' => false, 'unsigned' => true),
			'name' => array('constraint' => 200, 'type' => 'VARCHAR', 'null' => false),
			'department' => array('type' => 'int', 'null' => false, 'unsigned' => true),
			'gender' => array('type' => 'smallint', 'null' => false, 'unsigned' => true),
			'deleted_at' => array('type' => 'timestamp', 'null' => true),
			'created_at' => array('type' => 'timestamp', 'null' => true),
			'updated_at' => array('type' => 'timestamp', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('staffs');
	}
}