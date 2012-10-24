<html>
	<body style="margin: 0; padding: 0;">
<div style="width: 100%; background-color: #f1f0ef; margin: 0; padding: 0;">

<table width="700" border="0" cellspacing="0" cellpadding="0" align="center"  bgcolor="#fff">
  <tr>
    <td><a href="http://bespokeregistry.co.za/"><img src="https://bespokeregistry.co.za/themes/web/images/print-header.jpg" width="700" height="155" alt="Bepsoke Registries" border="0" /></a></td>
  </tr>
  <tr>
    <td>
      <table bgcolor="#fff" width="650" border="0" cellspacing="0" cellpadding="15" align="center">
        <tr>
          <td><font face="Georgia, Times New Roman, Times, serif" size="4" color="#333">Guest Purchase Report</font><br /><br />
          	<font face="Georgia, Times New Roman, Times, serif" size="2" color="#333">
          Please view the list of guests who purchased gifts below. Email and addresses are included so you know where to send the thank you letters. 
          Keep track of who you have thanked by checking the tick box next to guest. You can print list too, and that way you don&#39;t get confused by what was given by your guests.
          <br /><br /><br />
          </font>

<table width="650" border="0" cellspacing="0" cellpadding="15" align="center" style="border: 1px solid #d2d2d2;" >
              <tr bgcolor="#E3E3E3">
                <td colspan="2"><font color="#333333" face="Georgia" size="3"><strong>Guests</strong></font></td>
                </tr>               
                <?php if ($orders){ ?>
    <?php foreach ($orders as $order){ ?> 
              <tr bgcolor="#F7F7F7">
                <td colspan="2"><font color="#333333" face="Georgia" size="3">
                	<?php echo $order->first_name . " " . $order->last_name; ?>
                	</font>
                	<font color="#333333" face="Georgia" size="2">
                	<span style="text-align: right; float: right;"> 
                <?php if ($order->thank_you_sent){ ?>
                    Thank you sent on <?php echo date("d M Y", $order->thank_you_sent); ?>
                <?php } else { ?>
                    <input type="checkbox" class="check" value="<?php echo $order->id; ?>"> Thank you sent
                <?php } ?>
            </span>
               </font>	
                </td>
                </tr>
              <tr valign="top" bgcolor="#E3E3E3">
                <td  width="45%">
               <font color="#333333" face="Georgia" size="2"> <strong>Purchase Date</strong><br />
                <?php echo date("d M Y", $order->created_date); ?><br /><br />

                 <strong>Email Address</strong><br />
                <?php echo $order->email; ?><br /><br />
                <strong>Address</strong><br />
                <?php echo $order->street; ?><br />
                <?php echo $order->city; ?><br />
                <?php echo $order->postal_code; ?><br /><br />
                <strong>Items Purchased</strong><br />
                    <?php if ($order->orderDetails){ ?>
                        <?php foreach ($order->orderDetails as $orderDetail){ ?>
                            <?php echo $orderDetail->qty; ?> x  <?php echo $orderDetail->product->title; ?><br />
                        <?php } ?>
                    <?php } ?>
                </font>
                </td>
                <td width="55%" style="border-left: 1px solid #d2d2d2;">
                	<font color="#333333" face="Georgia" size="2"><strong>Your Message</strong><br />
					 <font color="#333333" face="Georgia" size="2"><?php echo nl2br($order->message); ?></font>
                </td>
              </tr>
    <?php } ?>
<?php } ?>
            </table>
            <br /><br /></td>
        </tr>
    </table>
</td>
  
  </tr>
  <tr>
    <td align="center"> <img src="https://bespokeregistry.co.za/themes/web/images/invoice-footer.jpg" border="0" height="42" width="559" /><br />
   <font face="Georgia" color="#3b3a3a" size="2"> &copy;2012 Bespoke  <a style="color:#886b3e;" href="https://bespokeregistry.co.za/index.php/site/termsandconditions">
   	Terms & Conditions</a></font><br /> <br /><br /></td>

  </tr>
</table>

</div>

</body></html>