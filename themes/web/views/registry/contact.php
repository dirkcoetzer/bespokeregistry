<?php
$this->menu[] = array('label'=>'My Registry', 'url'=>array('registry/update'));
$this->menu[] = array('label'=>'My Registry List', 'url'=>array('registryProduct/list'));
if ($registry->event_date <= time())
    $this->menu[] = array('label'=>'Order My Gifts', 'url'=>array('/order/process', 'rid'=>$registry->id));
$this->menu[] = array('label'=>'Guest Purchase Report', 'url'=>array('order/index', 'rid' => $registry->id));
$this->menu[] = array('label'=>'Email My Consultant', 'url'=>array('registry/contact', 'id' => $registry->id));
?>
<div class="breadcrumb"><a href="#">Home</a> > <span class="current">Contact Us</span></div>

<h2>Email Your Consultant</h2>
<p>Use the form below to contact your personal consultant.</p>
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
            <label>Last Name*</label><input class="mobile-number"><br />
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
                                    'showRefreshButton'=>false,
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