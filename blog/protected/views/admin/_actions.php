<span class="action">
    <div class="">
        
    </div>
    Allow posting
    <?php
    if ($data->can_posting)
        echo CHtml::tag('span', array('class' => 'can_posting'), 'Yes &nbsp; ' . CHtml::linkButton('No', array('submit' => array('admin/allow', 'id' => $data->id))));
    else
        echo CHtml::tag('span', array('class' => 'can_posting'), CHtml::linkButton('Yes', array('submit' => array('admin/notAllow', 'id' => $data->id))) . ' &nbsp; No');
    ?> |
    <?php
    echo CHtml::linkButton('delete', array(
        'submit' => array('admin/delete', 'id' => $data->id),
        'confirm' => "Are you sure you want to delete this post?",
        //'class' => 'icon-delete',
    ));
    ?>
</span>