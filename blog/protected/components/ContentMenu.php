<?php

Yii::import('zii.widgets.CPortlet');

class ContentMenu extends CPortlet {
    const CACHE_ID = 'archive_menu';

    public $title = 'Archive';

    protected function renderContent() {
        $this->widget('CTreeView', array('unique' => TRUE, 'collapsed' => true,'data'=>  $this->getContentData()));
    }

    protected function getContentData() {
        $data = Yii::app()->cache->get(self::CACHE_ID);
        //$data = false;
        if ($data === FALSE) {
            $content = Post::model()->findAll(array(
                'select' => array('id, title, create_time')
                    ));
            $data = $this->normalizeData($content);
            $dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM tbl_post');
            Yii::app()->cache->set(self::CACHE_ID, $data, 0, $dependency);
        }
        if($this->controller->route == 'post/view' && isset ($_GET['id'])){
            $t = Yii::app()->db->createCommand('select create_time from tbl_post where id='.$_GET['id'])->queryScalar();
            $y = date('Y',$t);
            $m = date('F',$t);
        }else{
            $t = Yii::app()->db->createCommand('select MAX(create_time) from tbl_post')->queryScalar();
            $y = date('Y',$t);
            $m = date('F',$t);
        }
        $data[$y]['expanded'] = TRUE;
        $data[$y]['children'][$m]['expanded'] = TRUE;
        return $data;
    }

    protected function normalizeData($content) {
        $data = array();
        foreach ($content as $post) {
            $y = date('Y', $post->create_time);
            $m = date('F', $post->create_time);
            $title = substr($post->title, 0, 42);
            if (!isset($data[$y])) {
                $data[$y] = array(
                    'text' => "$y (1)",
                    'count' => 1,
                    'children' => array(
                        $m => array(
                            'text' => "$m (1)",
                            'count' => 1,
                            'children' => array(
                                array(
                                    'text' => CHtml::link($title, array('post/view', 'id' => $post->id, 'title' => $title)))
                            )
                        )
                    )
                );
            } else {
                $data[$y]['count']++;
                $data[$y]['text'] = "$y ({$data[$y]['count']})";
                if (!isset($data[$y]['children'][$m])) {
                    $data[$y]['children'][$m] = array(
                        'text' => "$m (1)",
                        'count' => 1,
                        'children' => array(
                            array('text' => CHtml::link($title, array('post/view', 'id' => $post->id, 'title' => $title)))
                        )
                    );
                } else {
                    $data[$y]['children'][$m]['count']++;
                    $data[$y]['children'][$m]['text'] = "$m ({$data[$y]['children'][$m]['count']})";
                    $data[$y]['children'][$m]['children'][] = array('text' => CHtml::link($title, array('post/view', 'id' => $post->id, 'title' => $title)));
                }
            }
        }
        return $data;
    }

}