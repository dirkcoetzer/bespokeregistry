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

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
    ?>
        <h3 class="<?php echo $key; ?>" ><?php echo $message; ?></h3>
    <?php
    }
?>

<h2 class="success">Your Payment Has been Successful!</h2>
<h3>Thank you so much for using Bespoke. Your selected gifts will be delivered to the couple after their wedding.</h3>
<br /><br />
<div id="checkout-progress" class="step4">
<div class="step1">Gift Bag</div>
<div class="step2">Order Details</div>
<div class="step3">Payment</div>
<div class="step4 active">Confirmation</div>
<div class="checkout-status"></div>

</div>
<br /><br /><br />

<br class="clear" />