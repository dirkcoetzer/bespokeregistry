<?php
$this->breadcrumbs=array(
	'Registries'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Registry', 'url'=>array('index')),
	array('label'=>'Create Registry', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('registry-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Registries</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'registry-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
            'id',
            array(
                'name' => 'owner_id',
                'type' => 'raw',
                'value' => 'CHtml::link($data->owner_id, Yii::app()->createUrl("/user/user/view/id/".$data->owner_id))'
            ),
            array(
                'name' => 'image_thumb',
                'type' => 'html',
                'value' => 'CHtml::image("/".$data->image,"",array("style"=>"width:48px;height:48px;"))'
            ),
            'title',
                    array(
                'name' => 'event_date',
                'value' => 'date("Y-m-d",$data->event_date)',
            ),
            'email',
            /*
            'mobile_phone',
            'home_phone',
            'address',
            'created_by',
            'created_date',
            'modified_by',
            'modified_date',
            */
            array(
                    'class'=>'CButtonColumn',
            ),
	),
)); ?>
