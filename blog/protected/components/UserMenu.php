<?php

Yii::import('ext.mbmenu.MbMenu');

class UserMenu extends MbMenu {

    public function init() {
        $itemSearch = array('label' => $this->render('_search',null,TRUE), );
        if (Yii::app()->user->isGuest) {
            $this->items = array(
                $itemSearch,
                array('label' => 'Login', 'url' => array('site/login')),
            );
        } else {
            $this->items = array(
                $itemSearch,
                array('label' => Yii::app()->user->name, 'items' => array(
                        array('label' => 'change profile', 'url' => array('user/update')),
                        array('label' => 'change password', 'url' => array('user/changePassword')),
                        array('label' => 'Logout', 'url' => array('site/logout')),
                    )
                ),
            );
            if (Yii::app()->user->can_posting) {
                $this->items[] = array('label' => 'Manage', 'items' => array(
                        array('label' => 'Create New Post', 'url' => array('post/create')),
                        array('label' => 'Manage Post', 'url' => array('post/admin')),
                        array('label' => 'Approve comment (' . Comment::model()->pendingCommentCount . ')',
                            'url' => array('comment/index')),
                        ));
            }
        }
        parent::init();
    }

}