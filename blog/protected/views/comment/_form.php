<div id="dom-before-comment-form" style="display: none"></div>
<div id="comment-form" class="form">
    <h3>Leave a Comment</h3>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'comment-form',
        'enableAjaxValidation' => FALSE,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->hiddenField($model, 'comment_parent',array('id'=>'comment-parent-field')); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'author'); ?>
        <?php echo $form->textField($model, 'author', array('size' => 35, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'author'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 35, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('size' => 35, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 60)); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->