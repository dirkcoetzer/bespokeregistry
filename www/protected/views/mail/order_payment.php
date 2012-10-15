<html>
<head>
</head>
<body><table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><a href="http://www.bespokeregistry.co.za/"><img src="http://www.bespokeregistry.co.za/themes/web/images/mailer-head.jpg" width="600" height="136" alt="Bepsoke Registries" border="0" /></a></td>
  </tr>
  <tr bgcolor="#f1f0ef">
    <td>
      <table bgcolor="#f1f0ef" width="600" border="0" cellspacing="0" cellpadding="15" align="center">
        <tr>
          <td>
            <font face="Georgia, Times New Roman, Times, serif" size="2" color="#626262">
                Dear <?php echo $paymentOrder->registry->owner->profile->firstname; ?>, <br/>
                <br/>
                Your order has been approved but requires and additional payment to be made before it can be finalized.<br/>
                <br/>
                Click on the link below to make the payment.<br/>
                <a href="<?php echo $this->createAbsoluteUrl("order/view", array("id" => $paymentOrder->id)); ?>" target="_blank">My Registry - Additional Payment</a><br/>
                <br/>
                If you have any queries please do not hesitate to call or email us.<br/>
                <br/>
                Kind regards,<br/>
                Laura Hau<br/>
                e: <?php echo Yii::app()->params['debugEmails']; ?>
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
