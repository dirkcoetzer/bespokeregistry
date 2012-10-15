<?php

/**
 * This is the model class for table "{{transaction}}".
 *
 * The followings are the available columns in table '{{transaction}}':
 * @property integer $id
 * @property integer $order_id
 * @property string $type
 * @property string $vcs_terminal_id
 * @property string $vcs_reference_number
 * @property string $vcs_response
 * @property string $vcs_duplicate
 * @property string $vcs_cardholder_name
 * @property string $vcs_amount
 * @property string $vcs_card_type
 * @property string $vcs_description_of_goods
 * @property string $vcs_cardholder_email_address
 * @property integer $vcs_budget_period
 * @property string $vcs_expiry_date
 * @property string $vcs_response_code
 * @property string $vcs_personal_authentication_message
 * @property string $vcs_m_1
 * @property string $vcs_m_2
 * @property string $vcs_m_3
 * @property string $vcs_m_4
 * @property string $vcs_m_5
 * @property string $vcs_m_6
 * @property string $vcs_m_7
 * @property string $vcs_m_8
 * @property string $vcs_m_9
 * @property string $vcs_m_10
 * @property string $vcs_cardholder_ip_address
 * @property string $vcs_masked_card_number
 * @property string $vcs_transaction_type
 * @property string $vcs_hash
 */
class Transaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Transaction the static model class
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
		return '{{transaction}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id', 'required'),
			array('order_id, vcs_budget_period', 'numerical', 'integerOnly'=>true),
			array('type, vcs_cardholder_ip_address', 'length', 'max'=>20),
			array('vcs_terminal_id, vcs_duplicate, vcs_amount, vcs_card_type', 'length', 'max'=>10),
			array('vcs_reference_number', 'length', 'max'=>25),
			array('vcs_response, vcs_cardholder_name', 'length', 'max'=>30),
			array('vcs_description_of_goods, vcs_personal_authentication_message, vcs_transaction_type', 'length', 'max'=>50),
			array('vcs_cardholder_email_address, vcs_m_1, vcs_m_2, vcs_m_3, vcs_m_4, vcs_m_5, vcs_m_6, vcs_m_7, vcs_m_8, vcs_m_9, vcs_m_10', 'length', 'max'=>100),
			array('vcs_expiry_date', 'length', 'max'=>4),
			array('vcs_response_code', 'length', 'max'=>2),
			array('vcs_masked_card_number', 'length', 'max'=>16),
			array('vcs_hash', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, type, vcs_terminal_id, vcs_reference_number, vcs_response, vcs_duplicate, vcs_cardholder_name, vcs_amount, vcs_card_type, vcs_description_of_goods, vcs_cardholder_email_address, vcs_budget_period, vcs_expiry_date, vcs_response_code, vcs_personal_authentication_message, vcs_m_1, vcs_m_2, vcs_m_3, vcs_m_4, vcs_m_5, vcs_m_6, vcs_m_7, vcs_m_8, vcs_m_9, vcs_m_10, vcs_cardholder_ip_address, vcs_masked_card_number, vcs_transaction_type, vcs_hash', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'vcs_terminal_id' => 'Vcs Terminal',
			'vcs_reference_number' => 'Vcs Reference Number',
			'vcs_response' => 'Vcs Response',
			'vcs_duplicate' => 'Vcs Duplicate',
			'vcs_cardholder_name' => 'Vcs Cardholder Name',
			'vcs_amount' => 'Vcs Amount',
			'vcs_card_type' => 'Vcs Card Type',
			'vcs_description_of_goods' => 'Vcs Description Of Goods',
			'vcs_cardholder_email_address' => 'Vcs Cardholder Email Address',
			'vcs_budget_period' => 'Vcs Budget Period',
			'vcs_expiry_date' => 'Vcs Expiry Date',
			'vcs_response_code' => 'Vcs Response Code',
			'vcs_personal_authentication_message' => 'Vcs Personal Authentication Message',
			'vcs_m_1' => 'Vcs M 1',
			'vcs_m_2' => 'Vcs M 2',
			'vcs_m_3' => 'Vcs M 3',
			'vcs_m_4' => 'Vcs M 4',
			'vcs_m_5' => 'Vcs M 5',
			'vcs_m_6' => 'Vcs M 6',
			'vcs_m_7' => 'Vcs M 7',
			'vcs_m_8' => 'Vcs M 8',
			'vcs_m_9' => 'Vcs M 9',
			'vcs_m_10' => 'Vcs M 10',
			'vcs_cardholder_ip_address' => 'Vcs Cardholder Ip Address',
			'vcs_masked_card_number' => 'Vcs Masked Card Number',
			'vcs_transaction_type' => 'Vcs Transaction Type',
			'vcs_hash' => 'Vcs Hash',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('vcs_terminal_id',$this->vcs_terminal_id,true);
		$criteria->compare('vcs_reference_number',$this->vcs_reference_number,true);
		$criteria->compare('vcs_response',$this->vcs_response,true);
		$criteria->compare('vcs_duplicate',$this->vcs_duplicate,true);
		$criteria->compare('vcs_cardholder_name',$this->vcs_cardholder_name,true);
		$criteria->compare('vcs_amount',$this->vcs_amount,true);
		$criteria->compare('vcs_card_type',$this->vcs_card_type,true);
		$criteria->compare('vcs_description_of_goods',$this->vcs_description_of_goods,true);
		$criteria->compare('vcs_cardholder_email_address',$this->vcs_cardholder_email_address,true);
		$criteria->compare('vcs_budget_period',$this->vcs_budget_period);
		$criteria->compare('vcs_expiry_date',$this->vcs_expiry_date,true);
		$criteria->compare('vcs_response_code',$this->vcs_response_code,true);
		$criteria->compare('vcs_personal_authentication_message',$this->vcs_personal_authentication_message,true);
		$criteria->compare('vcs_m_1',$this->vcs_m_1,true);
		$criteria->compare('vcs_m_2',$this->vcs_m_2,true);
		$criteria->compare('vcs_m_3',$this->vcs_m_3,true);
		$criteria->compare('vcs_m_4',$this->vcs_m_4,true);
		$criteria->compare('vcs_m_5',$this->vcs_m_5,true);
		$criteria->compare('vcs_m_6',$this->vcs_m_6,true);
		$criteria->compare('vcs_m_7',$this->vcs_m_7,true);
		$criteria->compare('vcs_m_8',$this->vcs_m_8,true);
		$criteria->compare('vcs_m_9',$this->vcs_m_9,true);
		$criteria->compare('vcs_m_10',$this->vcs_m_10,true);
		$criteria->compare('vcs_cardholder_ip_address',$this->vcs_cardholder_ip_address,true);
		$criteria->compare('vcs_masked_card_number',$this->vcs_masked_card_number,true);
		$criteria->compare('vcs_transaction_type',$this->vcs_transaction_type,true);
		$criteria->compare('vcs_hash',$this->vcs_hash,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}