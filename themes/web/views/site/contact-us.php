<?php
$this->pageTitle=Yii::app()->name . ' | Contact Us';
?>


<?php
$this->menu=array(
    array('label'=>'Book a Consultation', 'url'=>array('site/contact')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>
<div class="breadcrumb"><a href="#">Home</a> > <span class="current">Contact</span></div>

<h2>Contact Us</h2>

<div id="contact-us" class="content-outer" style="margin-bottom: 10px;">
    <div class="content-inner" style="min-height: 720px; ">
        <h2>Find Us</h2>
        <div class="map">
            <iframe
                width="420"
                height="383"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
                src="http://maps.google.co.za/maps?oe=utf-8&amp;client=firefox-a&amp;channel=fflb&amp;q=6+Eyton+Road+Cape+Town&amp;ie=UTF8&amp;hq=&amp;hnear=6+Eyton+Rd,+Claremont,+Cape+Town,+Western+Cape+7708&amp;gl=za&amp;t=m&amp;ll=-33.982727,18.462267&amp;spn=0.027259,0.035963&amp;z=14&amp;output=embed">
            </iframe>
        </div>
        <div class="contact-details">
            <div class="contact-item">
                <h3 class="callus">Our Address</h3>
                <span class="address">6 Eyton Rd<br />Cape Town<br />7708</span>
            </div>
            <div class="contact-item">
                <h3>Call Us</h3>
                <span class="call-us">021 761 3743</span>
                <span class="mobile-num">076 390 7017</span>
            </div>
            <div class="contact-item">
                <h3>Email Us</h3>
                <span class="email-laura"><a href="mailto:laura@bespokeregistry.co.za">Email Laura</a></span>
            </div>
        </div>
        <br class="clear" />
    </div>
</div>
<br class="clear" />