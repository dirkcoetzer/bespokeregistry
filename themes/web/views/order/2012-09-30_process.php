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

<h2>Order My Gifts</h2>
<p>Below is a copy of your list, detailing the items purchased by your guests and a record of the balance on your wedding list account. If you wish to confirm your order online, please fill in the boxes below to indicate the quantity of items you wish to confirm for order. The balance will reduce as you confirm items.</p>

<div class="content-outer" id="registry-order">
    <div class="content-inner order-calculation">
        <?php
            $creditTotal = (int)Order::model()->getRegistryTotal($registry->id);
            $redeemTotal = (int)Order::model()->getOrderTotal($order->id);
            $balance = $creditTotal - $redeemTotal;
        ?>
        <span class="account-balance">Balance on <br /> Account</span>
        <input id="creditTotal" value="R<?php echo number_format($creditTotal); ?>" class="order-balance" />
        <span class="account-balance">Order <br />Value</span>
        <input id="redeemTotal" value="R<?php echo number_format($redeemTotal); ?>" class="order-balance" />
        <span class="balance">Balance</span>
        <input id="balance" value="R<?php echo number_format($balance); ?>" class="order-balance" readonly />
        <a href="#" class="recalculate"></a>
    </div><!-- End Product details -->
</div>
<?php
    //echo "Order ID: " . $order->id . "<br/>";
    //echo "Registry ID: " . $registry->id . "<br/>";
?>
<table class="order-table" border="0" cellspacing="0" cellpadding="0">
    <?php if ($orderDetails){ ?>
        <?php $parent = "" ?>
        <?php $category = "" ?>
        <?php foreach ($orderDetails as $orderDetail){ ?>
            <?php if (!RegistryProduct::model()->isContributionItem($order->registry_id, $orderDetail->product_id)) { ?>
                <?php if ($parent != $orderDetail->product->category->parent->title){ ?>
                    <?php $parent = $orderDetail->product->category->parent->title; ?>
                        <tr class="table-heading pixel-bottom">
                        <td><span class="cat-heading"><?php echo $parent; ?></span></td>
                        <td>List <br />Quantity</td>
                        <td>Guest <br />Purchases</td>
                        <td>Price</td>
                        <td>Quantity</td>
                    </tr>
                <?php } ?>

                <?php if ($category != $orderDetail->product->category->title){ ?>
                    <?php $category = $orderDetail->product->category->title; ?>
                    <tr class="table-subheading pixel-bottom" >
                        <td><?php echo $category; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>

                <tr class="product-row pixel-bottom">
                    <td><img src="/<?php echo $orderDetail->product->image_thumb; ?>" alt="" width="65"><?php echo $orderDetail->product->title; ?><br />
                    <?php echo $orderDetail->product->description; ?></td>
                    <td><?php echo RegistryProduct::model()->getQtyRequested($registry->id, $orderDetail->product->id); ?></td> <!-- RegistryProduct requested_qty -->
                    <td><?php echo Order::model()->getBoughtRegistryProducts($registry->id, $orderDetail->product->id); ?></td> <!-- OrderDetail sum(qty) -->
                    <td>R<?php echo number_format($orderDetail->price, 0); ?></td> <!-- RegistryProduct requested_qty -->
                    <td>
                        <?php if ($orderDetail->stock){ ?>
                        <form id="frm-<?php echo $orderDetail->id; ?>" action="<?php echo $this->createUrl("orderDetails/process", array("id" => $orderDetail->id)); ?>" method="post" style="padding: 0px;">
                            <input id="input_value" name="input_value" style="text-align: center;" value="<?php echo $orderDetail->qty; ?>" class="order-qty">
                        </form>
                        <?php }else{ ?>
                            <strong>Sold Out</strong>
                        <?php } ?>
                    </td>
                </tr>
            <?php }else { ?>
                <?php if ($parent != $orderDetail->product->category->parent->title){ ?>
                    <?php $parent = $orderDetail->product->category->parent->title; ?>
                    <tr class="table-heading pixel-bottom">
                        <td><span class="cat-heading"><?php echo $parent; ?></span></td>
                        <td>Price</td>
                        <td colspan="2" >Contributions</td>
                        <td>Amount</td>
                    </tr>
                <?php } ?>

                <?php if ($category != $orderDetail->product->category->title){ ?>
                    <?php $category = $orderDetail->product->category->title; ?>
                    <tr class="table-subheading pixel-bottom" >
                        <td><?php echo $category; ?></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td></td>
                    </tr>
                <?php } ?>
                <tr class="product-row pixel-bottom">
                    <td><img src="/<?php echo $orderDetail->product->image_thumb; ?>" alt="" width="65px"><?php echo $orderDetail->product->title; ?> <br />
                    <?php echo $orderDetail->product->description; ?></td>
                    <td>R<?php echo $orderDetail->product->price; ?></td>
                    <td colspan="2">R<?php echo number_format(OrderDetails::model()->getTotalContribution($registry->id, $orderDetail->product->id), 0); ?></td>
                    <td>
                        <?php if ($orderDetail->stock){ ?>
                        <form id="frm-<?php echo $orderDetail->id; ?>" action="<?php echo $this->createUrl("orderDetails/process", array("id" => $orderDetail->id)); ?>" method="post" style="padding: 0px;">
                            R <input id="input_value" name="input_value" style="text-align: center;" value="<?php echo number_format($orderDetail->price, 0); ?>" class="order-contribution-value">
                        </form>
                        <?php }else{ ?>
                            <strong>Sold Out</strong>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</table>

<a href="<?php echo $this->createUrl("order/confirm", array("id" => $order->id)); ?>" class="confirm float-r"></a>
<br class="clear" />
<script type="text/javascript">
    $("form").bind("keypress", function(e) {
      if (e.keyCode == 13) return false;
    });

    $("input").change(function(e){
        e.preventDefault();
        
        var form = $(this).parents('form:first');
        var url = $(form).attr("action");
        var data = $(form).serialize();
        
        $.post(
          url,
          data,
          function(response){
            // console.log(response);
            // alert(response.status);
            $('#creditTotal').val('R' + response.creditTotal);
            $('#redeemTotal').val('R' + response.redeemTotal);
            $('#balance').val('R' + response.balance);
            
            // location.reload();
          },
          'json'
        );

        return true;
    });
</script>