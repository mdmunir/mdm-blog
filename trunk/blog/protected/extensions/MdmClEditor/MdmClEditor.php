<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdmClEditor
 *
 * @author mdmunir
 */
class MdmClEditor extends CInputWidget {

    //put your code here
    /**
     * @var array the initial JavaScript options that should be passed to the MdmClEditor plugin.
     */
    public $options = array();

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

        $js = "jQuery('#{$id}').cleditor($options);";

        $cs = Yii::app()->getClientScript();
        $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cleditor' . DIRECTORY_SEPARATOR;
        $aUrl = Yii::app()->getAssetManager()->publish($assets);
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($aUrl . DIRECTORY_SEPARATOR . 'jquery.cleditor.min.js');
        $cs->registerCssFile($aUrl . DIRECTORY_SEPARATOR . 'jquery.cleditor.css');

        $cs->registerScript(__CLASS__ . '#' . $id, $js);
    }

}

?>
