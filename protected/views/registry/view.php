<?php
$this->breadcrumbs=array(
	'Registries'=>array('index'),
	$model->title,
);

$this->menu=array(
	//array('label'=>'List Registry', 'url'=>array('index')),
	array('label'=>'Create Registry', 'url'=>array('create')),
	array('label'=>'Update Registry', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Registry', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Registry', 'url'=>array('admin')),
    array('label'=>'Add Product', 'url'=>array('registryProduct/create', 'rid'=>$model->id)),
);
?>

<h1>View Registry #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'event_date',
		'image',
		'image_thumb',
		'message',
		'email',
		'mobile_phone',
		'home_phone',
		'address',
        array(
            'name'=>'status_id',
            'value'=>CHtml::encode($model->getStatusText())
        ),
		'created_by',
		'created_date',
		'modified_by',
		'modified_date',
	),
)); ?>
<br>
<h1>Registry Products</h1>
<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$registryProductDataProvider,
        'itemView'=>'/registryProduct/_view',
    ));
?>