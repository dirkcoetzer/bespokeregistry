<?php
$this->breadcrumbs=array(
	'Registry Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistryProduct', 'url'=>array('index')),
	array('label'=>'Manage RegistryProduct', 'url'=>array('admin')),
);
?>

<h1>Create RegistryProduct</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>