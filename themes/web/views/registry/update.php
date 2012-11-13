<?php
$this->menu[] = array('label'=>'My Registry', 'url'=>array('registry/update'));
$this->menu[] = array('label'=>'My Registry List', 'url'=>array('registryProduct/list'));
if ($model->event_date <= time())
    $this->menu[] = array('label'=>'Order My Gifts', 'url'=>array('/order/process', 'rid'=>$model->id));
$this->menu[] = array('label'=>'Guest Purchase Report', 'url'=>array('order/index', 'rid' => $model->id));
$this->menu[] = array('label'=>'Email My Consultant', 'url'=>array('registry/contact', 'id' => $model->id));
?>

<div class="breadcrumb"><a href="index.html">Home</a> > <span class="current">My Registry</span></div>
<h2>My Registry</h2>
<p>Below is the message and details your guests will see when they arrive at your registry to buy you gifts. You're welcome to edit it and upload a photo if you like. </p>
<p>Please feel free to edit your contact details at any point and once updated, press the save button below.</p>
<div id="my-registry" class="content-outer">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'registry-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype' => 'multipart/form-data')
    )); ?>
    <div style="display: none" >
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="content-inner registry-dashboard">
        <h2>Event Details</h2>
        <div class="content-subsection">
            <img src="/<?php echo $model->image_thumb; ?>" alt="<?php echo $model->title; ?>" class="registry-profile img-shadow" width="80px" />
            <?php echo $form->textField($model,'title',array('class'=>'registry-name','maxlength'=>50)); ?>
            <?php echo $form->textField($model,'event_date',array('value' => date("d M Y", $model->event_date), 'class'=>'registry-date','id' => 'datepicker', 'maxlength'=>50)); ?>
            <br />
            <br />
            <a href="#">Add photo</a>
            <div id="image-input">
                <?php echo $form->fileField($model,'file', array('class' => 'email-address')); ?>
            </div>
        </div>
        <div class="content-subsection">
            <h2>Message to your friends & family</h2>
            <?php echo $form->textArea($model,'message',array('class'=>'message')); ?>
        </div>
        <h2>Contact Details</h2>
        <label>Email Address</label><?php echo $form->textField($model,'email',array('class' => 'email-address')); ?>
        <br />
        <label>Mobile Number</label><?php echo $form->textField($model,'mobile_phone',array('class'=>'mobile-number')); ?>
        <br />
        <label>Home Number</label><?php echo $form->textField($model,'home_phone',array('class'=>'home-number')); ?>
        <br />

        <label class="delivery">Delivery Address</label><?php echo $form->textArea($model,'address',array('class'=>'delivery-address')); ?>
        <br />
        <a href="#" class="save float-r" id="form-submit"></a>
        <?php $this->endWidget(); ?>
    </div>
    <script type="text/javascript">
        $("a#form-submit").click(function(e){
            e.preventDefault();
            $("#registry-form").submit();
        })
    </script>
</div>