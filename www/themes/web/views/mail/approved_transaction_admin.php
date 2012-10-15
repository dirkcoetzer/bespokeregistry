<html>
<head>
</head>
<body><table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><a href="http://www.bespokeregistry.co.za/"><img src="http://bespokeregistry.co.za/themes/web/images/mailer-head.jpg" width="600" height="136" alt="Bepsoke Registries" border="0" /></a></td>
  </tr>
  <tr bgcolor="#f1f0ef">
    <td>
      <table bgcolor="#f1f0ef" width="600" border="0" cellspacing="0" cellpadding="15" align="center">
        <tr>
          <td>
            <font face="Georgia, Times New Roman, Times, serif" size="2" color="#626262">
                The following order has been successfully processed.<br/>
                <br/>
                Registry:<br/>
                Title: <?php echo $order->registry->title; ?><br/>
                Event Date: <?php echo date("Y-m-d" , $order->registry->event_date); ?><br/>
                <br/>
                Order Details: <br/>
                <?php foreach ($order->orderDetails as $orderDetail){ ?>
                    Product: <?php echo $orderDetail->product->title; ?><br/>
                    Qty: <?php echo $orderDetail->qty; ?><br/>
                    Price: <?php echo $orderDetail->price; ?><br/>
                    <br/>
                <?php } ?>
            </font>
          </td>
        </tr>
    </table>
</td>

  </tr>
  <tr>
    <td><a href="http://bespokeregistry.co.za/index.php/site/termsandconditions"><img src="http://bespokeregistry.co.za/themes/web/images/mailer-footer.jpg" width="600" height="66" border="0" alt="footer image" /></a></td>
  </tr>
</table>
</body>
</html>
