<?php
$this->menu=array(
    array('label'=>'My Registry', 'url'=>array('registry/update')),
    array('label'=>'My Registry List', 'url'=>array('registryProduct/list')),
	array('label'=>'Order My Gifts', 'url'=>array('/')),
	array('label'=>'Guest Purchase Report', 'url'=>array('order/index&rid='.$registry->id)),
	array('label'=>'Email My Consultant', 'url'=>array('registry/contact&id='.$registry->id)),
);
?>

<?php
$this->pageTitle=Yii::app()->name . ' - Book a Consultation';
$this->breadcrumbs=array(
    'Book a Consultation',
);
?>
<h1><?php echo $messageTitle; ?></h1>

<p><?php echo $messageBody; ?></p>