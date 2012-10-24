<?php
$this->breadcrumbs=array(
	'Order Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderDetails', 'url'=>array('index')),
	array('label'=>'Manage OrderDetails', 'url'=>array('admin')),
);
?>

<h1>Create OrderDetails</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>