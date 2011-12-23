<div class="view">
    <div class="user">
        <?php echo CHtml::link(CHtml::encode($data->username), array('user/view', 'id' => $data->id)); ?>
        <?php //echo CHtml::mailto(CHtml::encode($data->email), $data->email); ?>
    </div>
    <div class="action">
        Allow posting [
        <?php
        if ($data->can_posting)
            echo CHtml::tag('span', array('class' => 'can_posting'), 'Yes ; ' . CHtml::linkButton('No', array('submit' => array('admin/allow', 'id' => $data->id))));
        else
            echo CHtml::tag('span', array('class' => 'can_posting'), CHtml::linkButton('Yes', array('submit' => array('admin/allow', 'id' => $data->id,'allow'=>TRUE))) . ' No');
        ?> ] |
        <?php
        echo CHtml::linkButton('delete', array(
            'submit' => array('admin/delete', 'id' => $data->id),
            'confirm' => "Are you sure you want to delete this post?",
                //'class' => 'icon-delete',
        ));
        ?>
    </div>
    <div class="profile">
        <?php
        $this->beginWidget('CMarkdown', array('purifyOutput' => true));
        echo $data->profile;
        $this->endWidget();
        ?>
    </div>
</div>