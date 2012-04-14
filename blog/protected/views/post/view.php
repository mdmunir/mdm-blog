<?php
$this->breadcrumbs = array(
    $model->title,
);
$this->pageTitle = Yii::app()->name . ' - ' . $model->title;

Yii::app()->clientScript->registerMetaTag($model->tags, 'keyword');
?>

<?php
$this->renderPartial('_view', array(
    'data' => $model,
));
?>

<div id="comments">
        <?php if ($model->commentCount >= 1): ?>
        <h3>
        <?php echo $model->commentCount > 1 ? $model->commentCount . ' comments' : 'One comment'; ?>
        </h3>

        <?php
        $this->renderPartial('_comments', array(
            'post' => $model,
            'comments' => $model->comments,
            'depth' => 1,
        ));
        ?>
        <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
        <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
        </div>
    <?php else: ?>
    <?php
    $this->renderPartial('/comment/_form', array(
        'model' => $comment,
    ));
    ?>
<?php endif; ?>

</div><!-- comments -->
<?php
Yii::app()->clientScript->registerScript('reply-comment-script', "
$('.reply-link').click(function(){
  if($(this).text()=='Reply'){
    $('.reply-link').text('Reply');
    $(this).after($('#comment-form'));
    $('#comment-parent-field').val($(this).data('commentid'));
    $(this).text('Cancel Reply');
  }else{
    $('#dom-before-comment-form').after($('#comment-form'));
    $('#comment-parent-field').val('');
    $(this).text('Reply');
  }
}
);
");
?>