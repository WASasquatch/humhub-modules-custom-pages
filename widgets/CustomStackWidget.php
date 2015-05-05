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

    public function run() {
        if(Yii::app()->user->isGuest && !$this->visibility) {
            return;
        }
        if ($this->targets) {
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
