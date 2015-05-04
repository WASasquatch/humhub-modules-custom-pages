    $(document).ready(function(){
        var t = $("#page_type").val();
        var telm = $("#page_type");
        $("#widget_class").hide();
        if (t == '1' || t == '3') {
            $("#content_field").hide();
            $("#url_field").show();
            $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Page Title'); ?>');
            $("#conPrefix").hide();
            $("#conSuffix").hide();
            $("#widget_class").hide();
            $("#navigation_class").show();
        } else  if (t == '2' || t == '4') {
            $("#navigation_class").show();
            $("#widget_class").hide();
            $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Page Title'); ?>');
            $("#content_field").show();
            $("#url_field").hide();
            $("#conPrefix").hide();
            $("#conSuffix").hide();   
        } else  if (t == '5') {
            $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Page Title'); ?>');
            $("#content_field").show();
            $("#url_field").hide();
            $("#navigation_class").show();
            $("#widget_class").hide();
            $("#conPrefix").show();
            $("#conSuffix").show();
        } else if (t == '6') {
            $("#widget_class").show();
            $("#content_field").show();
            $("#url_field").hide();
            $("#navigation_class").hide();
            $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Widget Name'); ?>');
            $("#conPrefix").show();
            $("#conSuffix").show();
        }
        if (t == '4') {
            $("#content_field").hide();
            $("#markdown_field").show();
        } else {
            $("#markdown_field").hide();
        }

        telm.on('change', function() {
            var t = $("#page_type").val();
            if (t == '1' || t == '3') {
                $("#content_field").hide();
                $("#url_field").show();
                $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Page Title'); ?>');
                $("#conPrefix").hide();
                $("#conSuffix").hide();
                $("#widget_class").hide(); 
                $("#navigation_class").show();
            } else if (t == '2' || t == '4') {
                $("#navigation_class").show();
                $("#widget_class").hide();
                $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Page Title'); ?>');
                $("#content_field").show();
                $("#url_field").hide();
                $("#conPrefix").hide();
                $("#conSuffix").hide();   
            } else if (t == '5') {
                $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Page Title'); ?>');
                $("#content_field").show();
                $("#url_field").hide();
                $("#navigation_class").show();
                $("#widget_class").hide();
                $("#conPrefix").show();
                $("#conSuffix").show();
            } else if (t == '6') {
                $("#widget_class").show();
                $("#content_field").show();
                $("#url_field").hide();
                $("#navigation_class").hide();
                $("#item_title").attr('placeholder', '<?php echo Yii::t('CustomPages.views_admin_edit', 'Widget Name'); ?>');
                $("#conPrefix").show();
                $("#conSuffix").show();
            }
            if (t == '4') {
                $("#content_field").hide();
                $("#markdown_field").show();
            } else {
                $("#markdown_field").hide();
            }
        });
    });
