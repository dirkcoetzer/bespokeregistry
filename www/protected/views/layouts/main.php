<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<!--div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div-->
		<img style="padding: 0; margin: 0;" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/web/images/admin-header.jpg" alt="Bespoke Admin Area" />
	</div><!-- header -->

    <div id="mainMbMenu">
    <?php $this->widget('application.extensions.mbmenu.MbMenu',array(
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'Admin Options', 'url'=>array('#'),
                  'items'=>array(
                    array('label'=>'Products', 'url'=>array('product/admin'),
                      'items'=>array(
                        array('label'=>'Add Product', 'url'=>array('product/create')),
                        array('label'=>'Manage Products', 'url'=>array('product/admin')),
                      ),
                    ),
                    array('label'=>'Registries', 'url'=>array('registry/admin'),
                      'items'=>array(
                        array('label'=>'Add Registry', 'url'=>array('registry/create')),
                        array('label'=>'Manage Registries', 'url'=>array('registry/admin')),
                      ),
                    ),
                    array('label'=>'Categories', 'url'=>array('category/admin'),
                      'items'=>array(
                        array('label'=>'Add Category', 'url'=>array('category/create')),
                        array('label'=>'Manage Category', 'url'=>array('category/admin')),
                      ),
                    ),
                    array('label'=>'Users', 'url'=>array('/user/user/admin'),
                      'items'=>array(
                        array('label'=>'Add User', 'url'=>array('user/user/create')),
                        array('label'=>'Manage Users', 'url'=>array('user/user/admin')),
                      ),
                    ),
                    array('label'=>'Orders', 'url'=>array('/order/admin'),
                      'items'=>array(
                        array('label'=>'Manage Orders', 'url'=>array('/order/admin')),
                      ),
                    ),
                  ),
                ),
                array('label'=>'Login', 'url'=>array('/user/user/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/user/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
    )); ?>
    </div>

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> Bespoke Registry.<br/>
		All Rights Reserved.<br/>
		<!--?php echo Yii::powered(); ?-->
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>