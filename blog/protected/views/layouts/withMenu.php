<?php $this->beginContent('/layouts/mainLayout'); ?>
<div class="content">
        <?php echo $content; ?>
</div>
<div class="side-menu">
        <?php if (!Yii::app()->user->isGuest)
            $this->widget('UserMenu'); ?>

        <?php
        $this->widget('TagCloud', array(
            'maxTags' => Yii::app()->params['tagCloudCount'],
        ));
        ?>

        <?php
        $this->widget('RecentComments', array(
            'maxComments' => Yii::app()->params['recentCommentCount'],
        ));
        ?>
</div>

<?php $this->endContent(); ?>