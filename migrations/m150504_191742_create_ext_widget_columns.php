<?php

class m150504_191742_create_ext_widget_columns extends EDbMigration
{
	public function up()
	{
        $this->addColumn('custom_pages_page', 'widget_template', 'boolean DEFAULT 0');
        $this->addColumn('custom_pages_page', 'widget_targets', 'text');
	}

	public function down()
	{
		echo "m150504_191742_create_ext_widget_columns does not support migration down.\n";
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