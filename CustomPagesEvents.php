<?php

/**
 * HumHub
 * Copyright © 2014 The HumHub Project
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

/**
 * Description of CustomPagesEvents
 *
 * @author luke, Jordan Thompson (WASasquatch)
 */
class CustomPagesEvents
{

    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('CustomPagesModule.base', 'Custom Pages Extended'),
            'url' => Yii::app()->createUrl('//custom_pages/admin'),
            'group' => 'manage',
            'icon' => '<i class="fa fa-file-code-o"></i>',
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'custom_pages' && Yii::app()->controller->id == 'admin'),
            'sortOrder' => 300,
        ));

        // Check for Admin Menu Pages to insert
    }

    public static function onTopMenuInit($event)
    {
        foreach (CustomPage::model()->findAllByAttributes(array('navigation_class' => CustomPage::NAV_CLASS_TOPNAV)) as $page) {
            if ($page->type != CustomPage::TYPE_WIDGET) {
                // Admin only or not public page
                if (($page->admin_only == 1 && !Yii::app()->user->isAdmin()) || ($page->attributes['visibility'] == 0 && Yii::app()->user->isGuest)) {
                    continue;
                }
                
                $event->sender->addItem(array(
                    'label' => $page->title,
                    'url' => Yii::app()->createUrl('//custom_pages/view', array('id' => $page->id)),
                    'target' => ($page->type == CustomPage::TYPE_LINK) ? '_blank' : '',
                    'icon' => '<i class="fa ' . $page->icon . '"></i>',
                    'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'custom_pages' && Yii::app()->controller->id == 'view' && Yii::app()->request->getParam('id') == $page->id),
                    'sortOrder' => ($page->sort_order != '') ? $page->sort_order : 1000,
                ));
            } else {
                continue;
            }
        }
    }

    public static function onAccountMenuInit($event)
    {
        foreach (CustomPage::model()->findAllByAttributes(array('navigation_class' => CustomPage::NAV_CLASS_ACCOUNTNAV)) as $page) {
            if ($page->type != CustomPage::TYPE_WIDGET) {
                // Admin only or not public page
                if (($page->admin_only == 1 && !Yii::app()->user->isAdmin()) || ($page->attributes['visibility'] == 0 && Yii::app()->user->isGuest)) {
                    continue;
                }

                $event->sender->addItem(array(
                    'label' => $page->title,
                    'url' => Yii::app()->createUrl('//custom_pages/view', array('id' => $page->id)),
                    'target' => ($page->type == CustomPage::TYPE_LINK) ? '_blank' : '',
                    'icon' => '<i class="fa ' . $page->icon . '"></i>',
                    'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'custom_pages' && Yii::app()->controller->id == 'view' && Yii::app()->request->getParam('id') == $page->id),
                    'sortOrder' => ($page->sort_order != '') ? $page->sort_order : 1000,
                ));
            } else {
                continue;
            }
        }
    }
    
    /**
     * On build of the dashboard sidebar widget, add the custom widgets if module is enabled, and any are available.
     *
     * @param type $event            
     */
    public static function onDashboardSidebarInit($event)
    {
        if (Yii::app()->moduleManager->isEnabled('custom_pages')) {
            foreach (CustomPage::model()->findAllByAttributes(array('type' => CustomPage::TYPE_WIDGET, 'widget_class' => CustomPage::WIDGET_DASHBOARD)) as $page) {
                // Admin only or not public widget and double check type(?)
                if (($page->admin_only == 1 && !Yii::app()->user->isAdmin()) || ($page->attributes['visibility'] == 0 && Yii::app()->user->isGuest) && $page->type != CustomPage::TYPE_WIDGET) {
                    continue;
                }
                                
                $event->sender->addWidget('application.modules.custom_pages.widgets.CustomStackWidget', array(
                        'id' => $page->id, 
                        'title' => $page->title, 
                        'content' => $page->content, 
                        'icon' => $page->icon, 
                        'visibility' => $page->visibility,
                        'notemplate' => $page->widget_template
                    ), 
                    array(
                        'sortOrder' => ($page->sort_order != '') ? $page->sort_order : 1000
                    )
                );
            }
        }
    }
    
    /**
     * On build of the directory sidebar widget, add the custom widgets if module is enabled, and any are available.
     *
     * @param type $event            
     */
    public static function onDirectorySidebarInit($event)
    {
        if (Yii::app()->moduleManager->isEnabled('custom_pages')) {
            foreach (CustomPage::model()->findAllByAttributes(array('type' => CustomPage::TYPE_WIDGET, 'widget_class' => CustomPage::WIDGET_DIRECTORY)) as $page) {
                // Admin only or not public widget and double check type(?)
                if (($page->admin_only == 1 && !Yii::app()->user->isAdmin()) || ($page->attributes['visibility'] == 0 && Yii::app()->user->isGuest) && $page->type != CustomPage::TYPE_WIDGET) {
                    continue;
                }
                
                $event->sender->addWidget('application.modules.custom_pages.widgets.CustomStackWidget', array(
                        'id' => $page->id, 
                        'title' => $page->title, 
                        'content' => $page->content, 
                        'icon' => $page->icon, 
                        'visibility' => $page->visibility,
                        'notemplate' => $page->widget_template
                    ), 
                    array(
                        'sortOrder' => ($page->sort_order != '') ? $page->sort_order : 1000
                    )
                );
            }
        }
    }
    
    /**
     * On build of the space sidebar widget, add the custom widgets if module is enabled, and any are available.
     *
     * @param type $event            
     */
    public static function onSpaceSidebarInit($event)
    {
        if (Yii::app()->moduleManager->isEnabled('custom_pages')) {
            foreach (CustomPage::model()->findAllByAttributes(array('type' => CustomPage::TYPE_WIDGET, 'widget_class' => CustomPage::WIDGET_SPACE)) as $page) {
                // Admin only or not public widget and double check type(?)
                if (($page->admin_only == 1 && !Yii::app()->user->isAdmin()) || ($page->attributes['visibility'] == 0 && Yii::app()->user->isGuest) && $page->type != CustomPage::TYPE_WIDGET) {
                    continue;
                }
                $spaceTargets = ($page->widget_targets != '') ? ((count($page->widget_targets) > 0) ? $page->widget_targets : false) : false;
                $event->sender->addWidget('application.modules.custom_pages.widgets.CustomStackWidget', array(
                        'id' => $page->id, 
                        'title' => $page->title, 
                        'content' => $page->content, 
                        'icon' => $page->icon, 
                        'visibility' => $page->visibility,
                        'notemplate' => $page->widget_template,
                        'targets' => $spaceTargets
                    ), 
                    array(
                        'sortOrder' => ($page->sort_order != '') ? $page->sort_order : 1000
                    )
                );
            }
        }
    }

}
