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

<h2>Order: Additional Payment Required</h2>
<p>
    Your order has been approved by our administration staff.<br/>
    An additional payment needs to be made before your order can be finalized.<br/>
    Please check your email for the notification email.
</p>