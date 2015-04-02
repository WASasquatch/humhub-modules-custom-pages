# Inline-Module Example

## HStats
### Display HumHub Statistics

This example shows how you can create a class and utilize it to create inline-modules. This example outputs basic HumHub Statistics.

<img src="http://i.imgur.com/hKwjATO.png" ?>

```php
/* *
 * Inline Module Example HStats 
 * @author Jordan Thompson
 *
 * You can extend Yii/HumHub classes or create your own.
 * Here we are creating our own class called HStats for statistics.
 * */
class HStats
{

    /**
     * Return a count or list or members by type or total
     * 
     * @return int | object
     */
    public function memberStats($act = 'total', $list = false, $limit = 10)
    {
        switch($act) {
            case 'online':
                $criteria = new CDbCriteria;
                $criteria->group = 'user_id';
                $criteria->condition = 'user_id IS NOT null';
                $count = UserHttpSession::model()->count($criteria);
                if ($list && $count > 0) {
                    $onlineUsers = UserHttpSession::model()->findAll($criteria);
                    return array($count, $onlineUsers);
                }
                return $count;
            break;
            case 'total':
                return User::model()->count();
            break;
            case 'new':
                return User::model()->active()->recently($limit)->findAll();
            break;
        }
    }

    /**
     * Return a count of new spaces, and optionally a list
     * 
     * @return int | object
     */
    public function newSpaces($list = false, $limit = 10)
    {
        $criteria = new CDbCriteria();
        $criteria->join = 'LEFT JOIN space_membership ON t.id=space_membership.space_id AND space_membership.user_id=:userId';
        $criteria->condition = 't.visibility != :visibilityNone OR space_membership.status = :statusMember';
        $criteria->params = array(
            ':userId' => Yii::app()->user->id,
            ':visibilityNone' => Space::VISIBILITY_NONE,
            ':statusMember' => SpaceMembership::STATUS_MEMBER);
        $newSpaces = Space::model()->active()->recently($limit)->findAll($criteria);
        $count = Space::model()->active()->recently($limit)->count($criteria);
        if ($list && count($newSpaces) > 0) {
            return array($count, $newSpaces);
        }
        return $count;
    }

    /**
     * Return space count statistics by type or all
     * 
     * @return int
     */
    public function spaceStats($act = 'public', $limit = 3)
    {
        $va = array('public','hidden','popular','total');
        if (in_array($act, $va)) {
            switch($act) {    
                case 'public':
                    return Space::model()->count();
                break;
                case 'hidden':
                    return Space::model()->countByAttributes(array('visibility' => Space::VISIBILITY_NONE));
                break;
                case 'popular':
                    return Space::model()->find('id = (SELECT space_id  FROM space_membership GROUP BY space_id ORDER BY count(*) DESC LIMIT ' . $limit . ')');
                break;
                case 'total':
                    return (Space::model()->count() + Space::model()->countByAttributes(array('visibility' => Space::VISIBILITY_NONE)));   
                break;
            }
        }
        return false;
    }

    /**
     * Return group count statistics by type or all
     * 
     * @return int
     */
    public function groupStats($act = 'total', $limit = 3)
    {
        $va = array('total','popular');
        if (in_array($act, $va)) {
            switch($act) {    
                case 'total':
                    return Group::model()->count();
                break;
                case 'popular':
                    return Group::model()->find('id = (SELECT group_id  FROM user GROUP BY group_id ORDER BY count(*) DESC LIMIT '  . $limit . ')');
                break;
            }
        }
        return false;
    }

    /**
     * Return a user based on id
     * 
     * @return object
     */
    public static function loadUser($id) 
    {
        return User::model()->findByPk($id);
    }


    /**
     * Checks if the user is a administrator
     * 
     * @return boolean
     */
    public static function is_admin($id)
    {
        /* Do we have a valid user? */
        if ($u = self::loadUser($id)->attributes) {
            /* Is this user a admin? */
            if ($u['super_admin'] == 1) 
            {
                return true;
            }
            return false;
        }
    }

}

/* Initiate our Inline-Module Class */
$stats = new HStats();

/* Render Statistics */
$totalMembers = $stats->memberStats('total');
$online = $stats->memberStats('online', true);
/* Get latest member, limit 1 */
$newMember = $stats->memberStats('new', false, 1)[0];
$totalGroups = $stats->groupStats('total');
$topGroup = $stats->groupStats('popular', 1);
$totalSpacesPublic = $stats->spaceStats('public');
$totalSpacesPrivate = $stats->spaceStats('hidden');
$spacePopular = $stats->spaceStats('popular', 1);
$totalSpaces = $stats->spaceStats('total');

/* Online suffix */
$suffix = ($online[0] == 1) ? '' : 's';

echo '<div class="panel default">
            <div class="panel-heading"><strong>' . Yii::app()->name . '</strong> Stats</div>
            <div class="panel-body">
                We have a total of <strong>' . number_format($totalMembers) . '</strong> members. Our newest member is 
                <a href="' . $newMember->getProfileUrl() . '" target="_blank" style="font-weight:bold;">' . $newMember->displayName . '</a>. <br />
                There are  a total of <strong>' . number_format($totalGroups) . '</strong> groups, with the most popular group 
                <strong>' . $topGroup->name . '</strong>.<br />There are a total of <strong>' . $totalSpaces . '</strong> spaces: ' . $totalSpacesPublic . ' 
                public, and ' . $totalSpacesPrivate . ' private.<br />The most popular space is 
                <a href="' . $spacePopular->getUrl() . '" target="_blank"><strong>' . $spacePopular->name . '</strong></a>
            </div>
            <div class="panel-heading"><strong>Currently</strong> Online</div>
            <div class="panel-body">
                <p>We currently have <strong>' . number_format($online[0]) . '</strong> member' . $suffix . ' online.</p>
                <p>';

/* Display online users */
foreach ($online[1] as $u) {
    $u = $stats->loadUser($u->user_id);
    $name = $u->displayName;
    if ($stats->is_admin($u->id)) {
        echo '<a href="' . $member->getProfileUrl(); . '"> 
                    <img src="' . $u->getProfileImage()->getUrl() . '" class="media-object tt space-widget-member-image img-rounded pull-left" 
                    style="width: 40px; height: 40px; border: 2px solid #FF8989; margin-right: 4px;" alt="40x40" data-src="holder.js/40x40" data-toggle="tooltip" data-placement="top" title="" 
                    data-original-title="<strong>' . $u->displayName . '</strong><br />' . $u->profile->title . '" />';
    } else {
        echo '<a href="' . $member->getProfileUrl(); , '"> 
                    <img src="' . $u->getProfileImage()->getUrl() . '" class="media-object tt space-widget-member-image img-rounded pull-left" 
                    style="width: 40px; height: 40px; border: 2px solid #EDEDED; margin-right: 4px;" alt="40x40" data-src="holder.js/40x40" data-toggle="tooltip" data-placement="top" title="" 
                    data-original-title="<strong>' . $u->displayName . '</strong><br />' . $u->profile->title . '" />';
    }
}
echo '</p></div></div>';
```
