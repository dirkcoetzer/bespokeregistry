<?php
$this->menu[] = array('label'=>'My Registry', 'url'=>array('registry/update'));
$this->menu[] = array('label'=>'My Registry List', 'url'=>array('registryProduct/list'));
if ($registry->event_date <= time())
    $this->menu[] = array('label'=>'Order My Gifts', 'url'=>array('/order/process', 'rid'=>$registry->id));
$this->menu[] = array('label'=>'Guest Purchase Report', 'url'=>array('order/index', 'rid' => $registry->id));
$this->menu[] = array('label'=>'Email My Consultant', 'url'=>array('registry/contact', 'id' => $registry->id));
?>

<div class="breadcrumb"><a href="#">Home</a> > <span class="current">Buy a Gift</span></div>

<h2>Guest Purchase Report</h2>
<p>Please view the list of guests who purchased gifts below. Email and addresses are included so you know where to send the thank you letters.  Keep track of who you have thanked by checking the tick box next to guest. You can print list too, and that way you don’t get confused by what was given by your guests.</p>

<a href="<?php echo $this->createUrl("order/print", array("rid" => $registry->id)); ?>" class="print" target="_blank" >Print List </a>
<br /><br />
<div class="content-outer guest">
<div class="content-title"><h2>Guests</h2></div>

<?php if ($orders){ ?>
    <?php foreach ($orders as $order){ ?>
        <div class="guest-name">
            <h3><?php echo $order->first_name . " " . $order->last_name; ?></h3>
            <span style="float:right; padding: 7px 14px 0 0;"> 
                <?php if ($order->thank_you_sent){ ?>
                    Thank you sent on <?php echo date("d M Y", $order->thank_you_sent); ?>
                <?php } else { ?>
                    <span style="display: inline-block; float: left;"><input type="checkbox" class="check" value="<?php echo $order->id; ?>"></span> 
                    <span class="thank-you-to-send">Send Thank You</span>
                <?php } ?>
            </span>
        </div>
        <div class="content-inner registry-product-list"> <!-- Start of Guest Entry -->
            <div class="guest-left-col">
                <span class="label">Purchase Date</span><br />
                <span class="value"><?php echo date("d M Y", $order->created_date); ?></span><br />
                
                <span class="label">Email Address</span><br />
                <span class="value"><a href="mailto: <?php echo $order->email; ?>"><?php echo $order->email; ?></a></span><br />
                
                <span class="label">Address</span><br />
                <span class="value"><?php echo $order->street; ?></span><br />
                <span class="value"><?php echo $order->city; ?></span><br />
                <span class="value"><?php echo $order->postal_code; ?></span><br />
                
                
                
                <span class="label">Items Purchased</span><br />
                <span class="value">
                    <?php if ($order->orderDetails){ ?>
                        <?php foreach ($order->orderDetails as $orderDetail){ ?>
                            <?php echo $orderDetail->qty; ?> x  <?php echo $orderDetail->product->title; ?><br />
                        <?php } ?>
                    <?php } ?>
                </span>
            </div>
            <div class="guest-right-col">
                <span class="label">Your Message</span><br />
                <span class="value">
                   <p>
                        <?php echo nl2br($order->message); ?>
                    
                    </p>
                </span><br />
            </div>
           <div style="clear: both;"></div> 
        </div><!-- End of Guest Entry -->

    <?php } ?>
<?php } ?>

<script type="text/javascript">
    $(".thank-you-to-send .check").click(function(e){
        var url = "<?php echo $this->createUrl("order/thankYouSent"); ?>";
        var data = {id : $(this).attr('value')}
        
        $.post(
            url,
            data,
            function(response){
                if (response != '')
                    location.reload();
            }
        );
    });
</script>
</div>
<br class="clear" />