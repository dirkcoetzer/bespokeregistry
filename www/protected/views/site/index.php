<?php $this->pageTitle=Yii::app()->name; ?>

<!--h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1-->
<div style="padding: 20px;" class="admin-dashboard">
<a href="/index.php/registry/admin"><img src="<?php echo Yii::app()->request->baseUrl; ?>/themes/web/images/admin-registries.jpg" alt="Manage Registries" /></a>
<a href="/index.php/product/admin"><img src="<?php echo Yii::app()->request->baseUrl; ?>/themes/web/images/admin-products.jpg" alt="Manage Products" /></a>
<a href="/index.php/category/admin"><img src="<?php echo Yii::app()->request->baseUrl; ?>/themes/web/images/admin-categories.jpg" alt="Manage Categories" /></a>
</div>