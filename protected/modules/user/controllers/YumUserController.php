<?php

Yii::import('application.modules.user.controllers.YumController');
class YumUserController extends YumController {
	public $defaultAction = 'login';

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('index', 'view', 'login'),
					'users'=>array('*'),
					),
				array('allow',
					'actions'=>array('profile', 'logout', 'changepassword', 'passwordexpired', 'delete', 'browse'),
					'users'=>array('@'),
					),
				array('allow',
					'actions'=>array('admin','delete','create','update', 'list', 'assign', 'generateData', 'csv', 'ajaxFind'),
                    'expression' => 'Yii::app()->user->isAdmin()'
					),
				array('allow',
					'actions'=>array('create'),
					'expression' => 'Yii::app()->user->can("user_create")'
					),
				array('allow',
					'actions'=>array('admin'),
					'expression' => 'Yii::app()->user->can("user_admin")'
					),
				array('deny',  // deny all other users
						'users'=>array('*'),
						),
				);
	}

	public function actionGenerateData() {
		if(Yum::hasModule('role'))
			Yii::import('application.modules.role.models.*');
		if(isset($_POST['user_amount'])) {
			for($i = 0; $i < $_POST['user_amount']; $i++) {
				$user = new YumUser();
				$user->username = sprintf('Demo_%d_%d', rand(1, 50000), $i);
				$user->roles = array($_POST['role']);
				$user->password = YumUser::encrypt($_POST['password']);
				$user->createtime = time();
				$user->status = $_POST['status'];

				if($user->save()) {
					if(Yum::hasModule('profile')) {
						$profile = new YumProfile();
						$profile->user_id = $user->id;
						$profile->timestamp = time();
						$profile->privacy = 'protected';
						$profile->email = 'e@mail.de';
						$profile->save();
					} 
				}
			}
		}
		$this->render('generate_data');
	}

	public function actionIndex() {
        // If the user is not logged in, so we redirect to the actionLogin,
		// which will render the login Form

		if(Yii::app()->user->isGuest)
			$this->actionLogin();
		else
			$this->actionList();
	}

	public function actionStats() {
		$this->redirect($this->createUrl('/user/statistics/index'));
	}

	public function actionPasswordExpired()
	{
		$this->actionChangePassword($expired = true);
	}

	public function actionLogin() {
        // Do not show the login form if a session expires but a ajax request
		// is still generated
		if(Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest)
			return false;
		$this->redirect(array('/user/auth'));
	}

	public function actionLogout() {
		$this->redirect(array('//user/auth/logout'));
	}

	public function beforeAction($event) {
		if (Yii::app()->user->isAdmin())
			$this->layout = Yum::module()->adminLayout;
		else
			$this->layout = Yum::module()->layout;
		return parent::beforeAction($event);
	}

	/**
	 * Change password
	 */
	public function actionChangePassword($expired = false) {
		$uid = Yii::app()->user->id;
		if(isset($_GET['id']))
			$uid = $_GET['id'];

		$form = new YumUserChangePassword;
		$form->scenario = 'user_request';

		if(isset($_POST['YumUserChangePassword'])) {
			$form->attributes = $_POST['YumUserChangePassword'];
			$form->validate();

			if(YumUser::encrypt($form->currentPassword) != YumUser::model()->findByPk($uid)->password)
				$form->addError('currentPassword',
						Yum::t('Your current password is not correct'));

			if(!$form->hasErrors()) {
				if(YumUser::model()->findByPk($uid)->setPassword($form->password)) {
					Yum::setFlash('The new password has been saved');
					Yum::log(Yum::t('User {username} has changed his password', array(
									'{username}' => Yii::app()->user->name)));
				}
				else  {
					Yum::setFlash('There was an error saving the password');
					Yum::log(
							Yum::t(
								'User {username} tried to change his password, but an error occured', array(
									'{username}' => Yii::app()->user->name)), 'error');
				}

				$this->redirect(Yum::module()->returnUrl);
			}
		}

		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('changepassword', array(
						'form'=>$form,
						'expired' => $expired));
		else
			$this->render('changepassword', array(
						'form'=>$form,
						'expired' => $expired));
	}

	// Redirects the user to the specified profile
	// if no profile is specified, redirect to the own profile
	public function actionProfile($id = null) {
		$this->redirect(array('//profile/profile/view',
					'id' => $id ? $id : Yii::app()->user->id));
	}


	/**
	 * Displays a User
	 */
	public function actionView()
	{
		$model = $this->loadUser();
		$this->render('view',array(
					'model'=>$model,
					));
	}

	/**
	 * Creates a new User.
	 */
	public function actionCreate() {
		$model = new YumUser;
		if(Yum::hasModule('profile'))
			$profile = new YumProfile;
		$passwordform = new YumUserChangePassword;

		// When opening a empty user creation mask, we most probably want to
		// insert an _active_ user
		if(!isset($model->status))
			$model->status = 1;

		if(isset($_POST['YumUser'])) {
			$model->attributes=$_POST['YumUser'];

			if(Yum::hasModule('role'))
				$model->roles = Relation::retrieveValues($_POST);

			if(Yum::hasModule('profile') && isset($_POST['YumProfile']) )
				$profile->attributes = $_POST['YumProfile'];

			if(isset($_POST['YumUserChangePassword'])) {
				if($_POST['YumUserChangePassword']['password'] == '') {
					$password = YumUser::generatePassword();
					$model->setPassword($password);
					Yum::setFlash(Yum::t('The generated Password is {password}', array(
									'{password}' => $password)));
				} else {
					$passwordform->attributes = $_POST['YumUserChangePassword'];

					if($passwordform->validate())
						$model->setPassword($_POST['YumUserChangePassword']['password']);
				}
			}

			$model->activationKey = YumUser::encrypt(microtime() . $model->password);

			$model->validate();

			if(isset($profile))
				$profile->validate();

			if(!$model->hasErrors()
					&& !$passwordform->hasErrors()) {
				$model->save();
				if(isset($profile)) {
					$profile->user_id = $model->id;
					$profile->save(array('user_id'), false);
				}
				$this->redirect(array('view', 'id'=>$model->id));
			}
		}

		$this->render('create',array(
					'model' => $model,
					'passwordform' => $passwordform,
					'profile' => isset($profile) ? $profile : null,
					));
	}

	public function actionUpdate() {
		$model = $this->loadUser();
		$passwordform = new YumUserChangePassword();

		if(isset($_POST['YumUser'])) {
			$model->attributes = $_POST['YumUser'];
			if(Yum::hasModule('role')) {
				Yii::import('application.modules.role.models.*');
				// Assign the roles and belonging Users to the model
				$model->roles = Relation::retrieveValues($_POST);
			}

			if(Yum::hasModule('profile')) {
				$profile = $model->profile;
                if (!$profile){
                    $profile = new YumProfile;
                }
                
				if(isset($_POST['YumProfile']) )
					$profile->attributes = $_POST['YumProfile'];
			}
            
            // Password change is requested ?
			if(isset($_POST['YumUserChangePassword'])
					&& $_POST['YumUserChangePassword']['password'] != '') {
				$passwordform->attributes = $_POST['YumUserChangePassword'];
				if($passwordform->validate())
					$model->setPassword($_POST['YumUserChangePassword']['password']);
			}

			if(!$passwordform->hasErrors() && $model->save()) {
				$profile->user_id = $model->id;
                $profile->save(array('user_id'), true);
                
				$this->redirect(array('//user/user/view', 'id' => $model->id));
			}
		}

        $profile = $model->profile;
        if (!$profile){
            if(Yum::hasModule('profile'))
                $profile = new YumProfile;
        }

		$this->render('update', array(
					'model'=>$model,
					'passwordform' =>$passwordform,
					'profile' => isset($profile) ? $profile : false,
					));
	}


	/**
	 * Deletes a user
	 */
	public function actionDelete($id = null) {
		if(!$id)
			$id = Yii::app()->user->id;

		$user = YumUser::model()->findByPk($id);

		if(Yii::app()->user->isAdmin()) {
			//This is necesary for handling human stupidity.
			if($user && ($user->id == Yii::app()->user->id)) {
				Yum::setFlash('You can not delete your own admin account');
				$this->redirect(array('//user/user/admin'));
			}

			if($user->delete()) {
				Yum::setFlash('The User has been deleted');
				$this->redirect('user/user/admin');
			}
		} else if(isset($_POST['confirmPassword'])) {
			if($user->encrypt($_POST['confirmPassword']) == $user->password) {
				if($user->delete())
					$this->actionLogout();
				else
					Yum::setFlash('Error while deleting Account. Account was not deleted');
			} else {
				Yum::setFlash('Wrong password confirmation! Account was not deleted');
			}
			$this->redirect(array('//profile/profile/view'));
		}

		$this->render('confirmDeletion', array('model' => $user));
	}



	public function actionBrowse() {
		$search = '';
		if(isset($_POST['search_username']))
			$search = $_POST['search_username'];

		$criteria = new CDbCriteria;

		/*		if(Yum::hasModule('profile')) {
					$criteria->join = 'LEFT JOIN '.Yum::module('profile')->privacysettingTable .' on t.id = privacysetting.user_id';
					$criteria->addCondition('appear_in_search = 1'); 
					} */

		$criteria->addCondition('status = 1 or status = 2 or status = 3');
		if($search) 
			$criteria->addCondition("username = '{$search}'");

		$dataProvider=new CActiveDataProvider('YumUser', array(
					'criteria' => $criteria, 
					'pagination'=>array(
						'pageSize'=>50,
						)));

		$this->render('browse',array(
					'dataProvider'=>$dataProvider,
					'search_username' => $search ? $search : '',
					));
	}

	public function actionList()
	{
		$dataProvider=new CActiveDataProvider('YumUser', array(
					'pagination'=>array(
						'pageSize'=>Yum::module()->pageSize,
						)));

		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionAdmin()
	{
		if(Yum::hasModule('role'))
			Yii::import('application.modules.role.models.*');

		$this->layout = Yum::module()->adminLayout;

		$model = new YumUser('search');

		if(isset($_GET['YumUser']))
			$model->attributes = $_GET['YumUser'];

		$this->render('admin', array('model'=>$model));
	}

	/**
	 * Loads the User Object instance
	 * @return YumUser
	 */
	public function loadUser($uid = 0)
	{
		if($this->_model === null)
		{
			if($uid != 0)
				$this->_model = YumUser::model()->findByPk($uid);
			elseif(isset($_GET['id']))
				$this->_model = YumUser::model()->findByPk($_GET['id']);
			if($this->_model === null)
				throw new CHttpException(404,'The requested User does not exist.');
		}
		return $this->_model;
	}

    public function actionAjaxFind($id){
        header('Content-type: application/json');
        
        $profile = YumProfile::model()->findByAttributes(array("user_id" => $id));
	
        echo CJSON::encode($profile);
        Yii::app()->end();
    }
}
