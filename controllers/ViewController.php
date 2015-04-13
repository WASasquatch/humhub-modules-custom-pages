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
 * Description of ViewController
 *
 * @author luke, jordan
 */
class ViewController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // due to the nature of this module, all members should be allowed and sorted within
                'users' => array('*'),
            ),
		);
    }

    public function actionIndex()
    {

        $page = CustomPage::model()->findByPk(Yii::app()->request->getParam('id'));
		$user = Yii::app()->user;

        if ($page === null) {
            throw new CHttpException('404', 'Could not find requested page');
        }

        if  ($page->admin_only == 1 && !Yii::app()->user->isAdmin()) {
            throw new CHttpException(403, 'Access denied!');
        }
		
        if ($page->attributes['visibility'] == 0 && Yii::app()->user->isGuest) {
              throw new CHttpException(403, 'Registered members only!');
        }

        if ($page->navigation_class == CustomPage::NAV_CLASS_ACCOUNTNAV) {
            $this->subLayout = "application.modules_core.user.views.account._layout";
        }
        
        if ($page->type == CustomPage::TYPE_HTML) {
            $this->render('html', array('html' => $page->content));
        } elseif ($page->type == CustomPage::TYPE_IFRAME) {
            $this->render('iframe', array('url' => $page->content, 'navigationClass' => $page->navigation_class));
        } elseif ($page->type == CustomPage::TYPE_PHP) {
            $this->render('php', array('php' => $page->content, 'user' => $user));
        } elseif ($page->type == CustomPage::TYPE_LINK) {
            $this->redirect($page->content);
        } elseif ($page->type == CustomPage::TYPE_MARKDOWN) {
            $this->render('markdown', array('md' => $page->content, 'navigationClass' => $page->navigation_class));
        } else {
            throw new CHttpException(500, 'Invalid page type!');
        }
    }

}
