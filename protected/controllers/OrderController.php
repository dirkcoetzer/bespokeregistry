<?php

class OrderController extends Controller
{
    var $_registry = null;
    
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
                'registryContext + create index giftWrapping print process' //check to ensure valid project context
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
				'actions'=>array('view','queueOrderDetails','unQueueOrderDetails','summary','create','cancelled','declined','approved','giftWrapping','thankYouSent', 'print'),
				'users'=>array('*'),
			),
            array(
                'allow',
                'actions'=>array('index', 'process', 'confirm'),
                'users'=>array('@'),
            ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','update','reset','approve'),
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
        $this->layout = "column_left";
        $order = $this->loadModel($id);

        $creditTotal = (int)Order::model()->getRegistryTotal($order->registry->id);
        $redeemTotal = (int)Order::model()->getOrderTotal($order->id);
        $balance = $creditTotal - $redeemTotal;
        
		$this->render('view',array(
			'model'=>$order,
            'balance'=>$balance,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $this->layout = "column_left";
		$model=new Order;

        $model->registry_id = $this->_registry->id;
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if(isset($_POST['Order']))
		{
            $model->attributes=$_POST['Order'];
			if($model->save()){
                // Save the order details from the session.
                if ($_SESSION["Order"][$this->_registry->id]["OrderDetails"]){
                    foreach ($_SESSION["Order"][$this->_registry->id]["OrderDetails"] as $key => $orderDetail){
                        $modelOrderDetails = new OrderDetails();

                        $modelOrderDetails->order_id = $model->id;
                        $modelOrderDetails->product_id = $key;
                        $modelOrderDetails->qty = $orderDetail["qty"];
                        $modelOrderDetails->price = $orderDetail["price"];
                        $modelOrderDetails->type = $orderDetail["type"];

                        $modelOrderDetails->save();
                    }
                }
                // Unset the session here. You can only go one way from here and that is to pay.
                unset($_SESSION["Order"][$this->_registry->id]);
                
				$this->redirect(array('view','id'=>$model->id));
            }
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

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
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
            $this->layout = "column_left";

            $criteria = new CDbCriteria;
            $criteria->condition = "registry_id = " . $this->_registry->id . " and status = 'processed' and type!='redeem' ";
            $orders = Order::model()->findAll($criteria);

            $dataProvider=new CActiveDataProvider('Order');
		$this->render('index',array(
                    'dataProvider'=>$dataProvider,
                    'orders' => $orders,
                    'registry' => $this->_registry,
		));
	}

    /**
	 * Lists all models.
	 */
	public function actionPrint()
	{
        $this->layout = "print";

        $criteria = new CDbCriteria;
        $criteria->condition = "registry_id = " . $this->_registry->id . " and status = 'processed'";
        $orders = Order::model()->findAll($criteria);

        $dataProvider=new CActiveDataProvider('Order');
		$this->render('print',array(
			'dataProvider'=>$dataProvider,
            'orders' => $orders,
            'registry' => $this->_registry,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

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
		$model=Order::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionQueueOrderDetails(){
        $modelRegistryProduct = RegistryProduct::model()->findByPk($_REQUEST["rpid"]);

        if (!$modelRegistryProduct->contribution_item){
            $_SESSION["Order"][$modelRegistryProduct->registry->id]["OrderDetails"][$modelRegistryProduct->product_id] = array(
                'Product' => $modelRegistryProduct->product,
                'qty' => ($_REQUEST['qty'] ? $_REQUEST['qty'] : 1),
                'price' => $modelRegistryProduct->price,
                'type' => ($_REQUEST["type"] ? $_REQUEST["type"] : "purchase"),
                );
        }else{
            $_SESSION["Order"][$modelRegistryProduct->registry->id]["OrderDetails"][$modelRegistryProduct->product_id] = array(
                'Product' => $modelRegistryProduct->product,
                'qty' => 1,
                'price' => $_REQUEST['qty'],
                'type' => 'contribution',
                );
        }
        echo json_encode(array(
            "status" => true,
            "message" => "Your product has been added to your order"
        ));
        
        exit;
    }

    public function actionGiftWrapping(){
        if ($_REQUEST["gift_wrapping"]){
            $product = Product::model()->findByPk(12);
            $_SESSION["Order"][$this->_registry->id]["OrderDetails"][12] = array(
                'Product' => $product,
                'qty' => 1,
                'price' => 20.00,
                'type' => 'wrapping',
            );
            
            $message = "We will be adding gift wrapping to your order.";
        }else{
            unset($_SESSION["Order"][$modelRegistryProduct->registry->id]["OrderDetails"][12]);
            
            $message = "You have chosen not to add gift wrapping to your order.";
        }
        echo json_encode(array(
            "status" => true,
            "message" => $message,
        ));

        exit;
    }

    public function actionUnQueueOrderDetails(){
        unset($_SESSION["Order"][$_REQUEST["rid"]]["OrderDetails"][$_REQUEST["rpid"]]);
        
        exit;
    }

    /**
	 * View a summary of what you have selected.
	 */
	public function actionSummary(){
        $this->layout = "column_left";
        $registry = Registry::model()->findByPk($_GET["rid"]);

        if (count($_SESSION["Order"][$registry->id]["OrderDetails"]) == 0)
            $this->redirect(array('registryProduct/browse','rid'=>$registry->id));

        $this->render(
            'summary',
            array(
                'registry' => $registry
            )
        );
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

    public function actionCancelled(){
        $this->layout = "column_left";

        $this->render("cancelled");
    }

    public function actionApproved(){
        $this->layout = "column_left";

        $this->render("approved");
    }

    public function actionDeclined(){
        $this->layout = "column_left";

        $this->render("declined");
    }

    /*
     * Administrators can approve registries after stock values have been checked.
     */
    public function actionApprove($id){
        $order = Order::model()->findByPk($id);
        
        $creditTotal = (int)Order::model()->getRegistryTotal($order->registry->id);
        $redeemTotal = (int)Order::model()->getOrderTotal($order->id);
        $balance = $creditTotal - $redeemTotal;
        
        if ($balance < 0){
            //Set the status of the order to payment
            $paymentOrder = new Order;
            $paymentOrder->registry_id = $order->registry_id;
            $paymentOrder->status = 'pending';
            $paymentOrder->type = 'payment';
            $paymentOrder->gift_wrapping = 0;
            $paymentOrder->first_name = $order->registry->owner->profile->firstname;
            $paymentOrder->last_name = $order->registry->owner->profile->lastname;
            $paymentOrder->mobile_phone = '';
            $paymentOrder->message = '';
            $paymentOrder->email = $order->registry->owner->profile->email;
            $paymentOrder->remain_anonymous = 0;
            $paymentOrder->street = $order->registry->owner->profile->street;
            $paymentOrder->suburb = '';
            $paymentOrder->city = $order->registry->owner->profile->city;
            $paymentOrder->postal_code = '';
            $paymentOrder->status = 'pending';
            $paymentOrder->thank_you_sent = 0;
            $paymentOrder->type = 'payment';
            $paymentOrder->created_date = time();

            if ($paymentOrder->save(false)){
                $p = Product::model()->findByAttributes(array('title'=>'Cash Payment'));

                $orderDetails = new OrderDetails;
                $orderDetails->order_id = $paymentOrder->id;
                $orderDetails->product_id = $p->id;
                $orderDetails->qty = 1;
                $orderDetails->price = abs($balance);
                $orderDetails->type = 'payment';

                if ($orderDetails->save()){
                    $order->status = "payment";
                    $order->save(false);

                    //Send the payment confirmation to client.
                    Yii::app()->mailer->IsSMTP();
                    Yii::app()->mailer->IsHTML(true);
                    Yii::app()->mailer->Subject = 'Bespoke Registry: Additional payment required to finalize your registry';

                    $params = array(
                        'paymentOrder' => $paymentOrder
                    );
                    $body = Yii::app()->controller->renderPartial("//mail/order_payment", $params, true);

                    if (Yii::app()->params['debugEmails'])
                        Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
                    else
                        Yii::app()->mailer->AddAddress($order->email);

                    Yii::app()->mailer->Body = $body;
                    Yii::app()->mailer->Send();
                }   
            }
        }elseif ($balance > 0){
            $p = Product::model()->findByAttributes(array('title'=>'Voucher'));

            $orderDetails = new OrderDetails;
            $orderDetails->order_id = $order->id;
            $orderDetails->product_id = $p->id;
            $orderDetails->qty = 1;
            $orderDetails->price = abs($balance);
            $orderDetails->type = 'voucher';

            if ($orderDetails->save()){
                // Update the order as processed
                $order->status = "processed";
                $order->save(false);

                // Close the registry
                $r = Registry::model()->findByPk($order->registry_id);
                $r->status_id = 0;
                $r->save();

                //Send the payment confirmation to client.
                Yii::app()->mailer->IsSMTP();
                Yii::app()->mailer->IsHTML(true);
                Yii::app()->mailer->Subject = 'Bespoke Registry: Voucher Notification';

                $params = array(
                    'order' => $order,
                    'balance' => $balance,
                );
                $body = Yii::app()->controller->renderPartial("//mail/order_voucher", $params, true);

                
                Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);

                Yii::app()->mailer->Body = $body;
                Yii::app()->mailer->Send();
            }

        }else{
            // Update the order as processed
            $order->status = "processed";
            $order->save(false);

            // Close the registry
            $r = Registry::model()->findByPk($order->registry_id);
            $r->status_id = 0;
            $r->save();

            //Send the payment confirmation to client.
            Yii::app()->mailer->IsSMTP();
            Yii::app()->mailer->IsHTML(true);
            Yii::app()->mailer->Subject = 'Bespoke Registry: '.$order->registry->title.' has been finalized';

            $params = array(
                'order' => $order,
                'balance' => $balance,
            );
            $body = Yii::app()->controller->renderPartial("//mail/order_finalized", $params, true);


            Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);

            Yii::app()->mailer->Body = $body;
            Yii::app()->mailer->Send();
        }
        
        $this->redirect($this->createUrl("order/view", array("id" => $id)));
        
    }

    public function actionThankYouSent(){
        $model = Order::model()->findByPk($_POST["id"]);
        $model->thank_you_sent = time();
        
        $model->save(false);

        print date("d M Y", $model->thank_you_sent);
        exit;
    }

    public function actionProcess(){
        $this->layout = "column_left";

        // Create the new order
        $criteria = new CDbCriteria;
        $criteria->condition = "registry_id = " . $this->_registry->id . " and type = 'redeem'";
        $modelOrder = Order::model()->find($criteria);
        
        if (!$modelOrder){
            $modelOrder = new Order;

            // Create the new order
            $modelOrder->registry_id = $this->_registry->id;
            $modelOrder->gift_wrapping = 0;
            $modelOrder->type = 'redeem';
            $modelOrder->created_date = time();
            $modelOrder->status = '';
            $modelOrder->first_name = $this->_registry->owner->profile->firstname;
            $modelOrder->last_name = $this->_registry->owner->profile->lastname;
            $modelOrder->mobile_phone = '';
            $modelOrder->message = '';
            $modelOrder->email = $this->_registry->owner->profile->email;
            $modelOrder->remain_anonymous = 0;
            $modelOrder->street = $this->_registry->owner->profile->street;
            $modelOrder->suburb = '';
            $modelOrder->city = $this->_registry->owner->profile->city;
            $modelOrder->postal_code = '';
            $modelOrder->thank_you_sent = 0;

            $modelOrder->save(false);

            // Add the registry productions to the order details.
            $criteria = new CDbCriteria;
            $criteria->condition = "registry_id = " . $this->_registry->id;
            $modelRegistryProduct = RegistryProduct::model()->findAll($criteria);

            foreach ($modelRegistryProduct as $registryProduct){
                $modelOrderDetails = new OrderDetails;

                $modelOrderDetails->order_id = $modelOrder->id;
                $modelOrderDetails->product_id = $registryProduct->product_id;

                $sql = "
                    SELECT *, (
                      SELECT ifnull(SUM(qty), 0) FROM tbl_order_details
                      INNER JOIN tbl_order ON tbl_order.id = tbl_order_details.order_id
                      WHERE tbl_order_details.product_id = tbl_registry_product.product_id
                      AND tbl_order.registry_id = tbl_registry_product.registry_id
                      AND tbl_order.type = 'credit'
                      AND tbl_order.status = 'processed'
                      ) AS guest_purchase_qty
                      ,
                      (
                      SELECT ifnull(SUM(price), 0) FROM tbl_order_details
                      INNER JOIN tbl_order ON tbl_order.id = tbl_order_details.order_id
                      WHERE tbl_order_details.product_id = tbl_registry_product.product_id
                      AND tbl_order.registry_id = tbl_registry_product.registry_id
                      AND tbl_order.type = 'credit'
                      AND tbl_order.status = 'processed'
                      ) AS guest_purchase_amount
                    FROM tbl_registry_product
                    INNER JOIN tbl_product ON tbl_product.id = tbl_registry_product.product_id
                    WHERE registry_id = " . $this->_registry->id . " and product_id = " . $registryProduct->product_id;
                $res = Yii::app()->db->createCommand($sql)->queryRow();

                if ($registryProduct->contribution_item){
                    $modelOrderDetails->qty = 1;
                    $modelOrderDetails->price = $res["guest_purchase_amount"];
                }else{
                    $modelOrderDetails->qty = $res["guest_purchase_qty"];
                    $modelOrderDetails->price = $registryProduct->price;
                }
                $modelOrderDetails->type = 'order';
                $modelOrderDetails->stock = 1;
                
                $modelOrderDetails->save(false);
            }
        }
        
        // Find the user's registry
        $criteria = new CDbCriteria;
        $criteria->addCondition("order_id = " . $modelOrder->id);
        $criteria->order = "parent.title, category.title, t.price desc";
        $orderDetails = OrderDetails::model()->with(array('order', 'product' => array("with" => array("category" => array("order" => "parent.title", "with" => array("parent"))))))->findAll($criteria);
        
        if ($modelOrder->status == 'confirmed'){
            $this->render(
                'confirmed',
                array(
                    'order' => $modelOrder,
                    'orderDetails' => $orderDetails,
                    'registry' => $this->_registry,
                )
            );
        }elseif ($modelOrder->status == 'payment'){
            $this->render(
                'payment',
                array(
                    'order' => $modelOrder,
                    'orderDetails' => $orderDetails,
                    'registry' => $this->_registry,
                )
            );
        }else{
            $this->render(
                'process',
                array(
                    'order' => $modelOrder,
                    'orderDetails' => $orderDetails,
                    'registry' => $this->_registry,
                )
            );
        }
    }

    public function actionConfirm($id){
        $order = Order::model()->findByPk($id);

        $creditTotal = (int)Order::model()->getRegistryTotal($order->registry->id);
        $redeemTotal = (int)Order::model()->getOrderTotal($order->id);
        $balance = $creditTotal - $redeemTotal;

        // Set the order status to confirmed
        $order->status = 'confirmed';
        if ($order->save(false)){
            //Send the confirmation notification to Laura
            Yii::app()->mailer->IsSMTP();
            Yii::app()->mailer->IsHTML(true);
            Yii::app()->mailer->Subject = 'Bespoke Registry: Client Order Confirmation';

            $params = array(
                'order' => $order
            );
            $body = Yii::app()->controller->renderPartial("//mail/order_confirmation", $params, true);
            
            Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
            Yii::app()->mailer->Body = $body;
            Yii::app()->mailer->Send();
        }

        $this->redirect($this->createUrl("/order/process", array('rid' => $order->registry_id)));
    }

    public function actionReset($id){
        $order = Order::model()->findByPk($id);

        $order->status = '';
        if ($order->save(false)){
            //Send the confirmation notification to Laura
            Yii::app()->mailer->IsSMTP();
            Yii::app()->mailer->IsHTML(true);
            Yii::app()->mailer->Subject = 'Bespoke Registry: Update Order Details';

            $params = array(
                'order' => $order
            );
            $body = Yii::app()->controller->renderPartial("//mail/order_update", $params, true);
            
            if (Yii::app()->params['debugEmails'])
                Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
            else
                Yii::app()->mailer->AddAddress($order->email);

            Yii::app()->mailer->Body = $body;
            Yii::app()->mailer->Send();
        }

        $this->redirect($this->createUrl("/order/view", array('id' => $order->id)));
    }

    public function actionFinalizeApprove($id){
        $order = Order::model()->findByPk($id);

        // Set the order status to confirmed
        $order->status = 'finalize approved';
        if ($order->save(false)){
            print "order confirmed";
        }else{
            print_r($order->getErrors());
            print "order unconfirmed";
        }
        exit;

        if ($balance < 0){
            echo "purchase cash product";
            exit;
        }else{
            echo "generate voucher";
            exit;
        }

    }
}

