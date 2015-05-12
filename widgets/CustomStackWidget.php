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
    public $space;

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
        if (Yii::app()->request->getParam('sguid') != '' && ($this->space = Space::model()->findByPk(Yii::app()->request->getParam('sguid'))) != null) {
            if (!isset($this->space->id)) {
                $this->space = false;
            }
        }
        return parent::__construct();
    }
    
    public function run() {
        if(Yii::app()->user->isGuest && $this->visibility == CustomPage::VISIBILITY_MEMBER) {
            continue;
        }
        if ($this->targets && $this->space) {
            if (@in_array($this->space->guid, $this->targets) || $this->space->guid == $this->targets) {
                if ((int)$this->notemplate == 1) {
                    $this->render('blankWidget', array(
                        'id' => $this->id,
                        'title' => $this->title,
                        'content' => $this->content,
                        'icon' => $this->icon,
                        'user' => Yii::app()->user,
                        'targets' => $this->targets,
                        'space' => $this->space,
                    ));
                } else {
                    $this->render('genericWidget', array(
                        'id' => $this->id,
                        'title' => $this->title,
                        'content' => $this->content,
                        'icon' => $this->icon,
                        'user' => Yii::app()->user,
                        'targets' => $this->targets,
                        'space' => $this->space,
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
                    'space' => $this->space,
                ));
            } else {
                $this->render('genericWidget', array(
                    'id' => $this->id,
                    'title' => $this->title,
                    'content' => $this->content,
                    'icon' => $this->icon,
                    'user' => Yii::app()->user,
                    'space' => $this->space,
                ));
            }
        }
    }   
    
}
?>
