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
            <?php echo $form->labelEx($model,'contribution_item'); ?>
            <?php echo $form->dropDownList($model,'contribution_item',array(0 => "No", 1 => "Yes")); ?>
            <?php echo $form->error($model,'contribution'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'qty_requested'); ?>
		<?php echo $form->textField($model,'qty_requested'); ?>
		<?php echo $form->error($model,'qty_requested'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'priority_item'); ?>
        <?php echo $form->dropDownList($model,'priority_item', array(0 => "No", 1 => "Yes")); ?>
        <?php echo $form->error($model,'priority_item'); ?>
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

<script type="text/javascript">
    $("#RegistryProduct_product_id").change(function(e){
        var product_id = $(this).val();
        
        var url = "<?php echo $this->createUrl("product/ajaxFind"); ?>/" + product_id;
        
        $.get(
          url,
          function(response){
              $("#RegistryProduct_price").val(response.price);
              $("#RegistryProduct_contribution_item").val(response.contribution_item);
              
               //console.log(response);
          },
          'json'
        );


        return false;
    });
</script>
