<?php

Yii::import('ext.mbmenu.MbMenu');

class UserMenu extends MbMenu {

    public function init() {
        $isAuth = !Yii::app()->user->isGuest;
        $uName = $isAuth ? Yii::app()->user->name : 'Guest';
        $canPost = $isAuth && Yii::app()->user->can_posting;
        $pendingCount = $canPost ? Comment::model()->pendingCommentCount : 0;
        $this->items = array(
            array('label' => $this->render('_search', null, TRUE), 'visible' => false),
            array('label' => 'Guest', 'visible' => !$isAuth,
                'items' => array(
                    array('label'=>'Login','url'=>array('site/login')),
                    array('label'=>'Register','url'=>array('user/create')),
                )
            ),
            array('label' => $uName, 'visible' => $isAuth,
                'items' => array(
                    array('label' => 'change profile', 'url' => array('user/update')),
                    array('label' => 'change password', 'url' => array('user/changePassword')),
                    array('label' => 'Administrator', 'visible' => $isAuth && Yii::app()->user->name == 'admin',
                        'url' => array('admin/index')
                    ),
                    array('label' => 'Logout', 'url' => array('site/logout')),
                )
            ),
            array('label' => 'Manage', 'visible' => $canPost,
                'items' => array(
                    array('label' => 'Create New Post', 'url' => array('post/create')),
                    array('label' => 'Manage Post', 'url' => array('post/admin')),
                    array('label' => "Approve comment ($pendingCount)",
                        'url' => array('comment/index')),
            )),
        );
        parent::init();
    }

}