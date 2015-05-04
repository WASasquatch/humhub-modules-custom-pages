<?php

class m150503_040710_create_widget_class_column extends EDbMigration
{
	public function up()
	{
        $this->addColumn('custom_pages_page', 'widget_class', 'string');
	}

	public function down()
	{
		echo "m150503_040710_create_widget_type does not support migration down.\n";
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