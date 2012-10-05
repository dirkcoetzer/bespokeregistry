<?php
    $this->contentClass = 'search-registry';
?>
<?php
$this->menu=array(
    array('label'=>'Find a Registry', 'url'=>array('registry/find')),
	array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>
<div class="breadcrumb"><a href="/">Home</a> > <span class="current">Find Registry</span></div>
<div style="min-height: 890px;">
<h2>Search for a couple you want to buy a gift for.</h2>
<p>Please enter the name of the couple you wish to buy a gift for. You’ll be able to select from a range of items hand-picked by the couple to create their perfect registry.</p>
<div class="content-outer find-registry">
  
    <div class="content-inner find-registry-form">
    	<br /><br />
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'registry-form',
        'enableAjaxValidation'=>false,
    )); ?>
        <label class="firstname">First Name</label>
        <input class="" id="first_name" name="first_name" />
        <label class="lastname">Last Name</label>
        <input class="" id="last_name" name="last_name" />

        <input class="search-btn" type="submit">
    <?php $this->endWidget(); ?>
    <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
</div>