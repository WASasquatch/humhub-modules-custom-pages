<?php
/**
* CustomStackSidebarWidget
*
*/
class CustomStackWidget extends HWidget {
    
    public $id;
    public $title;
    public $content;
    public $icon;
    public $visibility;
    public $notemplate;
    public $targets;

    public function __construct() {
        if (!isset($this->id)) {
            $this->id = '';
        }
        if (!isset($this->icon)) {
            $this->icon = '';
        }
        if (!isset($this->targets)) {
            $this->targets = false;
        }
        if (!isset($this->notemplate)) {
            $this->notemplate = 0;
        }
        return parent::__construct();
    }
    
    public function run() {
        if(Yii::app()->user->isGuest && $this->visibility == CustomPage::VISIBILITY_MEMBER) {
            continue;
        }
        if ($this->targets || isset(Yii::app()->request->getParam('sguid'))) {
            if (Yii::app()->request->getParam('sguid') != null && @in_array(Yii::app()->request->getParam('sguid'), $this->targets) || Yii::app()->request->getParam('sguid') == $this->targets) {
                if ((int)$this->notemplate == 1) {
                    $this->render('blankWidget', array(
                        'id' => $this->id,
                        'title' => $this->title,
                        'content' => $this->content,
                        'icon' => $this->icon,
                        'user' => Yii::app()->user,
                        'targets' => $this->targets,
                    ));
                } else {
                    $this->render('genericWidget', array(
                        'id' => $this->id,
                        'title' => $this->title,
                        'content' => $this->content,
                        'icon' => $this->icon,
                        'user' => Yii::app()->user,
                        'targets' => $this->targets
                    ));
                }
            }
        } else {
            if ((int)$this->notemplate == 1) {
                $this->render('blankWidget', array(
                    'id' => $this->id,
                    'title' => $this->title,
                    'content' => $this->content,
                    'icon' => $this->icon,
                    'user' => Yii::app()->user,
                ));
            } else {
                $this->render('genericWidget', array(
                    'id' => $this->id,
                    'title' => $this->title,
                    'content' => $this->content,
                    'icon' => $this->icon,
                    'user' => Yii::app()->user,
                ));
            }
        }
    }   
    
}
?>
