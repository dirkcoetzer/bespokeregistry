<?php
$this->menu=array(
    array('label'=>'Find a Registry', 'url'=>array('registry/find')),
	array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>

<?php
$this->pageTitle=Yii::app()->name . ' | Book a Consultation';
$this->breadcrumbs=array(
    'Book a Consultation',
);
?>
<h1><?php echo $messageTitle; ?></h1>

<p><?php echo $messageBody; ?></p>