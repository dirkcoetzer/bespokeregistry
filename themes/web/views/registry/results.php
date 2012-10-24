<?php
$this->menu=array(
    array('label'=>'Find a Registry', 'url'=>array('registry/find')),
	array('label'=>'About Us', 'url'=>array('site/about')),
	array('label'=>'Recommended Suppliers', 'url'=>array('site/recommendedSuppliers')),
	array('label'=>'FAQs', 'url'=>array('site/faq')),
	array('label'=>'Terms and Conditions', 'url'=>array('site/termsandconditions')),
);
?>

<div class="breadcrumb">
    <a href="/">Home</a> > <a href="<?php echo $this->createUrl("registry/find"); ?>">Find Registry </a> > <span class="current">Search Results</span>
</div>
<h2>Search Results</h2>
<?php if ($data){ ?>
<p><strong>We've found <?php echo count($data); ?> registries that could match your search. Here they are:</strong></p>
<div class="content-outer search-resluts">
    <div class="content-inner">
        <?php foreach($data as $registry){ ?>
        <div class="search-result">
            <?php if (file_exists($registry->image_thumb)){ ?>
                <img src="/<?php echo $registry->image_thumb; ?>"/>
            <?php }else{ ?>
                <img src="http://bespokeregistry.co.za/images/registries/thumbs/1339884547_defauly-couple-img.jpg" alt="" width="80px" height="80px"/>
            <?php } ?>
            <span class="registry-results-title"><?php echo $registry->title; ?></span><br />
            <span class="wedding-date"><?php echo date("d M Y", $registry->event_date); ?></span>
            <a href="<?php echo $this->createUrl("registryProduct/browse", array("rid" => $registry->id)); ?>" class="view-btn">View</a>
            <div class="clear"></div>   
        </div> <!-- End of Result -->

        <?php } ?>
    </div>
</div>
<?php }else{ ?>
    <p><strong>We've found <?php echo count($data); ?> registries that match your search criteria.</strong></p>
<?php } ?>
<h2>Need to search again?</h2>
<p>Give us a little more info about either the bride or groom and we'll find them for you. Otherwise, call us on 076 390 7017 and we'll sort you out.</p>
<div class="content-outer find-registry">
    <div class="content-inner find-registry-form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'registry-form',
            'enableAjaxValidation'=>false,
        )); ?>
            <label class="firstname">First Name</label>
            <input class="" id="first_name" name="first_name" value="<?php echo $_POST["first_name"]; ?>" />
            <label class="lastname">Last Name</label>
            <input class="" id="last_name" name="last_name" value="<?php echo $_POST["last_name"]; ?>" />

            <input class="search-btn" type="submit">
        <?php $this->endWidget(); ?>
    </div>
</div>
<br class="clear" />