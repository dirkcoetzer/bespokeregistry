<?php
$this->breadcrumbs=array(
	'Registry Products',
);

$this->menu=array(
	array('label'=>'Create RegistryProduct', 'url'=>array('create')),
	array('label'=>'Manage RegistryProduct', 'url'=>array('admin')),
);
?>

<h1>Registry Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
