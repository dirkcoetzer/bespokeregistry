<?php
$this->pageTitle = Yii::app()->name . " | Login";

$this->menu=array(
    array('label'=>'Login', 'url'=>array('')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>
<div class="breadcrumb"><a href="#">Home</a> > <span class="current">Login</span></div>
<div class="flash-message" ><?php Yum::renderFlash(); ?></div>
<h2>Login</h2>
<p>Fill in your email address and password supplied by your personal consultant.</p>
<div class="content-outer find-registry">
<div class="content-inner find-registry-form">
<?php echo CHtml::beginForm(array('//user/auth/login'));  ?>
    <?php
    if(isset($_GET['action']))
        echo CHtml::hiddenField('returnUrl', urldecode($_GET['action']));
    ?>
    <?php echo CHtml::errorSummary($model); ?>
    
	<label class="firstname">Username</label><?php echo CHtml::activeTextField($model,'username') ?> <label class="lastname">Password</label><?php echo CHtml::activePasswordField($model,'password'); ?>

    <?php echo CHtml::submitButton(Yum::t('Login'), array("class"=>"form-login-btn")); ?>
	<br /><br /><br />
    <?php echo CHtml::activeCheckBox($model,'rememberMe', array('class' => 'remeber-me')); ?>
    <?php echo CHtml::activeLabelEx($model,'rememberMe', array('class' => 'remember-me')); ?>
	<br />
	<div class="password">
	<?php
	if(Yum::hasModule('registration')
			&& Yum::module('registration')->enableRecovery)
	echo CHtml::link(Yum::t("Lost password?"),
			Yum::module('registration')->recoveryUrl);
	?>
</div>    
<?php echo CHtml::endForm(); ?>

</div>
</div>
<div style="min-height: 530px; margin: 0; padding: 0;"></div>