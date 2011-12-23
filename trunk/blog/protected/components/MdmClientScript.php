<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdmClientScript
 *
 * @author mdmunir
 */
class MdmClientScript extends CClientScript {

    //put your code here
    public $apiKey;

    protected function remapScripts() {
        $base = Yii::app()->request->baseUrl;
        $cssFiles = array();
        foreach ($this->cssFiles as $url => $media) {
            $name = basename($url);
            if (isset($this->scriptMap[$name])) {
                if ($this->scriptMap[$name] !== false) {
                    if ($this->scriptMap[$name][0] == '~')
                        $this->scriptMap[$name] = $base . substr($this->scriptMap[$name], 1);
                    $cssFiles[$this->scriptMap[$name]] = $media;
                }
            }
            else if (isset($this->scriptMap['*.css'])) {
                if ($this->scriptMap['*.css'] !== false) {
                    if ($this->scriptMap['*.css'][0] == '~')
                        $this->scriptMap['*.css'] = $base . substr($this->scriptMap['*.css'], 1);
                    $cssFiles[$this->scriptMap['*.css']] = $media;
                }
            }
            else
                $cssFiles[$url] = $media;
        }
        $this->cssFiles = $cssFiles;

        $jsFiles = array();
        $jsapi = isset($this->apiKey) ? CGoogleApi::$bootstrapUrl . '?key=' . $this->apiKey : CGoogleApi::$bootstrapUrl;
        foreach ($this->scriptFiles as $position => $scripts) {
            $jsFiles[$position] = array();
            foreach ($scripts as $key => $script) {
                $name = basename($script);
                if (isset($this->scriptMap[$name])) {
                    if ($this->scriptMap[$name] !== false) {
                        if (is_array($this->scriptMap[$name])) {
                            $jsFiles[self::POS_HEAD][$jsapi] = $jsapi;
                            $js = call_user_func_array(array('CGoogleApi', 'load'), $this->scriptMap[$name]);
                            $this->registerScript($name, $js, $position);
                        } else {
                            if ($this->scriptMap[$name][0] == '~')
                                $this->scriptMap[$name] = $base . substr($this->scriptMap[$name], 1);
                            $jsFiles[$position][$this->scriptMap[$name]] = $this->scriptMap[$name];
                        }
                    }
                }
                else if (isset($this->scriptMap['*.js'])) {
                    if ($this->scriptMap['*.js'] !== false) {
                        if ($this->scriptMap['*.js'][0] == '~')
                            $this->scriptMap['*.js'] = $base . substr($this->scriptMap['*.js'], 1);
                        $jsFiles[$position][$this->scriptMap['*.js']] = $this->scriptMap['*.js'];
                    }
                }
                else
                    $jsFiles[$position][$key] = $script;
            }
        }
        $this->scriptFiles = $jsFiles;
    }

}

?>
