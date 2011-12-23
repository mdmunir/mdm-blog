<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

$this->widget('ContentMenu');

$this->widget('TagCloud', array(
    'maxTags' => Yii::app()->params['tagCloudCount'],
));

$this->widget('RecentComments', array(
    'maxComments' => Yii::app()->params['recentCommentCount'],
));
?>