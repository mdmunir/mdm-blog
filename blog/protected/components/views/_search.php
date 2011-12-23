<?php
echo CHtml::beginForm(array('site/search'), 'get', array());
echo CHtml::textField('q', '', array('submit'=>array('site/search')));
echo CHtml::endForm();
?>
