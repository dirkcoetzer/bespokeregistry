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

<h2>Order Details</h2>
<p>Write your message which will be passed onto the couple. Please fill in your details below for the contact and invoice details. The contact details will only be used if we have a query regarding your purchase.</p>

<div id="checkout-progress">
<div class="step1 completed"><span>1. My Cart</span></div>
<div class="step2 active"><span>2. Order Details</span></div>
<div class="step3"><span>3. My Payment</span></div>
<div class="step4"><span>4. Confirmation</span></div>
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

    <div class="order-title"><h2>Your Message</h2></div>

    <div class="content-inner order-details-sections">
        <label class="message">Message</label>
        <?php echo $form->textArea($model,'message',array('class'=>'order-message')); ?>
        <div class="order-title">
            <h2>Contact Details</h2>
        </div>
        <span class="mandatory" >*Mandatory Fields</span>
        <br />
        <label>First Name*</label><?php echo $form->textField($model,'first_name',array('class'=>'email-address','maxlength'=>50)); ?>
        <label>Last Name*</label><?php echo $form->textField($model,'last_name',array('class'=>'email-address','maxlength'=>50)); ?>
        <br />
        <label>Mobile Number*</label><?php echo $form->textField($model,'mobile_phone',array('class'=>'email-address','maxlength'=>20)); ?>
        <label>Email Address*</label><?php echo $form->textField($model,'email',array('class'=>'email-address','maxlength'=>100)); ?>
        
        <div class="order-title">
            <h2>Invoice Details</h2>
        </div>
        <span class="mandatory" >*Mandatory Fields</span>
        <br />
        <label>Address*</label>
        <?php echo $form->textField($model,'street',array('size'=>50,'maxlength'=>50)); ?>
        <label>Town*</label>
        <?php echo $form->textField($model,'city',array('class'=>'email-address','maxlength'=>50)); ?>
        <br />
        <label>Address</label>
        <?php echo $form->textField($model,'suburb',array('class'=>'email-address','maxlength'=>50)); ?>
        <label>Post Code*</label>
        <?php echo $form->textField($model,'postal_code',array('class'=>'email-address','maxlength'=>10)); ?>
        

        <?php echo $form->hiddenField($model,'gift_wrapping',array('value'=> $_SESSION["Order"][$this->_registry->id]["gift_wrapping"])); ?>

    </div>
    <?php $this->endWidget(); ?>
</div>

<a href="#" class="secure-checkout float-r"></a>
<a class="link-continue-shopping float_r" href="<?php echo $this->createUrl("registryProduct/browse", array("rid" => $registry->id)); ?>">Continue Shopping</a>
<br />
<img class="float-l" style="margin: 0 0 0 20px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/payment-logos.png" alt="Payment Options">
<br class="clear" />

<script type="text/javascript" >
    $("a.secure-checkout").click(function(e){
        e.preventDefault();
        $("#order-form").submit();
    });
</script>