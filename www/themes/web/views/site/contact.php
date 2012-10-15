<?php
$this->pageTitle=Yii::app()->name . ' | Book a Consultation';
?>


<?php
$this->menu=array(
	array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>
<div class="breadcrumb"><a href="#">Home</a> > <span class="current">Book a Consultation</span></div>

<h2>Book a Consultaion</h2>
<p>Please get in touch with us to set up a meeting with your own personal consultant.</p>
<div id="contact-us" class="content-outer">

    <div class="content-inner">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'contact-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>
        <h2>Send us a message</h2>
        <div class="message-consultant">
            <span class="mandatory">*Mandatory Fields</span><br />
            <label>First Name*</label><?php echo $form->textField($model,'name'); ?><br />
            <label>Last Name*</label><?php echo $form->textField($model,'lastname'); ?><br />
            <label>Email Address*</label><?php echo $form->textField($model,'email',array("class" => "home-number")); ?><br />
            <label>Subject*</label><?php echo $form->textField($model,'subject',array('class'=> 'home-number')); ?><br />
            <label class="how-help">How can we help?</label><?php echo $form->textArea($model,'body',array('class' => 'help')); ?><br />
            <?php if(CCaptcha::checkRequirements()): ?>

            <table width="300px">
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;" >
                        <label class="how-help">Verification Code</label><br/>
                    </td>
                    <td style="vertical-align: top; padding-top: 10px;" >
                        <?php $this->widget(
                                "CCaptcha",
                                array(
                                    'showRefreshButton'=>true,
                                )
                              );
                        ?><br/><br/>
                        <?php echo $form->textField($model,'verifyCode'); ?><br/>
                        Please enter the letters as they are shown in the image above.<br/>
                    </td>
                </tr>
            </table>
                
            <?php endif; ?>

            <a href="#" class="submit float-r"></a>
        </div>
        <div class="contact-details-consultant">
            <div class="contact-item"><h3>Call Us</h3>
                <span class="call-us">021 761 3743</span>
                <span class="mobile-num">076 390 7017</span>
            </div>
        </div>

        <?php $this->endWidget(); ?>
        <br class="clear" />
    </div>
</div>
<br class="clear" />
<script type="text/javascript" >
    $("a.submit").click(function(e){
        e.preventDefault();

        $("#contact-form").submit();
    });
</script>