<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdmCkEditor
 *
 * @author mdmunir
 */
class MdmCkEditor extends CInputWidget {

    //put your code here

    public $ckeditorPackage = 'ckeditor';
    public $options = array();
    public $editorReady = 'function(){}';

    public function run() {
        list($name, $id) = $this->resolveNameID();

        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;

        if (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];

        if ($this->hasModel())
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        else
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);

        $options = CJavaScript::encode($this->options);

        $js = "jQuery('#{$id}').ckeditor({$this->editorReady},$options);";

        Yii::app()->getClientScript()->registerPackage('ckeditor');
        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, $js);
    }

}

?>
