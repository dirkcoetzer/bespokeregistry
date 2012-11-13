<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $this->pageTitle; ?></title>
    <link rel='shortcut icon' href='<?php echo Yii::app()->theme->baseUrl; ?>/images/favicon.ico' type='image/x-icon' />
<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/script.js');
?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-ui-1.7.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/Gotham_Book_400.font.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jsapi.js"></script>

<link type="text/css"  href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" rel="stylesheet"media="all" />
	<script type="text/javascript">
		Cufon.set('fontFamily', 'Gotham Book').replace('#menu', {hover: true});

        $(document).ready(function() {

            $(".dropdown dt a").click(function() {
                $(".dropdown dd ul").toggle();
            });

            $(".dropdown dd ul li a").click(function() {
                var text = $(this).html();
                $(".dropdown dt a span").html(text);
                $(".dropdown dd ul").hide();

                $("#frm-filter #category_id").val($(this).attr("rel"));

                $("#frm-filter").submit();
            });

            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
            });
            
            // Datepicker
            $('#datepicker').datepicker({
                dateFormat: "d M yy",
                inline: true
            });

    });
    
    
    	//google.load("jquery", "1");
		
		function sticky_relocate() {
		  var window_top = $(window).scrollTop();
		  var div_top = $('#sticky-anchor').offset().top;
		  if (window_top > div_top)
		    $('#registry-order').addClass('stick')
		  else
		    $('#registry-order').removeClass('stick');
		  }
		// If you have jQuery directly, use the following line, instead
		// $(function() {
		// If you have jQuery via Google AJAX Libraries
		google.setOnLoadCallback(function() {
		  $(window).scroll(sticky_relocate);
		  sticky_relocate();
		  });
    
    $(function(){
	$('.fadein img:gt(0)').hide();
	setInterval(function(){$('.fadein :first-child').fadeOut(1200).next('img').fadeIn(1200).end().appendTo('.fadein');}, 4500);
	});
	</script>

</head>
<body>
<div id="navbg">
<div class="dots">
    <div id="wrapper">
    	<div class="beta"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/beta-icon.png" alt="Beta Version" /></div>

        <div id="header">
            <?php if (Yii::app()->user->isGuest){ ?>
                <a href="<?php echo Yii::app()->createUrl("user/user/login"); ?>" class="login"></a>
            <?php } else { ?>
                <a href="<?php echo Yii::app()->createUrl("site/logout"); ?>" class="logout"></a>
            <?php } ?>

            <div id="logo">
                <a href="<?php echo Yii::app()->createUrl(""); ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" alt="Bespoke Registry" /></a>
            </div>
        </div><!-- End Header -->

        <div id="menu">
            <?php
                $this->widget('zii.widgets.CMenu',array(
                    'items'=>array(
                        array('label'=>'Home', 'url'=>array('/site/index')),
                        array('label'=>'How it works', 'url'=>array('/site/howitworks')),
                        //array('label'=>'About Us', 'url'=>array('/site/about')),
                        array('label'=>'Buy a Gift', 'url'=>array('/registry/find')),
                        array('label'=>'My Registry', 'url'=>array('/registryProduct/list')),
                        array('label'=>'Brands & Stores', 'url'=>array('/site/brandsandstores')),
                        array('label'=>'Contact', 'url'=>array('/site/contactUs')),
                        //array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                    ),
                ));
            ?>
        </div> <!-- End Main Nav -->

        <div id="search">
            <form id="search" action="<?php echo $this->createUrl("registry/find"); ?>" method="post" >
                <input type="text" id="term" name="term" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;" value="Search for a registry" class="searchbox" /><input type="submit" class="search" value="Search" />
            </form>
        </div>

        <?php echo $content; ?>

        <div class="clear"></div>

    </div><!-- End Wrapper -->

    <div id="footer-bg">
        <div class="dots">
            <div id="footer">
                <div class="social-links">
                    <a href="https://twitter.com/#!/BespokeRegistry" class="twitter" target="_blank" ></a> <a href="https://www.facebook.com/pages/Bespoke-Wedding-Registry/388594307831155" class="facebook" target="_blank" ></a> <a href="http://pinterest.com/bespokeregistry/" class="pinterest" target="_blank"></a>
                </div>
                <div class="newsletter">
                    <a href="http://eepurl.com/lnCDn" class="sign-up" target="_blank" ></a>
                </div>
                <div class="clear"></div>
                <img style="padding: 25px 0 0 0; margin: 0;" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/payment-logos.png" alt="Secure Payment by VCS" />
                <div class="copyright">
                    <p> &copy;2012 Bespoke  <a href="<?php echo $this->createUrl("site/termsandconditions"); ?>">Terms &amp; Conditions</a>   Site by <a href="http://www.extralarge.co.za" target="_blank" >XL</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
         var _gaq = _gaq || [];
         _gaq.push(['_setAccount', 'UA-33582755-1']);
         _gaq.push(['_trackPageview']);

         (function() {
           var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
           ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
           var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
         })();
    </script>
</body>
</html>
