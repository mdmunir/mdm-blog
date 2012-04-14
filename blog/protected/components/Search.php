<?php

Yii::import('zii.widgets.CPortlet');

class Search extends CPortlet {

    public $title = 'Search';

    protected function renderContent() {
        echo CHtml::beginForm(array('site/search'), 'get', array());
        echo CHtml::textField('q', '');
        echo CHtml::submitButton('Search');
        echo CHtml::endForm();
    }

}