<?php

class m150413_030602_create_visibility_column extends EDbMigration
{
	public function up()
	{
		$this->createColumn('custom_pages_page', 'visibility', 'int(1)');
	}

	public function down()
	{
		echo "m150413_030602_create_visibility_column does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
