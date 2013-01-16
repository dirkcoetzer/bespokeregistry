<?php
$this->menu=array(
    array('label'=>'Find a Registry', 'url'=>array('registry/find')),
	array('label'=>'Buy a Gift', 'url'=>array('registryProduct/browse', array('rid' => $regisry->id))),
    array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>
<div class="breadcrumb"><a href="#">Home</a> > <a href="#">Find Registry</a> > <a href="#">Search Results</a> > <span class="current">Buy a Gift</span></div>

<h2>Confirmation</h2>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
    ?>
        <h3 class="<?php echo $key; ?>" ><?php echo $message; ?></h3>
    <?php
    }
?>

<p>Thank you!</p>
<div id="checkout-progress">
<div class="step1 completed">1. My Cart</div>
<div class="step1 completed">2. Order Details</div>
<div class="step1 completed">3. My Payment</div>
<div class="step1 active">4. Confirmation</div>
</div>
<br /><br /><br />

<br class="clear" />