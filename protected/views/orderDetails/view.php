<?php
$this->breadcrumbs=array(
	'Order Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrderDetails', 'url'=>array('index')),
	array('label'=>'Create OrderDetails', 'url'=>array('create')),
	array('label'=>'Update OrderDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrderDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrderDetails', 'url'=>array('admin')),
);
?>

<h1>View OrderDetails #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_id',
		'product_id',
		'qty',
		'price',
		'type',
	),
)); ?>
