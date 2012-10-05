<?php
$this->breadcrumbs=array(
	'Order Details',
);

$this->menu=array(
	array('label'=>'Create OrderDetails', 'url'=>array('create')),
	array('label'=>'Manage OrderDetails', 'url'=>array('admin')),
);
?>

<h1>Order Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
