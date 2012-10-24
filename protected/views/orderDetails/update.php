<?php
$this->breadcrumbs=array(
	'Order Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderDetails', 'url'=>array('index')),
	array('label'=>'Create OrderDetails', 'url'=>array('create')),
	array('label'=>'View OrderDetails', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderDetails', 'url'=>array('admin')),
);
?>

<h1>Update OrderDetails <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>