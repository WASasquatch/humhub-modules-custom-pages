<?php

class m150506_233355_create_link_type_column extends EDbMigration
{
	public function up()
	{
		$this->addColumn('custom_pages_page', 'link_type', 'varchar(5) DEFAUL null');
	}

	public function down()
	{
		echo "m150506_233355_create_link_type_column does not support migration down.\n";
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
