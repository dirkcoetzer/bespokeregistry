<div class="view">
    <div class="actions">
        <a href="<?php echo $this->createUrl("registryProduct/update", array("id" => $data->id)); ?>" >Edit</a> 
        <?php 
        if (Order::model()->getBoughtRegistryProducts($data->registry_id, $data->product_id) == 0){ ?>
        | <a href="<?php echo $this->createUrl("registryProduct/delete", array("id" => $data->id)); ?>" >Remove</a>
        <?php } ?>
    </div>

    <b><?php echo CHtml::encode($data->product->getAttributeLabel('image')); ?>:</b>
	<img src="/<?php echo CHtml::encode($data->product->image_thumb); ?>" alt="" width="80px" style="float: left; padding: 5px" />
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product->title); ?>
	<br />

    <b><?php echo CHtml::encode($data->product->category->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->product->category->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('contribution_item')); ?>:</b>
	<?php echo CHtml::encode($data->contribution_item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_requested')); ?>:</b>
	<?php echo CHtml::encode($data->qty_requested); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('priority_item')); ?>:</b>
	<?php echo CHtml::encode($data->priority_item); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('stock')); ?>:</b>
	<?php echo CHtml::encode($data->stock); ?>
	<br />
</div>