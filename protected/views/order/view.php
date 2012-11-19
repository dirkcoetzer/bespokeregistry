<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Order', 'url'=>array('admin')),
    array('label'=>'Reset Order', 'url'=>array('reset', 'id'=>$model->id)),
    array('label'=>'Approve Order', 'url'=>array('approve', 'id'=>$model->id)),
    array('label'=>'Add Product', 'url'=>array('/orderDetails/add', 'order_id'=>$model->id)),
);
?>

<h1>View Order #<?php echo $model->id; ?> <span style="float:right; font-size: 16px; padding-right: 10px; padding-top: 7px;">Current Balance: R <?php echo number_format($balance, 2); ?></span></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'registry_id',
		'first_name',
		'last_name',
		'mobile_phone',
		'message',
		'email',
		'status',
		'created_date',
	),
)); ?>


<h1>Products</h1>
<table>
    <tr>
        <th>
            Image
        </th>
        <th>
            Code
        </th>
        <th>
            Product
        </th>
        <th>
            Qty
        </th>
        <th>
            Price
        </th>
        <th>
            Stock
        </th>
    </tr>
    <?php 
    if ($model->orderDetails){
        foreach ($model->orderDetails as $data){
    ?>
    <tr>
        <td>
            <img src="/<?php echo CHtml::encode($data->product->image_thumb); ?>" alt="" width="80px" style="float: left; padding: 5px" />
        </td>
        <td>
            <?php echo $data->product->sku ?>
        </td>
        <td>
            <?php echo $data->product->title ?>
        </td>
        <td>
            <?php echo $data->qty; ?>
        </td>
        <td style="text-align: right; padding-right: 5px;">
            <?php echo $data->price; ?>
        </td>
        <td>
            <?php
                if ($data->stock){ 
            ?>
            Yes (<a href="<?php echo $this->createUrl("orderDetails/setStock", array('id' => $data->id, 'stock' => 0)); ?>" >No</a>)
            <?php }else { ?>
            No (<a href="<?php echo $this->createUrl("orderDetails/setStock", array('id' => $data->id, 'stock' => 1)); ?>" >Yes</a>)
            <?php
            }
            ?>
        </td>
    </tr>
    <?php
        }
    }
    ?>
</table>
