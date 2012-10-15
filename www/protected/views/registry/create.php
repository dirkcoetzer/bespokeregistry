<?php
$this->breadcrumbs=array(
	'Registries'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Registry', 'url'=>array('index')),
	array('label'=>'Manage Registry', 'url'=>array('admin')),
);
?>

<h1>Create Registry</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>