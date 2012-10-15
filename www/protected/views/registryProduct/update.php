<?php
$this->breadcrumbs=array(
	'Registry Products'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistryProduct', 'url'=>array('admin')),
	array('label'=>'Create RegistryProduct', 'url'=>array('create')),
	array('label'=>'View RegistryProduct', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RegistryProduct', 'url'=>array('admin')),
);
?>

<h1>Update RegistryProduct <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>