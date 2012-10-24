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
                <?php echo $order->registry->owner->profile->firstname . " " . $order->registry->owner->profile->lastname; ?> has confirmed their order.<br/>
                Please log into the site and approve the stock quantities for this order.<br/>
                <a href="<?php echo $this->createAbsoluteUrl("/"); ?>" target="_blank"><?php echo $this->createAbsoluteUrl("/"); ?></a><br/>
                Order ID: <?php echo $order->id; ?><br/>
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
