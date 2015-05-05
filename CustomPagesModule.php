<?php

class CustomPagesModule extends HWebModule
{

    public $subLayout = "application.modules_core.admin.views._layout";

    public function getConfigUrl() {
        return Yii::app()->createUrl('//custom_pages/admin');
    }

    public function disable()
    {
        if (parent::disable()) {
            return true;
        }

        return false;
    }
    
    public function uninstall() {
        return parent::uninstall();
    }

}
