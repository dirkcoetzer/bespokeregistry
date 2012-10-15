<?php
$this->breadcrumbs=array(
	'Registry Products'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RegistryProduct', 'url'=>array('index')),
	array('label'=>'Create RegistryProduct', 'url'=>array('create')),
	array('label'=>'Update RegistryProduct', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RegistryProduct', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistryProduct', 'url'=>array('admin')),
);
?>

<h1>View RegistryProduct #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'registry_id',
		'product_id',
		'price',
        'contribution_item',
		'qty_requested',
        'priority_item',
		'created_by',
		'created_date',
		'modified_by',
		'modified_date',
	),
)); ?>
