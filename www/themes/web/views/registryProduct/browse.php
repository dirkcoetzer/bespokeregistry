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
    <a href="/">Home</a> > <a href="<?php echo $this->createUrl("registry/find"); ?>">Find Registry</a> > <a href="<?php echo $this->createUrl("registry/find", array("rid" => $registry->id)); ?>">Search Results</a> > <span class="current">Buy a Gift</span>
</div>
<h2>Buy a Gift</h2>
<p>Browse the different gift categories by selecting the Choose Gift Category below. You can also choose to Contribute Towards one of the larger gift items. The starred items are the priority gifts. </p>
<p><strong>Once you have selected one or more gifts please click on the checkout tab to proceed.</strong></p>

<?php if (trim($registry->message) != ''){ ?>
<div class="content-outer couple-message">
    <div class="content-inner">
    <p>
        <?php echo nl2br($registry->message); ?>
    </p>
    </div>
</div>
<?php } ?>

<div class="order-checkout">
    <?php if ($_SESSION["Order"][$registry->id]){ ?>
        <a href="<?php echo $this->createUrl("order/summary", array("rid" => $registry->id)); ?>" >Checkout</a>
    <?php } ?>
</div>
<form id="frm-filter" name="frm-filter" action="<?php echo $this->createUrl("registryProduct/browse", array("rid" => $registry->id)); ?>" method="post" >
    <dl id="select-list" class="dropdown">
        <dt><a><span><?php echo ($modelCategory->title ? $modelCategory->title : "Choose Gift Category"); ?></span></a></dt>
        <dd>
            <ul>
                <?php foreach ($categories as $category) { ?>
                    <li><a href="#" rel="<?php echo $category['id']; ?>"><?php echo $category['title']; ?><span class="value"><?php echo $category['id']; ?></span></a></li>
                <?php } ?>
            </ul>
        </dd>
    </dl>
    <input type="hidden" name="category_id" id="category_id" value="<?php $_POST["category_id"]; ?>" />
</form>
<br /><br /><br />
<div class="content-outer find-registry">

    <?php if ($registryProducts){ ?>
        <?php $parent = "" ?>
        <?php $category = "" ?>
        <?php foreach ($registryProducts as $registryProduct){ ?>
            <?php
                $baught_qty = Order::model()->getBoughtRegistryProducts($registryProduct->registry_id, $registryProduct->product_id);
                $contribution_amount = OrderDetails::model()->getTotalContribution($registryProduct->registry_id, $registryProduct->product_id);
            ?>
            <?php if ($parent != $registryProduct->product->category->parent->title){ ?>
                <?php $parent = $registryProduct->product->category->parent->title; ?>
                <div class="category-list-title"><h2><?php echo $parent; ?></h2></div>
            <?php } ?>

            <?php if ($category != $registryProduct->product->category->title){ ?>
                <?php $category = $registryProduct->product->category->title; ?>
                <div class="subcategory-title"><h3><?php echo $category; ?></h3></div>
            <?php } ?>

            <?php if ($registryProduct->contribution_item){ ?>
                <div class="content-inner registry-product-list contribute"> <!-- Start of Product Row Item -->
                	<div class="product-img-wrap">
                    <img src="/<?php echo $registryProduct->product->image_thumb; ?>" alt="<?php echo $registryProduct->product->title; ?>" />
                    </div>
                    <div class="product-details">
                        <?php if ($registryProduct->priority_item){ ?>
                            <span class="priority-rating">Top Priority</span>
                        <?php } ?>
                        <span class="product-title"><?php echo $registryProduct->product->title; ?></span> <br />
                        <span class="product-description"><?php echo $registryProduct->product->description; ?></span> <br />
                        <div class="contribute-price">Price<br /><span class="value">R <?php echo $registryProduct->price; ?></span></div>
                        <div class="contribution">Contributions<br /><span class="value">R <?php echo $contribution_amount; ?></span></div>
                        <?php if ($registryProduct->price > $contribution_amount){ ?>
                            <div class="purchase-qty">Amount<br /><input class="purchase-ammount" id="purchase_qty" name="purchase_qty" value="<?php echo intval($_SESSION["Order"][$registry->id]["OrderDetails"][$registryProduct->product->id]["amount"]); ?>" /></div>
                            <br /><br /><br /><br /><br />
                            <a href="" class="contribute-btn" rel="<?php echo $registryProduct->id; ?>"></a>
                        <?php } ?>
                            <input type="hidden" id="available_qty" name="available_qty" value="<?php echo intval($registryProduct->price - $contribution_amount); ?>" />
                            <br />
                    </div><!-- End Product details -->
                    <div style="clear: both;"></div> 
                </div><!-- End of Product Row Item -->
            <?php }else{ ?>
                <div class="content-inner registry-product-list"> <!-- Start of Product Row Item -->
                	<div class="product-img-wrap">
                    <img src="/<?php echo $registryProduct->product->image_thumb; ?>" alt="<?php echo $registryProduct->product->title; ?>" />
                    </div>
                    <div class="product-details">
                        <?php if ($registryProduct->priority_item){ ?>
                            <span class="priority-rating">Top Priority</span>
                        <?php } ?>
                        <span class="product-title"><?php echo $registryProduct->product->title; ?></span> <br />
                        <span class="product-description"><?php echo $registryProduct->product->description; ?></span> <br />
                        <div class="product-price">Price<br /><span class="value">R <?php echo $registryProduct->price; ?></span></div>
                        <div class="qty-requested">Requested<br /><span class="qty-items-requested"><?php echo $registryProduct->qty_requested; ?></span></div>
                        <div class="qty-baught">Bought<br /><span class="qty-items-baught"><?php echo $baught_qty; ?></span></div>
                        <?php if ($registryProduct->qty_requested > $baught_qty){ ?>
                            <div class="purchase-qty">Purchase Qty<br /><input class="purchase-ammount" id="purchase_qty" name="purchase_qty" value="<?php echo intval($_SESSION["Order"][$registry->id]["OrderDetails"][$registryProduct->product->id]["qty"]); ?>" /></div>
                        
                            <a href="#" class="but-gift-btn" rel="<?php echo $registryProduct->id; ?>">Buy</a>
                        <?php } ?>
                        <input type="hidden" id="available_qty" name="available_qty" value="<?php echo intval($registryProduct->qty_requested - $baught_qty); ?>" />
                        <br />
                    </div><!-- End Product details -->
                    <div style="clear: both;"></div> 
                </div><!-- End of Product Row Item -->
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>
<div style="clear: both;"></div> 
<script type="text/javascript">
    $(".but-gift-btn, .contribute-btn").click(function(e){
        e.preventDefault();

        if (parseInt($(this).parent().find("#purchase_qty").val()) < 1){
            alert("The quantity must be greater than 0.");
            $(this).parent().find("#purchase_qty").focus();
            return true;
        }

        if (parseInt($(this).parent().find("#available_qty").val()) < parseInt($(this).parent().find("#purchase_qty").val())){
            alert("The purchase quantity/amount cannot be larger than the available quantity/amount.");
            $(this).parent().find("#purchase_qty").focus();
            return true;
        }

        var url = "<?php echo $this->createUrl("order/queueOrderDetails"); ?>";
        var data = { rpid: $(this).attr("rel"), qty: $(this).parent().find("#purchase_qty").val() };

        $.post(
          url,
          data,
          function(response){
              // console.log(response);
              
                location.reload();
          },
          'json'
        );

        
        return false;
    });
</script>