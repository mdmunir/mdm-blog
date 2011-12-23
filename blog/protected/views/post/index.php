<?php if (!empty($_GET['tag'])): ?>
    <h1>Posts Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'ajaxUpdate'=>false,
    'itemView' => '_view',
    'template' => "{items}\n{pager}",
    'afterAjaxUpdate' => 'function(){
$(\'pre[lang]\').each(function(){
    var lang = $(this).attr(\'lang\');
    $(this).snippet(lang,{\'showNum\':true,\'style\':\'navy\'});
});        
}'
));
?>
