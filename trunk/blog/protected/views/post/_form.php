<div class="form">

    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 80, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">        
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php //echo CHtml::activeTextArea($model,'content',array('rows'=>20, 'cols'=>70)); ?>
        <?php
        $this->widget('ext.MdmCkEditor.MdmCkEditor', array(
            'model' => $model,
            'attribute' => 'content',
            'options' => array(
                'extraPlugins' => 'equation,syntaxhighlight',
                'toolbar' => array(
                    array('Source'),
                    array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'),
                    array('equation', 'Code','Image', 'Table','Link', 'Smiley', 'Iframe'),
                    array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock')
                ),
                'skin'=>'office2003'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'tags'); ?>
        <?php
        $this->widget('CAutoComplete', array(
            'model' => $model,
            'attribute' => 'tags',
            'url' => array('suggestTags'),
            'multiple' => true,
            'htmlOptions' => array('size' => 50),
        ));
        ?>
        <p class="hint">Please separate different tags with commas.</p>
        <?php echo $form->error($model, 'tags'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Lookup::items('PostStatus')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->