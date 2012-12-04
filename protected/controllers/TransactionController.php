<?php

class TransactionController extends Controller
{
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
				'actions'=>array('index','view', 'approved', 'declined', 'cancelled'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
		$model=new Transaction;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
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
		$dataProvider=new CActiveDataProvider('Transaction');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Transaction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transaction']))
			$model->attributes=$_GET['Transaction'];

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
		$model=Transaction::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionApproved(){
        $this->layout = "column_left";
            
        $modelOrder = Order::model()->findByPk($_REQUEST["m_1"]);
        if (!$modelOrder)
            throw new CHttpException(404,'The requested order does not exist.');

        $modelOrder->status = 'processed';
        $modelOrder->save();

        //Check if this was a client payment
        if ($modelOrder->type == 'payment'){
            $o = Order::model()->findByAttributes(array('registry_id' => $modelOrder->registry_id, 'type' => 'redeem', 'status' => 'payment'));
            if ($o){
                $o->status = 'processed';
                $o->save(false);
            }

            $r = Registry::model()->findByPk($modelOrder->registry_id);
            if ($r){
                $r->status_id = 0;
                $r->save(false);
            }
        }

        // Send the guest invoice to the guest
        Yii::app()->mailer->IsSMTP();
        Yii::app()->mailer->IsHTML(true);
        Yii::app()->mailer->Subject = 'Bespoke Registry: Purchase Invoice';

        $params = array(
            'order' => $modelOrder,
            'maskedCardNumber' => $_GET['MaskedCardNumber'],
        );
        $body = Yii::app()->controller->renderPartial("//mail/guest_invoice", $params, true);
        if (Yii::app()->params['debugEmails'] || $modelOrder->email == "")
            Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
        else
            Yii::app()->mailer->AddAddress($modelOrder->email);
        
        Yii::app()->mailer->Body = $body;
        Yii::app()->mailer->Send();

        // Send the notification email to the couple
        Yii::app()->mailer->clearAddresses();
        Yii::app()->mailer->IsSMTP();
        Yii::app()->mailer->IsHTML(true);
        Yii::app()->mailer->Subject = 'Bespoke Registry: Approved Transaction';

        $params = array(
            'order' => $modelOrder,
        );
        $body = Yii::app()->controller->renderPartial("//mail/approved_transaction", $params, true);
        if (Yii::app()->params['debugEmails'] || $modelOrder->registry->owner->profile->email)
            Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
        else
            Yii::app()->mailer->AddAddress($modelOrder->registry->owner->profile->email);

        Yii::app()->mailer->Body = $body;
        Yii::app()->mailer->Send();
        
        // Send an email to the admin contact with the transaction details.
        $body = Yii::app()->controller->renderPartial("//mail/approved_transaction_admin", $params, true);
        Yii::app()->mailer->clearAddresses();
        Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
        Yii::app()->mailer->Body = $body;
        Yii::app()->mailer->Send();
        
        // Save the transaction data
        $model = new Transaction;
        $model->order_id = $_REQUEST["m_1"];
        $model->type = $_REQUEST["m_2"];
        $model->vcs_terminal_id = $_REQUEST["p1"];
        $model->vcs_reference_number = $_REQUEST["p2"];
        $model->vcs_response = $_REQUEST["p3"];
        $model->vcs_duplicate = $_REQUEST["p4"];
        $model->vcs_cardholder_name = $_REQUEST["p5"];
        $model->vcs_amount = $_REQUEST["p6"];
        $model->vcs_card_type = $_REQUEST["p7"];
        $model->vcs_description_of_goods = $_REQUEST["p8"];
        $model->vcs_cardholder_email_address = $_REQUEST["p9"];
        $model->vcs_budget_period = $_REQUEST["p10"];
        $model->vcs_expiry_date = $_REQUEST["p11"];
        $model->vcs_response_code = $_REQUEST["p12"];
        $model->vcs_personal_authentication_message = $_REQUEST["pam"];
        $model->vcs_m_1 = $_REQUEST["m_1"];
        $model->vcs_m_2 = $_REQUEST["m_2"];
        $model->vcs_m_3 = $_REQUEST["m_3"];
        $model->vcs_m_4 = $_REQUEST["m_4"];
        $model->vcs_m_5 = $_REQUEST["m_5"];
        $model->vcs_m_6 = $_REQUEST["m_6"];
        $model->vcs_m_7 = $_REQUEST["m_7"];
        $model->vcs_m_8 = $_REQUEST["m_8"];
        $model->vcs_m_9 = $_REQUEST["m_9"];
        $model->vcs_m_10 = $_REQUEST["m_10"];
        $model->vcs_cardholder_ip_address = $_REQUEST["CardHolderIpAddr"];
        $model->vcs_masked_card_number = $_REQUEST["MaskedCardNumber"];
        $model->vcs_transaction_type = $_REQUEST["TransactionType"];
        $model->vcs_hash = $_REQUEST["hash"];

        $model->save(false);

        $this->render("approved");
        
    }

    public function actionDeclined(){
        $this->layout = "column_left";

        $modelOrder = Order::model()->findByPk($_REQUEST["m_1"]);
        if (!$modelOrder)
            throw new CHttpException(404,'The requested order does not exist.');

        $modelOrder->status = 'declined';
        $modelOrder->save();

        // Save the transaction data
        $model = new Transaction;
        $model->order_id = $_REQUEST["m_1"];
        $model->type = $_REQUEST["m_2"];
        $model->vcs_terminal_id = $_REQUEST["p1"];
        $model->vcs_reference_number = $_REQUEST["p2"];
        $model->vcs_response = $_REQUEST["p3"];
        $model->vcs_duplicate = $_REQUEST["p4"];
        $model->vcs_cardholder_name = $_REQUEST["p5"];
        $model->vcs_amount = $_REQUEST["p6"];
        $model->vcs_card_type = $_REQUEST["p7"];
        $model->vcs_description_of_goods = $_REQUEST["p8"];
        $model->vcs_cardholder_email_address = $_REQUEST["p9"];
        $model->vcs_budget_period = $_REQUEST["p10"];
        $model->vcs_expiry_date = $_REQUEST["p11"];
        $model->vcs_response_code = $_REQUEST["p12"];
        $model->vcs_personal_authentication_message = $_REQUEST["pam"];
        $model->vcs_m_1 = $_REQUEST["m_1"];
        $model->vcs_m_2 = $_REQUEST["m_2"];
        $model->vcs_m_3 = $_REQUEST["m_3"];
        $model->vcs_m_4 = $_REQUEST["m_4"];
        $model->vcs_m_5 = $_REQUEST["m_5"];
        $model->vcs_m_6 = $_REQUEST["m_6"];
        $model->vcs_m_7 = $_REQUEST["m_7"];
        $model->vcs_m_8 = $_REQUEST["m_8"];
        $model->vcs_m_9 = $_REQUEST["m_9"];
        $model->vcs_m_10 = $_REQUEST["m_10"];
        $model->vcs_cardholder_ip_address = $_REQUEST["CardHolderIpAddr"];
        $model->vcs_masked_card_number = $_REQUEST["MaskedCardNumber"];
        $model->vcs_transaction_type = $_REQUEST["TransactionType"];
        $model->vcs_hash = $_REQUEST["hash"];

        $model->save(false);

        $this->render("declined");
    }

    public function actionCancelled(){
        $this->layout = "column_left";

        $modelOrder = Order::model()->findByPk($_REQUEST["order_id"]);
        if (!$modelOrder)
            throw new CHttpException(404,'The requested order does not exist.');

        $modelOrder->status = 'cancelled';
        $modelOrder->save();

        $this->render("cancelled");
    }
}
