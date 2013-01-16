<?php
$this->menu=array(
    array('label'=>'Find a Registry', 'url'=>array('registry/find')),
	array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>
<div class="breadcrumb"><a href="/">Home</a> > <a href="#"> My Registry</a> > <span class="current">Buy a Gift</span></div>

<h2>Order Summary</h2>
<p>Please make sure the details are correct before proceeding to pay for your order.</p>

<table class="order-table" border="0" cellspacing="0" cellpadding="0">

  <?php if ($model->type != 'payment'){ ?>
  <tr class="table-heading pixel-bottom border-right">
    <td colspan="3"><span class="cat-heading">Order Summary Details</span></td>
  </tr>
    <tr class="product-row pixel-bottom">
    <td class="border-right" colspan="3">

    	<div class="order-summary-left-col">
    	<span class="label">Your Name</span><br />
    	<span class="value"><?php echo $model->first_name . " " . $model->last_name; ?></span><br />
    	<span class="label">Your Address</span><br />
    	<span class="value"><?php echo $model->street; ?></span><br />
    	<span class="label">Town</span><br />
    	<span class="value"><?php echo $model->city; ?></span><br />
    	<span class="label">Post Code</span><br />
    	<span class="value"><?php echo $model->postal_code; ?></span>

    	</div>

    	<div class="order-summary-right-col">
            <span class="label">Your Message</span><br />
            <p>
            <?php echo nl2br($model->message); ?>
            </p>
            <br />
    	</div>
  </td>
  </tr>
  <?php } ?>
  <tr class="table-heading pixel-bottom">
    <td><span class="cat-heading">Chosen Gifts</span></td>
    <td>Quantity</td>
    <td>Price</td>
  </tr>
  <?php $orderTotal = 0; ?>
  <?php if ($model->orderDetails){ ?>
      <?php $orderTotal = 0; ?>
        <?php foreach ($model->orderDetails as $orderDetail){ ?>
          <?php $orderTotal = $orderTotal + ($orderDetail->qty * $orderDetail->price); ?>
          <tr class="product-row pixel-bottom">
            <td>
                <img src="/<?php echo $orderDetail->product->image_thumb; ?>" alt="<?php echo $orderDetail->product->title; ?>" width="65px" /><?php echo $orderDetail->product->title; ?><br />
                <?php echo $orderDetail->product->description; ?>
            </td>
            <td><?php echo $orderDetail->qty; ?></td>
            <td>R <?php echo $orderDetail->price; ?></td>
          </tr>
      <?php } ?>
  <?php } ?>

  <?php if ($model->gift_wrapping) { ?>
      <?php $orderTotal = $orderTotal + 20.00; ?>
      <tr class="product-row pixel-bottom">
        <td>Gift Wrapping</td>
        <td>&nbsp;</td>
        <td>R20.00</td>
      </tr>
  <?php } ?>
  <tr class="gift-total pixel-bottom">
    <td colspan="3">Total <span class="total-price">R <?php echo number_format($orderTotal, 2); ?></span></td>
    </tr>
</table>
<form id="vcs-form" name="vcs-form" method="POST" action="https://www.vcs.co.za/vvonline/ccform.asp">
    <input type="hidden" name="p1" value="1688">
    <input type="hidden" name="p2" value="<?php echo $model->id; ?>">
    <input type="hidden" name="p3" value="Contribution to <?php echo $model->registry->title; ?>">
    <input type="hidden" name="p4" value="<?php echo $orderTotal; ?>">
    <input type="hidden" name="p5" value="zar">
    <!-- <input type="hidden" name="p6" value="f"> -->
    <!-- <input type="hidden" name="p7" value="g"> -->
    <!-- <input type="hidden" name="p8" value="h"> -->
    <!-- <input type="hidden" name="p9" value="i"> -->
    <input type="hidden" name="p10" value="<?php echo Yii::app()->request->hostInfo . $this->createUrl("transaction/cancelled", array("order_id" => $model->id)); ?>">
    <!-- <input type="hidden" name="p11" value="k"> -->
    <!-- <input type="hidden" name="p12" value="l"> -->
    <!-- <input type="hidden" name="p13" value="m"> -->
    <!-- <input type="hidden" name="Budget" value="n"> -->
    <!-- <input type="hidden" name="NextOccurDate" value="o"> -->
    <input type="hidden" name="CardholderEmail" value="<?php echo $model->email; ?>">
    <!-- <input type="hidden" name="Hash" value="q"> -->
    <input type="hidden" name="m_1" value="<?php echo $model->id; ?>" />
    <input type="hidden" name="m_2" value="contribution" />
    <!-- <input type="hidden" name="m_3" value="z"> -->
    <!-- <input type="hidden" name="m_4" value="z"> -->
    <!-- <input type="hidden" name="m_5" value="z"> -->
    <!-- <input type="hidden" name="m_6" value="z"> -->
    <!-- <input type="hidden" name="m_7" value="z"> -->
    <!-- <input type="hidden" name="m_8" value="z"> -->
    <!-- <input type="hidden" name="m_9" value="z"> -->
    <!-- <input type="hidden" name="m_10" value="z"> -->
    <!-- <input type="submit" class="proceed float-r" value="Pay by Credit Card"> -->
    <a href="#" id="vcs-submit" class="proceed float-r"></a>
</form>
<br class="clear" />
