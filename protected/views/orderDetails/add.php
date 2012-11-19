<?php
$this->breadcrumbs=array(
	'Order'=>array('/order/view', 'id' => $model->order_id),
	'Add Product',
);

$this->menu=array(
	array('label'=>'Back to Order', 'url'=>array('/order/view', 'id' => $model->order_id)),
);
?>

<h1>Add Product</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>