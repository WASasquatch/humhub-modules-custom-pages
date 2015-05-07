<?php

/**
 * This is the model class for table "custom_pages_page".
 *
 * The followings are the available columns in table 'custom_pages_page':
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $icon
 * @property string $content
 * @property integer $sort_order
 * @property integer $admin_only
 * @property string $navigation_class
 */
class CustomPage extends HActiveRecord
{

    public $url;
    public $markdown;
    public $widget_class;
    public $widget_targets;
    public $widget_template;
    public $visiblity;
    public $link_type;

    // Navigations
    const NAV_CLASS_TOPNAV = 'TopMenuWidget';
    const NAV_CLASS_ACCOUNTNAV = 'AccountMenuWidget';
    // Widget Targets
    const WIDGET_DASHBOARD = 'DashboardSidebarWidget';
    const WIDGET_DIRECTORY = 'DirectorySidebarWidget';
    const WIDGET_SPACE = 'SpaceSidebarWidget';
    // Page Types
    const TYPE_LINK = '1';
    const TYPE_HTML = '2';
    const TYPE_IFRAME = '3';
    const TYPE_MARKDOWN = '4';
	const TYPE_PHP = '5';
    const TYPE_WIDGET = '6';
    // Page Visibility
    const VISIBILITY_GUEST = 0;
    const VISIBILITY_MEMBER = 1;
    const VISIBILITY_UNLISTED = 2;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CustomPage the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'custom_pages_page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, title, widget_class, navigation_class', 'required'),
            array('type, sort_order, admin_only, widget_template', 'numerical', 'integerOnly' => true),
            array('title, widget_class, navigation_class', 'length', 'max' => 255, 'message' => 'Title must be less then 255 characters'),
            array('visibility', 'numerical', 'integerOnly' => true, 'max' => 2),
            array('icon, link_type', 'length', 'max' => 100),
            array('widget_targets', 'widgetCheckSpaceGuid'),
            array('visibility', 'widgetCheckVisibility'),
            array('content, url, title', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('CustomPages.base', 'ID'),
            'type' => Yii::t('CustomPages.base', 'Type'),
            'title' => Yii::t('CustomPages.base', 'Title'),
            'icon' => Yii::t('CustomPages.base', 'Icon'),
            'content' => Yii::t('CustomPages.base', 'Content'),
            'url' => Yii::t('CustomPages.base', 'URL'),
            'link_type' => Yii::t('CustomPages.base', 'Link Type'),
            'sort_order' => Yii::t('CustomPages.base', 'Sort Order'),
            'admin_only' => Yii::t('CustomPages.base', 'Only visible for admins'),
			'visibility' => Yii::t('CustomPages.base', 'Visibility'),
            'navigation_class' => Yii::t('CustomPages.base', 'Navigation Target'),
            'widget_class' => Yii::t('CustomPages.base', 'Widget Type'),
            'widget_template' => Yii::t('CustomPages.base', 'No Template'),
            'widget_targets' => Yii::t('CustomPages.base', 'Space Targets (GUIDs separated by commas)')
        );
    }

    public function beforeSave()
    {
        if ($this->type == self::TYPE_IFRAME || $this->type == self::TYPE_LINK) {
            $this->content = $this->url;
        }
        if ($this->type == self::TYPE_MARKDOWN) {
            $this->content = $this->markdown;
        }
        if ($this->type == self::TYPE_WIDGET) {
            $this->navigation_class = 'null';
        } else {
            $this->widget_class = 'null';
        }
        if ($this->widget_targets != '') {
            $this->widget_targets = (stristr($this->widget_targets, ',')) ? json_encode(explode(',', trim($this->widget_targets))) : json_encode(array($this->widget_targets));
        }
        
        return parent::beforeSave();
    }

    public function afterFind()
    {
        if ($this->type == self::TYPE_IFRAME || $this->type == self::TYPE_LINK) {
            $this->url = $this->content;
        }
        if ($this->type == self::TYPE_MARKDOWN) {
            $this->markdown = $this->content;
        }
        if ($this->widget_targets != '') {
            $this->widget_targets = (count(json_decode($this->widget_targets)) > 0) ? implode(', ', json_decode($this->widget_targets)) : json_decode($this->widget_targets);
            if (is_array($this->widget_targets)) {
                $targets = $this->widget_targets;
                $this->widget_targets = '';
                foreach($targets as $widget) {
                    $this->widget_targets .= $widget;
                }
            }
        }
        
        
        return parent::afterFind();
    }

    public static function getNavigationClasses()
    {
        return array(
            self::NAV_CLASS_TOPNAV => Yii::t('CustomPagesModule.base', 'Top Navigation'),
            self::NAV_CLASS_ACCOUNTNAV => Yii::t('CustomPagesModule.base', 'User Account Menu (Settings)'),
        );
    }
    
    public static function getWidgetClasses()
    {
        return array(
            self::WIDGET_DASHBOARD => Yii::t('CustomPagesModule.base', 'Dashboard (Sidebar Widget)'),
            self::WIDGET_DIRECTORY => Yii::t('CustomPagesModule.base', 'Directory (Sidebar Widget)'),
            self::WIDGET_SPACE => Yii::t('CustomPagesModule.base', 'Space (Sidebar Widget)')
        );
    }

    public static function getPageTypes()
    {
        return array(
            self::TYPE_LINK => Yii::t('CustomPagesModule.base', 'Link'),
            self::TYPE_HTML => Yii::t('CustomPagesModule.base', 'HTML'),
            self::TYPE_MARKDOWN => Yii::t('CustomPagesModule.base', 'MarkDown'),
            self::TYPE_IFRAME => Yii::t('CustomPagesModule.base', 'IFrame'),
            self::TYPE_PHP => Yii::t('CustomPagesModule.base', 'PHP'),
            self::TYPE_WIDGET => Yii::t('CustomPagesModule.base', 'Widget'),
        );
    }
    
    public static function getVisiblityTypes()
    {
        return array(
            self::VISIBILITY_GUEST => Yii::t('CustomPagesModule.base', 'Guest (Everyone)'),
            self::VISIBILITY_MEMBER => Yii::t('CustomPagesModule.base', 'Members (Members only)'),
            self::VISIBILITY_UNLISTED => Yii::t('CustomPagesModule.base', 'Unlisted (No menu links)'),
        );
    }

    public static function getLinkTypes()
    {
        return array(
            '_blank' => Yii::t('CustomPagesModule.base', '_blank'),
            '_self' => Yii::t('CustomPagesModule.base', '_self'),
        );
    }
    
    /**
     * This validator function checks the widget_targets.
     *
     * @param type $attribute
     * @param type $params
     */
    public function widgetCheckSpaceGuid($attribute, $params)
    {
        if ($this->widget_targets != '') {
            $explodeBy = (stristr($this->widget_targets, ', ')) ? ', ' : ',';
            foreach (explode($explodeBy, trim($this->widget_targets)) as $spaceGuid) {
                if ($spaceGuid != '') {
                    $space = Space::model()->findByAttributes(array('guid' => $spaceGuid));
                    if ($space == null) {
                        $this->addError($attribute, Yii::t('CustomPagesModule.base', "There is a invalid space in your targets. Please ensure they point to existing spaces."));
                    }
                }
            }
        }
    }
    
    public function widgetCheckVisibility($attribute, $params) {
        if ($this->type == '6') {
            if ($this->visiblity == 2) {
                $this->addError($attribute, Yii::t('CustomPagesModule.base', "Widget cannot use unlisted type."));               
            }
        }
    }


}
