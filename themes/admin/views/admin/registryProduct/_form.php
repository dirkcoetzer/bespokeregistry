<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registry-product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->dropDownList($model,'product_id', Product::model()->getProductOptions()); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_requested'); ?>
		<?php echo $form->textField($model,'qty_requested'); ?>
		<?php echo $form->error($model,'qty_requested'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'stock'); ?>
		<?php echo $form->dropDownList($model,'stock',array(0 => "No", 1 => "Yes")); ?>
		<?php echo $form->error($model,'stock'); ?>
	</div>

    <div class="row">
        <?php echo $form->hiddenField($model,'registry_id'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->