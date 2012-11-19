<?php

class OrderDetailsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

        private $_order;
        
	/**
	 * @return array action filters
	 */
	public function filters()
	{
            return array(
                'accessControl', // perform access control for CRUD operations
                'orderContext + add list'
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','process'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','setStock', 'add'),
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
		$model=new OrderDetails;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrderDetails']))
		{
			$model->attributes=$_POST['OrderDetails'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Add a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd()
	{
            $model=new OrderDetails;
            $model->order_id = $this->_order->id;
            
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['OrderDetails']))
            {
                $model->attributes=$_POST['OrderDetails'];
                if($model->save())
                    $this->redirect(array('/order/view','id'=>$model->order_id));
            }

            $this->render('add',array(
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

		if(isset($_POST['OrderDetails']))
		{
			$model->attributes=$_POST['OrderDetails'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('OrderDetails');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrderDetails('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrderDetails']))
			$model->attributes=$_GET['OrderDetails'];

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
		$model=OrderDetails::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-details-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionProcess($id){
        // Update the order detail entry
        $orderDetails = OrderDetails::model()->findByPk($id);

        if (RegistryProduct::model()->isContributionItem($orderDetails->order->registry_id, $orderDetails->product_id)){
            $orderDetails->qty = 1;
            $orderDetails->price = $_POST["input_value"];
        }else{
            $orderDetails->qty = $_POST["input_value"];
        }
        $orderDetails->save();

        $creditTotal = (int)Order::model()->getRegistryTotal($orderDetails->order->registry_id);
        $redeemTotal = (int)Order::model()->getOrderTotal($orderDetails->order_id);
        $balance = $creditTotal - $redeemTotal;

        echo json_encode(array(
            'status' => 1,
            'creditTotal' => number_format($creditTotal),
            'redeemTotal' => number_format($redeemTotal),
            'balance' => number_format($balance)
        ));
        
        Yii::app()->end();
    }

    function actionSetStock($id){
        $model = OrderDetails::model()->findByPk($id);
        $model->stock = $_GET["stock"];
        if (!$model->stock){
            if ($model->product->contribution_item)
                $model->price = 0;
            else
                $model->qty = 0;
        }
        $model->save();

        $this->redirect($this->createUrl("order/view/", array("id" => $model->order_id)));
    }
    
    /**
    * Protected method to load the associated Order model class
    * @order_id the primary identifier of the associated model
    * @return object the Order data model based on the primary key
    */
    protected function loadOrder($order_id) {
        //if the order property is null, create it based on input id
        if($this->_order === null){
            $this->_order = Order::model()->findbyPk($order_id);
            if($this->_order === null){
                throw new CHttpException(404,'The requested order does not exist.');
            }
        }

        return $this->_order;
    }

    /**
    * In-class defined filter method, configured for use in the above
    filters() method
    * It is called before the actionCreate() action method is run in
    order to ensure a proper order context
    */
    public function filterOrderContext($filterChain){
        //set the project identifier based on either the GET or POST input
        //request variables, since we allow both types for our actions
        $order_id = null;
        if(isset($_GET['order_id']))
            $order_id = $_GET['order_id'];
        else
            if(isset($_POST['order_id']))
                $order_id = $_POST['order_id'];

        $this->loadOrder($order_id);

        //complete the running of other filters and execute the requested action
        $filterChain->run();
    }
}
