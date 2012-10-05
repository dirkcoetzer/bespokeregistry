<?php
    Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/left-column-resize.js');
?>
<div id="page-content" class="clear">
<div id="leftCol">
	<ul id="leftnav"><li><a href="#" class="active">About Us</a></li>
		<li><a href="#">Recommended Suppliers</a></li>
		<li><a href="#">FAQs</a></li>
		<li><a href="#">Terms &amp; Conditions</a></li>
	</ul>
	<div class="leftColSuppliers">
		<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/pezula-interiors-logo.jpg" alt="pezula-interiors" />
		<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/l-qrangerie-logo.jpg" alt="l-qrangerie" />
		<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/le-creuset-logo.jpg" alt="le-creuset" />

	</div>
	<br class="clear" />
</div>
<div id="content">
<div class="breadcrumb"><a href="#">Home</a> > <span class="current">About Us </span></div>
<div class="page-img"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/about-us-page-pic.jpg" alt="About Us" /></div>
<h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
<p>Sed purus augue, tristique id tincidunt et, euismod eu ipsum. Ut elit erat, convallis ac scelerisque nec, ornare eu turpis. Donec ultrices leo ut lectus egestas non rhoncus urna iaculis. Sed ut odio vestibulum odio cursus vulputate sed ac urna. Suspendisse eu felis a odio dignissim ultrices non vitae arcu. Maecenas at mi viverra ante porttitor pulvinar. Integer dui sem, feugiat ut pharetra nec, cursus eu nibh.</p>

<p>Sed tempus imperdiet orci, ac luctus risus vulputate quis. Nullam scelerisque bibendum euismod. Maecenas interdum semper volutpat. Nunc id nibh hendrerit est fringilla molestie vel vel leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
<br />
<h2>What people say about us</h2>
<div id="testimonials" class="content-outer">
<img class="testimonials-icon" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/quote-icon.png" />
<div class="content-inner">
<div class="testimonial">
<p>Maecenas commodo orci sit amet nibh volutpat pulvinar. Suspendisse tortor dui, placerat rhoncus placerat in, pretium et augue. Nunc mollis purus ac elit fermentum molestie. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. </p>
<p><span class="testimonial-name">Jacqueline Bouvier<br />
CEO, Reddam Industries</span></p>
</div>


<div class="testimonial">
<p>Maecenas vitae diam id mi aliquam consequat. Nam velit lorem, auctor eget mollis id, porttitor non elit. Nulla iaculis tincidunt turpis, id lobortis mi accumsan aliquet. Ut accumsan dictum tortor, ac posuere mauris mollis id. Suspendisse ante urna, mollis quis porttitor sed, venenatis eget ligula. </p>
<p><span class="testimonial-name">Ned Flanders<br />
Art Director, Acme Agency</span></p>

</div>
</div>
</div>

<br class="clear" />
</div>


<br class="clear" />


</div> <!-- End Page Wrap -->

<div class="clear"></div>

</div><!-- End Wrapper -->