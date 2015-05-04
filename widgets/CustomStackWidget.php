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

    public function run() {
        if(Yii::app()->user->isGuest && !$this->visibility) {
            return;
        }
        $this->render('showWidget', array(
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'icon' => $this->icon,
            'user' => Yii::app()->user
        ));
        
    }   
    
}
?>
