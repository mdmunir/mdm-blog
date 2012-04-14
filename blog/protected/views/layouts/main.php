<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mytheme.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="SHORTCUT ICON" href="<?php echo Yii::app()->request->baseUrl; ?>/images/mu2.ico" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div class="root-nav">
            <?php
            $this->widget('UserMenu', array(
                'encodeLabel' => FALSE,
            ));
            ?>

        </div><!-- mainmenu -->

        <div class="container" id="page">

            <div id="header" style="background-image: a">
                <div id="logo"><?php echo $this->isHome ? CHtml::encode(Yii::app()->name) : CHtml::link(CHtml::encode(Yii::app()->name), array('post/index')); ?></div>
                <div id="description"><?php echo CHtml::encode(Yii::app()->params['appDescription']); ?></div>
                
            </div><!-- header -->


            <?php
//            $this->widget('zii.widgets.CBreadcrumbs', array(
//                'links' => $this->breadcrumbs,
//            ));
            ?><!-- breadcrumbs -->

            <?php echo $content; ?>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
                All Rights Reserved.<br/>
                <?php echo Yii::powered(); ?>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>


<?php
Yii::import('ext.MdmSHBrush.MdmSHBrush');
MdmSHBrush::highlightAll('shCoreDefault.css');
?>
