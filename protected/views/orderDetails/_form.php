<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-details-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
            <?php echo $form->labelEx($model,'product_id'); ?>
            <?php echo $form->dropDownList($model,'product_id', Product::model()->getProductOptions(), array("prompt" => "Select a Product")); ?>
            <?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model,'qty'); ?>
            <?php echo $form->textField($model,'qty'); ?>
            <?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model,'price'); ?>
            <?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
            <?php echo $form->error($model,'price'); ?>
	</div>
        
        <div class="row">
            <?php echo $form->labelEx($model,'stock'); ?>
            <?php echo $form->dropDownList($model,'stock',array('1' => 'Yes', '0' => "No")); ?>
            <?php echo $form->error($model,'stock'); ?>
	</div>

	<div class="row buttons">
            <!-- Hidden Fields -->
            <?php echo $form->hiddenField($model,'order_id'); ?>
            <?php echo $form->hiddenField($model,'type',array('value' => 'order')); ?>
            
            <?php echo CHtml::submitButton('Add Product to Order'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script type="text/javascript">
    $("#OrderDetails_product_id").change(function(e){
        var product_id = $(this).val();
        
        var url = "<?php echo $this->createUrl("product/ajaxFind"); ?>/" + product_id;
        
        $.get(
          url,
          function(response){
              $("#OrderDetails_price").val(response.price);
              //$("#OrderDetails_contribution_item").val(response.contribution_item);
              
               //console.log(response);
          },
          'json'
        );


        return false;
    });
</script>
