<?php

/**
 * This is the model class for table "{{registry_product}}".
 *
 * The followings are the available columns in table '{{registry_product}}':
 * @property integer $id
 * @property integer $registry_id
 * @property integer $product_id
 * @property string $price
 * @property integer $qty_requested
 * @property integer $created_by
 * @property integer $created_date
 * @property integer $modified_by
 * @property integer $modified_date
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Registry $registry
 */
class RegistryProduct extends BespokeRegistryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RegistryProduct the static model class
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
		return '{{registry_product}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registry_id, product_id', 'required'),
			array('registry_id, product_id, contribution_item, qty_requested, priority_item, stock, created_by, created_date, modified_by, modified_date', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registry_id, product_id, price, contribution_item, qty_requested, priority_item, created_by, created_date, modified_by, modified_date', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'registry' => array(self::BELONGS_TO, 'Registry', 'registry_id'),
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
			'product_id' => 'Product',
			'price' => 'Price',
			'qty_requested' => 'Qty Requested',
            'priority_item' => 'Prioirity Item',
			'stock' => 'Stock',
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
		$criteria->compare('registry_id',$this->registry_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('qty_requested',$this->qty_requested);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_date',$this->modified_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    
    public function getCategories($registryId){
        $query = "
            SELECT DISTINCT parent.id, parent.title FROM tbl_category parent
            INNER JOIN (SELECT * FROM tbl_category WHERE category_id != 0) AS category ON category.category_id = parent.id
            INNER JOIN tbl_product product ON product.category_id = category.id
            INNER JOIN tbl_registry_product registry_product ON registry_product.product_id = product.id
            where registry_product.registry_id = " . $registryId;
        $categories = Yii::app()->db->createCommand($query)->queryAll();
        return $categories;
    }

    public function getQtyRequested($registry_id, $product_id){
        $criteria = new CDbCriteria;
        $criteria->addCondition("registry_id = " . $registry_id);
        $criteria->addCondition("product_id = " . $product_id);
        $criteria->limit = 1;

        $res = RegistryProduct::model()->find($criteria);
        return (int)$res->qty_requested;
    }
}