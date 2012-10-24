<?php

class RegistryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $contentClass = '';

    /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','find','captcha'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','view','contact'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id = null)
	{
        $registryProductDataProvider = new CActiveDataProvider(
            'RegistryProduct', array(
                'criteria'=>array(
                    'condition'=>'registry_id=:registryId',
                    'params'=>array(':registryId'=>$id),
                ),
                'pagination'=>array(
                    'pageSize'=>10,
                ),
            )
        );

		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'registryProductDataProvider' => $registryProductDataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Registry;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Registry']))
		{
			$model->attributes=$_POST['Registry'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id = null)
	{
        $this->layout = "column_left";

        if (!$id){
            $criteria = new CDbCriteria;
            $criteria->condition = "owner_id = " . Yii::app()->user->id . " and status_id = 1";
            $criteria->order = "event_date asc";
            $registry = Registry::model()->find($criteria);
            $id = $registry->id;
        }
        
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Registry']))
		{
			$model->attributes=$_POST['Registry'];
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			// First delete all the related items
            // Delete Registry Products
            RegistryProduct::model()->deleteAll('registry_id = ' . $id);
            $this->loadModel($id)->delete();
            
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Registry');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Registry('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Registry']))
			$model->attributes=$_GET['Registry'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Registry::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Your registry is not active yet. Please try again later or contact Laura');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='registry-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionFind(){
        $this->layout = "//layouts/column_left";

        if($_POST){
            $criteria = new CDbCriteria();
            if ($_POST["first_name"] != '')
                $criteria->addSearchCondition("title", $_POST["first_name"], true, "OR");
            if ($_POST["last_name"] != '')
                $criteria->addSearchCondition("title", $_POST["last_name"], true, "OR");
            if ($_POST["title"] != '')
                $criteria->addSearchCondition("title", $_POST["title"], true, "OR");
            if ($_POST["term"] != '')
                $criteria->addSearchCondition("title", $_POST["term"], true, "OR");
				
            $criteria->addCondition("status_id = 1");
            $criteria->addCondition("event_date > " . time());
                            
            $data = Registry::model()->findAll($criteria);

            $this->render('results',array(
                'data'=>$data,
            ));
            return;
		}

        $this->render('find');
    }

    /**
	 * Displays the contact page
	 */
	public function actionContact()
	{
        $this->layout = "column_left";
        $modelRegistry = $this->loadModel($_GET["id"]);

		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');

                $this->render("message", array(
                   "messageTitle" => "My Registry Contact",
                   "messageBody" => "An email has been sent to your consultant.",
                   'registry' => $modelRegistry,
                ));
                return;

                //$this->refresh();

			}
		}


		$this->render('contact',array('model'=>$model, 'registry' => $modelRegistry));
	}
}
