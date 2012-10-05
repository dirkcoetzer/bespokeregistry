<?php
$this->menu[] = array('label'=>'My Registry', 'url'=>array('registry/update'));
$this->menu[] = array('label'=>'My Registry List', 'url'=>array('registryProduct/list'));
if ($registry->event_date <= time())
    $this->menu[] = array('label'=>'Order My Gifts', 'url'=>array('/order/process', 'rid'=>$registry->id));
$this->menu[] = array('label'=>'Guest Purchase Report', 'url'=>array('order/index', 'rid' => $registry->id));
$this->menu[] = array('label'=>'Email My Consultant', 'url'=>array('registry/contact', 'id' => $registry->id));
?>

<div class="breadcrumb"><a href="/">Home</a> > <span class="current">My Gift Registry</span></div>

<h2>My Gift Registry</h2>
<p>Choose Gift Category to browse through the different options. You can let your guests know which your favourite items are by ticking priority item or remove items if you change your mind. Please note that a gift can no longer be removed from the registry once it has been purchased. Click on the update button below the list to save your new settings. </p>


<form id="frm-filter" name="frm-filter" action="<?php echo $this->createUrl("registryProduct/list"); ?>" method="post" >
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
    <input type="hidden" name="category_id" id="category_id" value="<?php echo $_POST["category_id"]; ?>" />
</form>
<br /><br /><br />
<div class="content-outer find-registry">

    <?php if ($registryProducts){ ?>
        <?php $parent = "" ?>
        <?php $category = "" ?>
        <?php foreach ($registryProducts as $registryProduct){ ?>
            <?php 
                $bought_qty = Order::model()->getBoughtRegistryProducts($registry->id, $registryProduct->product_id);
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
                <div class="content-inner registry-product-list <?php echo ($contribution_amount > $registryProduct->price ? 'bought':''); ?>"> <!-- Start of Product Row Item -->
                    <img src="/<?php echo $registryProduct->product->image_thumb; ?>" alt="<?php echo $registryProduct->product->title; ?>" />
                    <div class="product-details">
                        <?php if ($contribution_amount < 1){ ?>
                            <span class="remove-item"><a href="<?php echo $this->createUrl("registryProduct/delete", array("id" => $registryProduct->id))?>">Remove Item</a></span>
                        <?php } ?>
                        <span class="product-title"><?php echo $registryProduct->product->title; ?></span> <br />
                        <span class="product-description"><?php echo $registryProduct->product->description; ?></span> <br />
                        <div class="contribute-price">Prices<br /><span class="value">R <?php echo $registryProduct->price; ?></span></div>
                        <div class="contribution">Contributions<br /><span class="value">R <?php echo $contribution_amount; ?></span></div>
                        <br /><br /><br /><br /><br />
                    </div><!-- End Product details -->
                    <div style="clear: both;"></div> 
                </div><!-- End of Product Row Item -->
            <?php }else{ ?>
                <div class="content-inner registry-product-list"> <!-- Start of Product Row Item -->
                    <img src="/<?php echo $registryProduct->product->image_thumb; ?>" alt="<?php echo $registryProduct->product->title; ?>" />
                    <div class="product-details">
                        <?php if ($bought_qty < 1){ ?>
                            <span class="remove-item"><a href="<?php echo $this->createUrl("registryProduct/delete", array("id" => $registryProduct->id))?>">Remove Item</a></span>
                        <?php } ?>
                        <span class="product-title"><?php echo $registryProduct->product->title; ?></span> <br />
                        <span class="product-description"><?php echo $registryProduct->product->description; ?></span> <br />
                        <div class="my-product-price">Price<br /><span class="value">R <?php echo $registryProduct->price; ?></span></div>
                        <div class="priority-optional">Priority Item<br /><input type="checkbox" class="priority-item" id="priority_item" value="<?php echo $registryProduct->product_id; ?>" <?php if ($registryProduct->priority_item) echo "checked='checked'"; ?> /></div>
                        <div class="qty-required">Qty Required<br /><input class="purchase-ammount" id="requested_qty" value="<?php echo $registryProduct->qty_requested; ?>" /></div>
                        <div class="items-bought">Bought<br /><span class="value"><?php echo $bought_qty ?></span></div>
                        <a href="#" class="update-btn" rel="<?php echo $registryProduct->id; ?>">Buy</a>
                        <br />
                    </div><!-- End Product details -->
                    <div style="clear: both;"></div> 
                </div><!-- End of Product Row Item -->
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>
<script type="text/javascript">
    $(".update-btn, .contribute-btn").click(function(e){
        e.preventDefault();

        var requested = $(this).parent().find("#requested_qty").val();
        var priority_item = null;
        if ($(this).parent().find("#priority_item").is(":checked")){
            priority_item = 1;
        }else{
            priority_item = 0;
        }

        if (requested < 1){
            alert("The quantity must be greater than 0.");
            $(this).parent().find("#purchase_qty").focus();
            return true;
        }
        var url = "<?php echo $this->createUrl("registryProduct/ajaxUpdate"); ?>";
        var data = { id: $(this).attr("rel"), qty_requested: requested, priority_item: priority_item };

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
<br class="clear" />
