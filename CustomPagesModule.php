<?php

class CustomPagesModule extends HWebModule
{

    public $subLayout = "application.modules_core.admin.views._layout";

    public function getConfigUrl() {
        return Yii::app()->createUrl('//custom_pages/admin');
    }

    public function disable()
    {
        return parent::disable();
    }
    
    public function uninstall() {
        foreach (CustomPage::model()->findAll() as $entry) {
            $entry->delete();
        }
        Yii::app()->db->createCommand()->dropTable(CustomPage::model()->tableName());
        return parent::uninstall();
    }

}
