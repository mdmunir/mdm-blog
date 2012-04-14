<div class="post">
    <div class="title">
        <?php if (!Yii::app()->user->isGuest && Yii::app()->user->id == $data->author->id): ?>
            <span class="manage-link">
                <?php echo CHtml::link('&nbsp;', array('post/update', 'id' => $data->id), array('class' => 'icon-update')); ?>
                <?php
                echo CHtml::linkButton('&nbsp;', array(
                    'submit' => array('post/delete', 'id' => $data->id),
                    'confirm' => "Are you sure you want to delete this post?",
                    'class' => 'icon-delete',
                ));
                ?>
            </span>
<?php endif; ?>
<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
    </div>
    <div class="author">
        posted by <?php echo CHtml::link($data->author->FullName,$data->author->profileLink) . ' on ' . date('j F, Y', $data->create_time); ?>
    </div>
    <div class="content">
        <?php
        //$this->beginWidget('CMarkdown', array('purifyOutput' => true));
        $this->beginWidget('CHtmlPurifier');
        echo $data->content;
        $this->endWidget();
        ?>
    </div>
    <div class="nav">
        <b>Tags:</b>
        <?php echo implode(', ', $data->tagLinks); ?>
        <br/>
<?php echo CHtml::link('Permalink', $data->url); ?> |
<?php echo CHtml::link("Comments ({$data->commentCount})", $data->url . '#comments'); ?> |
        Last updated on <?php echo date('j F, Y', $data->update_time); ?>
    </div>
</div>
