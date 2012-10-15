<div class="view">
    <b><?php echo CHtml::encode($data->product->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->product->image_thumb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_requested')); ?>:</b>
	<?php echo CHtml::encode($data->qty_requested); ?>
	<br />
</div>