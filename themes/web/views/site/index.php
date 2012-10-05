<?php
$this->pageTitle=Yii::app()->name . ' | Home';
?>


<div id="page-content" class="clear">
<div class="intro-copy">
<div id="slideshow">
<div class="fadein">
<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/home-page-img.jpg" alt="Welcome to Bespoke Registry" />
<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/home-page-img2.jpg" alt="Welcome to Bespoke Registry" />
<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/home-page-img3.jpg" alt="Welcome to Bespoke Registry" />
<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/home-page-img4.jpg" alt="Welcome to Bespoke Registry" />
</div>
</div> <!-- End Slideshow -->
        <div class="copy">
            <h2>Create and customise your perfect wedding registry.</h2>
            <p>Bespoke is a personalised wedding registry service that offers you the opportunity to customise your gift selection with a curated collection of the finest brands and stores on offer. Select what you want and where you want it from, and we'll take care of the rest. </p>
            <p>You'll have a wedding registry that’s tailor-made to suit your style, and your guests will have an easy, 
            	secure and effortless way to spoil you for your big day... <a href="<?php echo $this->createUrl("site/howitworks"); ?>">How it Works</a></p>
        </div>
    </div>
    <br class="clear" />
    <hr />

    <div class="content-outer home-booking">
    <div class="content-inner">
        <h2>Bride & Groom</h2>
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/small-curls-img.png" />
        <h3>Start by booking a consultation</h3>
        <a href="<?php echo $this->createUrl("site/contact"); ?>" class="book-now"></a>
        <h3>Returning Bride or Groom?</h3>
        <a href="<?php echo $this->createUrl("registryProduct/list"); ?>">Access your registry here</a>
    </div>

    </div> <!-- End Booking Block -->
    <div class="verticle-devider"></div>
    <div class="content-outer search-block">
    <div class="content-inner">
        <h2>Wedding Guests</h2>
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/small-curls-img.png" alt="image of small curls" />
        <h3>Find a couple's registry</h3>
        <form id="registry-form" action="<?php echo $this->createUrl("registry/find"); ?>" method="post" >
            <input type="text" id="title" name="title" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;" value="First or Last Name (s)" class="search-block">
            <br /><br />
            <a href="#" id="submit-link" class="find-registry"></a>
        </form>
    </div>
    </div> <!-- End Search Block -->

</div> <!-- End Page Wrap -->