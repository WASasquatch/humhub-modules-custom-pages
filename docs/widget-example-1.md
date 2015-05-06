
Here is a simple example widget that displays a welcome back message every 24 hours for the Dashboard.

This page is setup as follow 
- Type => Widget
- Widget Type => Dashboard (Sidebar Widget)
- No Template => Checked

```php
/*  Has this message been displayed? Lets check our cookie */
if (!(isset(Yii::app()->request->cookies['welcome_dashboard'])) || (int)Yii::app()->request->cookies['welcome_dashboard']->value != 1) {

    /* Set Cookie */
    Yii::app()->request->cookies['welcome_dashboard'] = new CHttpCookie('welcome_dashboard', 1, array(
        'expire' => time()+43200, 
        'path' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    ));

    /* Write some content to for the widget
     * Remember we're in PHP! 
     */
    $content = 'echo "Welcome back <strong>" . $user->displayName . "</strong>!";';

    /* Render the widget with the generic template,. 
     * Note remember we have No Template checked 
     */
    $this->render('genericWidget', array(
        'icon' => $icon, 
        'title' => $title, 
        'content' => $content, 
        'user' => $user
    ));

}
```
