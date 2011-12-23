<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Go Blog',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'defaultController' => 'post',
    'modules' => array(
        // uncomment the following to enable the Gii tool
        /**/
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'db' => array(
            //'class'=>'ext.PHPPDO.CPdoDbConnection',
            //'pdoClass'=>'PHPPDO',
            'connectionString' => 'sqlite:protected/data/blog.db',
            'tablePrefix' => 'tbl_',
        ),
        'cache' =>array(
            'class'=>'CDbCache'
        ),
        // uncomment the following to use a MySQL database
        /*
          'db'=>array(
          'connectionString' => 'mysql:host=localhost;dbname=blog',
          'emulatePrepare' => true,
          'username' => 'root',
          'password' => '',
          'charset' => 'utf8',
          'tablePrefix' => 'tbl_',
          ),
         */
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'urlManager' => array(
            //'urlFormat' => 'path',
            //'showScriptName'=>false,
            //'urlSuffix'=>'.html',
            'rules' => array(
                'post/<id:\d+>/<title:.*?>' => 'post/view',
                'posts/<tag:.*?>' => 'post/index',
                '<controller:\w+>/<action:\w+>/*' => '<controller>/<action>',
            ),
        ),
        'clientScript' => array(
            'class' => 'MdmClientScript',
            'scriptMap' => array(
                //'jquery.min.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js',
                //'jquery.min.js'=>array('jquery','1.7.0',array('uncompressed'=>true)),
                'jquery.treeview.css' => '~/css/jquery.treeview.css',
            ),
            'packages' => array(
                'jeasyui' => array(
                    'basePath' => 'ext.jeasyui',
                    'js' => array('jquery.easyui.min.js'),
                    'css' => array('themes/gray/easyui.css', 'themes/icon.css'),
                    'depends' => array('jquery'),
                ),
                'ckeditor' => array(
                    'basePath' => 'ext.MdmCkEditor.ckeditor',
                    'js' => array('ckeditor.js', 'adapters/adapter.jquery.js'),
                    'depends' => array('jquery'),
                ),
            ),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);
