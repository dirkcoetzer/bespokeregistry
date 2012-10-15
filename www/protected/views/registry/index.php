<?php
$this->breadcrumbs=array(
	'Registries',
);

$this->menu=array(
	array('label'=>'Create Registry', 'url'=>array('create')),
	array('label'=>'Manage Registry', 'url'=>array('admin')),
);
?>

<h1>Registries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
