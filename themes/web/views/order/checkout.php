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

<h2>My Payment</h2>
<p>Please fill in your credit card details below.</p>

<div id="checkout-progress" class="step3">
<div class="step1">Gift Bag</div>
<div class="step2">Order Details</div>
<div class="step3 active">Payment</div>
<div class="step4">Confirmation</div>
<div class="checkout-status"></div>

</div>
<br /><br /><br />

<div class="content-outer order-details">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'order-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <div style="display: none">
        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="order-title"><h2>Fill in your details</h2></div>

    <div class="content-inner order-details-sections">
        <p>*Mandatory Fields</p>
        <label class="message">Name *</label>
        <?php echo $form->textField($model,'name'); ?>
        <br/>
        
        <label>Card Type * </label>
        <?php echo $form->dropDownList($model,'card_type', array('mastercard'=>'Master Card','visa'=>'VISA'), array('prompt' => '- Card Type -')); ?>
         
        <img style="margin: 10px 0 -12px 20px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/card-types.png">
        <br />
        
        <label class="message">Card Number *</label>
        <?php echo $form->textField($model,'card_number', array('maxlength'=>16)); ?>
        <br />
        
        <label class="message">CSV Number *</label>
        <?php echo $form->textField($model,'cvv_number', array('maxlength'=>3)); ?>
        
        <img style="margin: 10px 0 -12px 20px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/3-digits.png">
        <br />

        <label>Expiration Date * </label>
        <?php echo $form->dropDownList($model,'expiration_date_month', Order::model()->getMonthOptions(), array("prompt" => "- Month -")); ?>
        
        <?php echo $form->dropDownList($model,'expiration_date_year', Order::model()->getYearOptions(), array("prompt" => "- Year -")); ?> 
        <br />
        <br />
        <?php echo $form->hiddenField($model,'order_id'); ?>
        
        <input type="checkbox" checked="checked" > I agree with the <a href="#">Terms & Conditions</a> 

    </div>
    <?php $this->endWidget(); ?>
</div>

<a href="#" class="pay-now float-r"></a>
<a style="display: inline-block; width: 150px; text-align: right; float: right; line-height: 70px; margin: 0 20px 0 0;" class="float_r"  href="<?php echo $this->createUrl("registryProduct/browse", array("rid" => $registry->id)); ?>">Continue Shopping</a>
<br />
<img class="float-l" style="margin: 0 0 0 20px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/payment-logos.png" alt="Payment Options">
<br class="clear" />

<script type="text/javascript" >
    $("a.pay-now").click(function(e){
        e.preventDefault();
        $("#order-form").submit();
    });
</script>