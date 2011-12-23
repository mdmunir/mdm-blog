<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom-main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php 
            $itemMenu = Yii::app()->user->isGuest ?
                    array('label'=>'Login','url'=>array('site/login'))
                    :array('label'=>Yii::app()->user->name,'items'=>array(
                        array('label'=>'Create New Post','url'=>array('post/create')),
                        array('label'=>'Manage Post','url'=>array('post/admin')),
                        array('label'=>'Approve comment','url'=>array('comment/index')),
                        array('label'=>'Logout','url'=>array('site/logout')),
                        
                    ));
            $this->widget('zii.widgets.CMenu',array(
                'items'=>array($itemMenu),
            ));?>
	</div><!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by M D Munir.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>

<?php
Yii::import('ext.MdmSH.MdmSH');
MdmSH::highlightAll(array('showNum'=>true));
?>
