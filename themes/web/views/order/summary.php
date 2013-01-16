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
  <?php if ($_SESSION["Order"][$registry->id]){ ?>
    <?php $orderTotal = 0; ?>
    <?php foreach ($_SESSION["Order"][$registry->id]["OrderDetails"] as $orderDetail){ ?>
        <?php $orderTotal = $orderTotal + ($orderDetail["qty"] * $orderDetail["price"]); ?>
        <tr class="product-row pixel-bottom">
            <td>
                <img src="/<?php echo $orderDetail["Product"]->image_thumb; ?>" alt="<?php echo $orderDetail["Product"]->title; ?>" width="65px" />
                <?php echo $orderDetail["Product"]->title; ?><br />
                <?php echo $orderDetail["Product"]->description; ?>
            </td>
            <td >
                <a href="#" class="remove" rel="<?php echo $orderDetail["Product"]->id; ?>" >Remove item</a>
            </td>
            <td><?php echo $orderDetail["qty"]; ?></td>
            <td>R <?php echo $orderDetail["price"]; ?></td>
        </tr>
    <?php } ?>
    <?php $_SESSION["Order"][$registry->id]['orderTotal'] = $orderTotal; ?>
  <?php } ?>

    <tr class="gift-wrapping-heading pixel-bottom">
        <td colspan="4">
            Gift Wrapping (optional)
        </td>
    </tr>
    <tr class="gift-wrapping pixel-bottom">
        <td colspan="4">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/gift-wrapping.jpg" alt="">Check the Gift Wrapping option below for beautifully wrapped gifts. 
            The cost of the gift wrapping is R20. <br />
            <br />
            <input type="checkbox" id="gift_wrapping" name="gift_wrapping" value="1" <?php echo ($_SESSION["Order"][$registry->id]["gift_wrapping"] == 1 ? "checked='checked'" : ""); ?> /><label>Please Wrap Gifts</label>
        </td>
    </tr>
    <tr class="gift-total pixel-bottom">
        <td colspan="4">Total <span class="total-price">R <?php echo $orderTotal; ?></span></td>
    </tr>
</table>

<a href="<?php echo $this->createUrl("order/message", array("rid" => $registry->id)); ?>" class="secure-checkout float-r"></a>
<a class="link-continue-shopping float_r" href="<?php echo $this->createUrl("registryProduct/browse", array("rid" => $registry->id)); ?>">Continue Shopping</a>
<br />
<img class="float-l" style="margin: 0 0 0 20px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/payment-logos.png" alt="Payment Options">
<br class="clear" />

</div>
<script type="text/javascript" >
    $("#gift_wrapping").click(function(){
        var url = "<?php echo $this->createUrl("order/giftWrapping", array("rid" => $registry->id)); ?>";
        
        if ($(this).is(":checked")){
            var data = { gift_wrapping: 1 };
        }else{
            var data = { gift_wrapping: 0 };
        }

        $.post(
          url,
          data,
          function(response){
            console.log(response)
          },
          'json'
        );
    });

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
