<?php
$this->pageTitle=Yii::app()->name . ' | Brands and Stores';
?>

<?php
$this->menu=array(
	array('label'=>'How It Works', 'url'=>array('site/howitworks')),
	array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>

<div class="breadcrumb"><a href="AboutUs.html">About Us</a> > <span class="current">Recommended Suppliers</span></div>

<h2>Brands & Stores</h2>

	<p>In order for you to curate your perfect wedding registry, we've hand-picked a selection of the most coveted brands and stores to partner with. From the finest in kitchen basics to one-of-a-kind works of art, you – and your guests – will be spoilt for choice.</p>

<div id="terms" class="content-outer">
    <div class="content-inner terms-conditions"> 
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/brands-stores.jpg" alt="Brankds and Stores" height="1561px" width="687" />
    </div>
</div>
<div class="clear"></div>