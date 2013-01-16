<?php
$this->menu=array(
    array('label'=>'Find a Registry', 'url'=>array('registry/find')),
	array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>
<div class="breadcrumb">
    <a href="/">Home</a> > <a href="<?php echo $this->createUrl("registry/find"); ?>">Find Registry</a> > <a href="<?php echo $this->createUrl("registryProduct/browse", array("rid" => $registry->id)); ?>">Search Results</a> > <span class="current">Buy a Gift</span>
</div>

<h2>My Cart</h2>
<p>Your selected gifts will be delivered to the couple after their wedding.  In the unlikely event we cannot obtain a selected gift, the couple may choose an alternative.</p>
<div id="checkout-progress">
<div class="step1 active">1. My Cart</div>
<div class="step2">2. Order Details</div>
<div class="step3">3. My Payment</div>
<div class="step4">4. Confirmation</div>
</div>
<br /><br /><br />

<div style="min-height: 890px;">
<table class="order-table" border="0" cellspacing="0" cellpadding="0">
  <tr class="table-heading pixel-bottom">
    <td><span class="cat-heading">You have selected the following gifts</span></td>
    <td>Remove</td>
    <td>Quantity</td>
    <td>Price</td>
  </tr>
  <?php if ($model){ ?>
    <?php $orderTotal = 0; ?>
    <?php foreach ($model->orderDetails as $orderDetail){ ?>
        <?php $orderTotal = $orderTotal + ($orderDetail->qty * $orderDetail->price); ?>
        <tr class="product-row pixel-bottom">
            <td>
                <img src="/<?php echo $orderDetail->product->image_thumb; ?>" alt="<?php echo $orderDetail->product->title; ?>" width="65px" />
                <?php echo $orderDetail->product->title; ?><br />
                <?php echo $orderDetail->product->description; ?>
            </td>
            <td >
                &nbsp;
            </td>
            <td><?php echo $orderDetail->qty; ?></td>
            <td>R <?php echo $orderDetail->price; ?></td>
        </tr>
    <?php } ?>
  <?php } ?>

    
    <tr class="gift-total pixel-bottom">
        <td colspan="4">Total <span class="total-price">R <?php echo $orderTotal; ?></span></td>
    </tr>
</table>

<a href="<?php echo $this->createUrl("order/checkout", array("id" => $model->id, "rid" => $model->registry->id)); ?>" class="secure-checkout float-r"></a>
<a class="link-continue-shopping float_r" href="<?php echo $this->createUrl("registryProduct/browse", array("rid" => $registry->id)); ?>">Continue Shopping</a>
<br />
<img class="float-l" style="margin: 0 0 0 20px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/payment-logos.png" alt="Payment Options">
<br class="clear" />

</div>
<script type="text/javascript" >

    $(".remove").click(function(e){
        e.preventDefault();
        var url = "<?php echo $this->createUrl("order/unQueueOrderDetails", array("rid" => $registry->id)); ?>";
        var data = {rpid : $(this).attr("rel")};

        $.post(
          url,
          data,
          function(response){
             location.reload();
          },
          'json'
        );
    });

</script>
