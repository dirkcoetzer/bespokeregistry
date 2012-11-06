<?php

class RegistryProductController extends Controller
{
    /**
    * @var private property containing the associated Project model instance.
    */
    private $_registry = null;

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
            'registryContext + create browse' //check to ensure valid project context
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
				'actions'=>array('index','view', 'browse'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','list','ajaxUpdate','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new RegistryProduct;
        $model->registry_id = $this->_registry->id;
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RegistryProduct']))
		{
			$model->attributes=$_POST['RegistryProduct'];
			if($model->save())
				$this->redirect(array('registry/view','id'=>$model->registry_id));
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RegistryProduct']))
		{
			$model->attributes=$_POST['RegistryProduct'];
			if($model->save())
				$this->redirect(array('registry/view','id'=>$model->registry_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    /**
	 * Ajax Updates a particular model.
	 *
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionAjaxUpdate()
	{
        // Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST)){
            $model=$this->loadModel($_POST['id']);

			$model->id = $_POST['id'];
            $model->priority_item = $_POST['priority_item'];
            $model->qty_requested = $_POST['qty_requested'];

			if($model->save()){
				print_r($model->attributes);
            }
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $this->loadModel($id)->delete();

		$this->redirect(Yii::app()->request->getUrlReferrer());
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RegistryProduct');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RegistryProduct('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RegistryProduct']))
			$model->attributes=$_GET['RegistryProduct'];

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
		$model=RegistryProduct::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='registry-product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
    * Protected method to load the associated Registry model class
    * @registry_id the primary identifier of the associated Registry
    * @return object the Registry data model based on the primary key
    */
    protected function loadRegistry($registry_id) {
        //if the project property is null, create it based on input id
        if($this->_registry === null){
            $this->_registry = Registry::model()->findbyPk($registry_id);
            if($this->_registry === null){
                throw new CHttpException(404,'The requested registry does not exist.');
            }
        }

        return $this->_registry;
    }

    /**
    * In-class defined filter method, configured for use in the above
    filters() method
    * It is called before the actionCreate() action method is run in
    order to ensure a proper project context
    */
    public function filterRegistryContext($filterChain){
        //set the project identifier based on either the GET or POST input
        //request variables, since we allow both types for our actions
        $registryId = null;
        if(isset($_GET['rid']))
            $registryId = $_GET['rid'];
        else
            if(isset($_POST['rid']))
                $registryId = $_POST['rid'];

        $this->loadRegistry($registryId);

        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }

    public function actionBrowse(){
        $this->layout = "//layouts/column_left";
        
        $criteria = new CDbCriteria;
        $criteria->condition = "registry_id = " . $this->_registry->id;
        if ($_POST["category_id"]){
            $criteria->condition = $criteria->condition . " and (category.category_id = " . $_POST["category_id"] ." or category.id = " . $_POST["category_id"] . ")";
        
            $modelCategory = Category::model()->findByPk($_POST["category_id"]);
        }
        $criteria->order = "parent.title, category.title, t.price desc";
        $registryProducts = RegistryProduct::model()->with(array('product' => array("with" => array("category" => array("order" => "parent.title", "with" => array("parent"))))))->findAll($criteria);

        $modelRegistryProduct = new RegistryProduct;
        $categories = $modelRegistryProduct->getCategories($this->_registry->id);
        
        $this->render('browse', array(
            "registry" => $this->_registry,
            "registryProducts" => $registryProducts,
            "categories" => $categories,
            "modelCategory" => $modelCategory,
        ));
    }

    public function actionList(){
        $this->layout = "//layouts/column_left";

        $criteria = new CDbCriteria;
        $criteria->condition = "owner_id = " . Yii::app()->user->id . " and status_id = 1";
        $criteria->order = "event_date asc";
        $criteria->limit = 1;
        $registry = Registry::model()->find($criteria);

        if($registry === null){
            throw new CHttpException(404,'Your registry is not active yet. Please try again later or contact Laura');
        }

        // Find the user's registry
        $criteria = new CDbCriteria;
        $criteria->condition = "registry_id = " . $registry->id;
        if (isset($_POST["category_id"])){
            $criteria->condition = $criteria->condition . " and (category.category_id = " . $_POST["category_id"] ." or category.id = " . $_POST["category_id"] . ")";
            
            $modelCategory = Category::model()->findByPk($_POST["category_id"]);
        }
        $criteria->order = "parent.title, category.title, t.price desc";
        $registryProducts = RegistryProduct::model()->with(array('registry', 'product' => array("with" => array("category" => array("order" => "parent.title", "with" => array("parent"))))))->findAll($criteria);

        $modelRegistryProduct = new RegistryProduct;
        $categories = $modelRegistryProduct->getCategories($registry->id);

        $this->render('list', array(
            "registry" => $registry,
            "registryProducts" => $registryProducts,
            "categories" => $categories,
            "modelCategory" => $modelCategory,
        ));
    }
}
