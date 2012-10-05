<?php $this->beginContent('//layouts/main'); ?>
<div id="page-content" class="clear">
    <?php
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/js/left-column-resize.js');        
    ?>
    <div id="leftCol">
        <?php
			$this->beginWidget('zii.widgets.CPortlet');
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'leftnav'),
			));
			$this->endWidget();
		?>
        <div class="leftColSuppliers">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/pezula-interiors-logo.jpg" alt="pezula-interiors" />
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/l-qrangerie-logo.jpg" alt="l-qrangerie" />
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/le-creuset-logo.jpg" alt="le-creuset" />

        </div>
        <br class="clear" />
    </div>

    <!-- Print the page content -->
    <div id="content" class="search-registry">
        <?php print $content; ?>
        <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
</div> <!-- End Page Wrap -->
<?php $this->endContent(); ?>