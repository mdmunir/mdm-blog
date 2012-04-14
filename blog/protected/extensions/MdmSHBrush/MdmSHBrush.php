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
class MdmSHBrush {

    //put your code here

    public static function highlightAll($css="shCore.css") {
        $baseUrl = Yii::app()->assetManager->publish(dirname(__FILE__) . '/scripts');
        $baseCss = Yii::app()->assetManager->publish(dirname(__FILE__) . '/styles');
        $path = Yii::app()->assetManager->getPublishedPath(dirname(__FILE__) . '/scripts');

        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseCss . '/' . $css);
        $cs->registerScriptFile($baseUrl . '/shCore.js');
        foreach (scandir($path) as $file) {
            if (substr($file, 0, 7) == 'shBrush' && substr($file, -3) == '.js') {
                $cs->registerScriptFile($baseUrl . '/' . $file);
            }
        }
        $cs->registerScript('MdmSH_Brush', "SyntaxHighlighter.all();");
    }

}

?>
