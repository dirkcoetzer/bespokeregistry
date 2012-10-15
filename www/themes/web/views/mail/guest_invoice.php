<html>
<head>
</head>
<body bgcolor="#f1f0ef">
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid #cfcdcd;">
  <tr>
    <td><a href="http://bespokeregistry.co.za/"><img src="https://bespokeregistry.co.za/themes/web/images/mailer-head.jpg" width="600" height="136" alt="Bepsoke Registries" border="0" /></a></td>
  </tr>
  <tr bgcolor="#f1f0ef">
    <td>
      <table bgcolor="#fff" width="600" border="0" cellspacing="0" cellpadding="15" align="center">
        <tr>
          <td>
            <!-- <a href="#"><img border="0" src="https://bespokeregistry.co.za/themes/web/images/print-icon.jpg" align="right" width="103" height="18"></a> -->
            <font face="Georgia" size="2" color="#626262">
            Date:
            <?php echo date("d M Y", $order->created_date); ?><br />
            <?php echo $order->first_name . " " . $order->last_name; ?><br />
            <?php echo $order->street; ?><br />
            <?php echo $order->city; ?><br />
            <?php echo $order->postal_code; ?><br />
            </font>
            <p><font color="#626262" size="2" face="Georgia">Thank you for purchasing the following gift(s) for <?php echo $order->registry->title; ?>.
              </font>
            </p>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" bordercolor="#dcdada">
              <tr bgcolor="#efefef">
                <td width="54%"><font face="Georgia" color="#3b3a3a" size="2"><b>Items Purchased</b></font></td>
                <td width="23%"><font face="Georgia" color="#3b3a3a" size="2"><b>Quantity</b></font></td>
                <td width="23%"><font face="Georgia" color="#3b3a3a" size="2"><b>Unit Price</b></font></td>
              </tr>
              <?php foreach ($order->orderDetails as $orderDetails){ ?>
              <tr>
                <td><?php echo $orderDetails->product->title; ?></td>
                <td><font face="Georgia" color="#3b3a3a" size="2"><?php echo $orderDetails->qty; ?></font></td>
                <td><font face="Georgia" color="#3b3a3a" size="2">R <?php echo $orderDetails->price; ?></font></td>
              </tr>
              <?php } ?>
            </table>
            <font face="Georgia" size="2" color="#626262"><br />
            Transaction via card number: <?php echo $maskedCardNumber; ?>
            <br /><br />
            <?php echo $order->registry->title; ?> will be notified instantly that you have bought them a gift. We will collect all the gifts, wrap them beautifully (if requested) and deliver them directly to <?php echo $order->registry->title; ?>.
            <br /><br />
            If you have any questions at any stage please feel free to contact us by telephone 076 390 7017, or by email (<a style="color:#3b3a3a;" href="mailto: laura@bespokeregsitry.co.za">laura@bespokeregsitry.co.za</a>)
            <br /><br />
            Kind regards,<br />
            Laura Hau
          </font></td>
        </tr>
    </table>
</td>

  </tr>
  <tr bgcolor="#FFFFFF" height="100">
    <td align="center">
    <img src="https://bespokeregistry.co.za/themes/web/images/invoice-footer.jpg" border="0" height="42" width="559" /><br />
   <font face="Georgia" color="#3b3a3a" size="2"> &copy;2012 Bespoke  <a style="color:#886b3e;" href="https://bespokeregistry.co.za/index.php/site/termsandconditions">Terms & Conditions</a></font><br />
    <p></p>

    </td>
  </tr>
</table>
</body>
</html>