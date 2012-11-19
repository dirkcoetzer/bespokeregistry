<?php

/**
 * This is the model class for table "{{order_details}}".
 *
 * The followings are the available columns in table '{{order_details}}':
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $qty
 * @property string $price
 * @property string $type
 * @property integer $stock
 *
 * The followings are the available model relations:
 * @property Order $order
 */
class OrderDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrderDetails the static model class
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
		return '{{order_details}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, price', 'required'),
			array('order_id, product_id, qty, stock', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			array('type', 'length', 'max'=>12),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, product_id, qty, price, type', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'product_id' => 'Product',
			'qty' => 'Qty',
			'price' => 'Price',
			'type' => 'Type',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getTotalContribution($registry_id, $product_id){
        $query = "
            select sum(price) as total from tbl_order_details
            inner join tbl_order on tbl_order.id = tbl_order_details.order_id
            where registry_id = ".$registry_id." and product_id = ".$product_id." and tbl_order.status = 'processed'";
        $res = Yii::app()->db->createCommand($query)->queryRow();
        
        return intval($res["total"]);
    }
}