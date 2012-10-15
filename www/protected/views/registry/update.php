<?php
$this->breadcrumbs=array(
	'Registries'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Registry', 'url'=>array('index')),
	array('label'=>'Create Registry', 'url'=>array('create')),
	array('label'=>'View Registry', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Registry', 'url'=>array('admin')),
);
?>

<h1>Update Registry <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>