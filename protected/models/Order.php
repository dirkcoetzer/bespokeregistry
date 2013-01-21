<?php

/**
 * This is the model class for table "{{order}}".
 *
 * The followings are the available columns in table '{{order}}':
 * @property integer $id
 * @property integer $registry_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_phone
 * @property string $message
 * @property string $email
 * @property integer $status
 * @property integer $created_date
 *
 * The followings are the available model relations:
 * @property OrderDetails[] $orderDetails
 */
class Order extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registry_id, first_name, last_name, mobile_phone, email, city, street, postal_code', 'required'),
			array('registry_id, created_date, gift_wrapping, remain_anonymous', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>50),
			array('mobile_phone', 'length', 'max'=>20),
			array('email', 'length', 'max'=>100),
			array('message, suburb', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registry_id, first_name, last_name, mobile_phone, message, email, street, suburb, city, postal_code, status, created_date, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'registry' => array(self::BELONGS_TO, 'Registry', 'registry_id'),
			'orderDetails' => array(self::HAS_MANY, 'OrderDetails', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'registry_id' => 'Registry',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'mobile_phone' => 'Mobile Phone',
			'message' => 'Message',
			'email' => 'Email',
            'remain_anonymous' => 'Remain Anonymous',
			'status' => 'Status',
			'created_date' => 'Created Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('registry_id',$this->registry_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('mobile_phone',$this->mobile_phone,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_date',$this->created_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /*
     * Retrieve the number of a specific product bought for this registry
     */
    public function getBoughtRegistryProducts($registry_id, $product_id){
        $conn = Yii::app()->db;
        $query = "
        SELECT sum(qty) as qty FROM tbl_order_details
        INNER JOIN tbl_order ON tbl_order.id = tbl_order_details.order_id
        WHERE registry_id = $registry_id AND product_id = $product_id and tbl_order.status = 'processed'
        ";
        
        $res = $conn->createCommand($query)->queryRow();
        
        return intval($res["qty"]);
    }

    protected function beforeValidate(){
        if($this->isNewRecord){
            // set the create date, last updated date and the user doing the creating
            $this->created_date = time();
        }

        return parent::beforeValidate();
    }

    public function getRegistryTotal($registry_id){
        $sql = "SELECT SUM(qty * price) AS total
        FROM tbl_order_details od
        INNER JOIN tbl_order o ON o.id = od.order_id
        WHERE o.registry_id = $registry_id and o.type = 'credit' and status = 'processed' AND od.type in ('purchase','contribution')";

        $res = Yii::app()->db->createCommand($sql)->queryRow();
        
        return $res["total"];
    }

    public function getOrderTotal($order_id){
        $sql = "SELECT SUM(qty * price) AS total
        FROM tbl_order_details od
        WHERE od.order_id = $order_id";

        $res = Yii::app()->db->createCommand($sql)->queryRow();
        
        return $res["total"];
    }

    public function getOrderRegistryProductContributionTotal($order_id, $registry_id, $product_id){
        $sql = "SELECT SUM(price) AS total
        FROM tbl_order_details od
        INNER JOIN tbl_order o ON o.id = od.order_id
        WHERE o.registry_id = $registry_id and o.id = $order_id and od.product_id = $product_id and status = 'processed'";

        $res = Yii::app()->db->createCommand($sql)->queryRow();

        return $res["total"];
    }

    public function getOrderRegistryProductPurchaseTotal($order_id, $registry_id, $product_id){
        $sql = "SELECT SUM(qty) AS total
        FROM tbl_order_details od
        INNER JOIN tbl_order o ON o.id = od.order_id
        WHERE o.registry_id = $registry_id and o.id = $order_id and od.product_id = $product_id";

        $res = Yii::app()->db->createCommand($sql)->queryRow();

        return (int)$res["total"];
    }
    
    public function getMonthOptions(){
        return array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
    }
    
    public function getYearOptions(){
        $year = date("Y", time());
        for ($i = 0; $i < 5; $i++){
            $yearOptions[$year] = $year;
            $year++;
        }
        return $yearOptions;
    }
    
    public function getSessionOrderTotal($order){
        $total = 0;
        if ($order["OrderDetails"]){
            foreach ($order["OrderDetails"] as $orderDetail){
                $total = $total + ($orderDetail["qty"] * $orderDetail["price"]);
            }
        }
        
        return $total;
    }
}