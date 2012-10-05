<?php
$this->menu=array(
    array('label'=>'My Registry', 'url'=>array('registry/update')),
    array('label'=>'My Registry List', 'url'=>array('registryProduct/list')),
    array('label'=>'Order My Gifts', 'url'=>array('/order/process', 'rid'=>$registry->id)),
	array('label'=>'Guest Purchase Report', 'url'=>array('order/index', 'rid' => $registry->id)),
	array('label'=>'Email My Consultant', 'url'=>array('registry/contact', 'id' => $registry->id)),
);
?>

<div class="breadcrumb"><a href="#">Home</a> > <a href="#"> My Registry</a> > <span class="current">Buy a Gift</span></div>

<h2>Order Confirmed</h2>
<p>
    Your order is being approved by our administration staff.<br/>
    You will be notified once the order is approved or if you need to update any quantities on your order.
</p>