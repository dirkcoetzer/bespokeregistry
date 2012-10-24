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
                Welcome <?php echo $name; ?><br/>
                <br/>
                A new user account has been created for you on Bespoke Registry <br /><br />
                Please click on the link below, or copy and paste it into your browser's address bar, to visit your registry.<br/>
                <a href="<?php echo $this->createAbsoluteUrl("/registry/update"); ?>" ><?php echo $this->createAbsoluteUrl("/registry/update"); ?></a><br/>
                <br/>
                Your login details are:<br/>
                Username: <?php echo $username; ?><br/>
                Password: <?php echo $password; ?><br />
                <br />
                Kind regards,<br/>
                Laura Hau<br/>
            </font>
          </td>
        </tr>
    </table>
</td>

  </tr>
  <tr>
    <td><a href="http://bespokeregistry.co.za/index.php/site/termsandconditions"><img src="http://bespokeregistry.co.za/themes/web/images/mailer-footer.jpg" width="600" height="66" border="0" /></a></td>
  </tr>
</table>
</body>
</html>
