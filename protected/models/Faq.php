<?php

/**
 * This is the model class for table "{{faq}}".
 *
 * The followings are the available columns in table '{{faq}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $created_by
 * @property integer $created_date
 * @property integer $modified_by
 * @property integer $modified_date
 */
class Faq extends BespokeRegistryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Faq the static model class
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
		return '{{faq}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description', 'required'),
			array('status, created_by, created_date, modified_by, modified_date', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, status, created_by, created_date, modified_by, modified_date', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'description' => 'Description',
			'status' => 'Status',
			'created_by' => 'Created By',
			'created_date' => 'Created Date',
			'modified_by' => 'Modified By',
			'modified_date' => 'Modified Date',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_date',$this->modified_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}