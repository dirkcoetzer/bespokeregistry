<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Bespoke Registry',
    	'theme'=>'web',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
        	'application.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'user' => array(
	          'debug' => false,
        	  'usersTable' => 'tbl_user',
                  'translationTable' => 'tbl_translation',
                  'loginLayout'=>'//layouts/column_left',
                  'passwordRequirements' => array(
                    'minLen' => 4,
                    'maxRepetition' => 2,
                    'minDigits' => 0,
                  ),
        	),        	
        	'profile' => array(
            		'privacySettingTable' => 'tbl_privacy_setting',
	            	'profileFieldsGroupTable' => 'tbl_profile_field_group',
            		'profileFieldsTable' => 'tbl_profile_field',
            		'profileTable' => 'tbl_profile',
            		'profileCommentTable' => 'tbl_profile_comment',
            		'profileVisitTable' => 'tbl_profile_visit',
        	),
	        'role' => array(
            		'rolesTable' => 'tbl_role',
            		'userHasRoleTable' => 'tbl_user_role',
            		'actionTable' => 'tbl_action',
            		'permissionTable' => 'tbl_permission',
        	),
		'registration' => array(
            		'enableRecovery' => true,
        	),
		'admin' => array(
        	),
	),

	// application components
	'components'=>array(
	  'user'=>array(
            'class' => 'application.modules.user.components.YumWebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('//user/user/login'),
          ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		/*
        'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
        // uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bespoker_registry',
			'emulatePrepare' => true,
			'username' => 'bespoker_bespoke',
			'password' => 'tkSChiM.1sS)',
			'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
		),

		'errorHandler'=>array(
		  // use 'site/error' action to display errors
                  'errorAction'=>'site/error',
                ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'image'=>array(
          		'class'=>'application.extensions.image.CImageComponent',
            		// GD or ImageMagick
	            	'driver'=>'GD',
        	),
        	'mailer' => array(
          		'class' => 'application.extensions.mailer.EMailer',
          		'pathViews' => 'application.views.email',
          		'pathLayouts' => 'application.views.email.layouts',
          	),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'laura@bespokeregistry.co.za',
		//'adminEmail'=>'jdvisagie@gmail.com',
		'debugEmails'=>false,
	),
);
