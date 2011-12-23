<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdmSH
 *
 * @author mdmunir
 */
class MdmSH {

    //put your code here

    public static function registerScript() {
        $baseUrl = Yii::app()->assetManager->publish(dirname(__FILE__) . '/snippet');
        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile($baseUrl . '/jquery.snippet.js');
        $cs->registerCssFile($baseUrl . '/jquery.snippet.css');
    }

    public static function highlightAll($option = array()) {
        self::registerScript();
        //transparent
        //if(!isset ($option['transparent'])) $option['transparent'] = TRUE;
        if(!isset ($option['style'])) $option['style'] = 'navy';
        
        $option = CJavaScript::encode($option);
        $js = <<< SCRIPT
$('pre[lang]').each(function(){
    var lang = $(this).attr('lang');
    $(this).snippet(lang,$option);
});
SCRIPT;
        Yii::app()->getClientScript()->registerScript('MdmSH_snippet',$js);
    }

}

?>
