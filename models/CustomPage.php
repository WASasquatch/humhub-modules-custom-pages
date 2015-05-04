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
            array('type, sort_order, admin_only, visibility', 'numerical', 'integerOnly' => true),
            array('title, widget_class, navigation_class', 'length', 'max' => 255),
            array('icon', 'length', 'max' => 100),
            array('content, url', 'safe'),
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
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'icon' => 'Icon',
            'content' => 'Content',
            'url' => 'URL',
            'sort_order' => 'Sort Order',
            'admin_only' => 'Only visible for admins',
			'visibility' => 'Public to guests',
            'navigation_class' => 'Navigation',
            'widget_class' => 'Widget Type',
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

}
