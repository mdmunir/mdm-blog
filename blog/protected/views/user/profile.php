<div class="view">
    <h2><?php echo CHtml::encode($model->username); ?>'s profile</h2>
    <div class="profile">
    <?php echo CHtml::link("Posting ({$model->postingCount})", array('post/index','author'=>$model->username));?>
    <?php
    $this->beginWidget('CMarkdown', array('purifyOutput' => true));
    echo $model->profile;
    $this->endWidget();
    ?>
    </div>
</div>