<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property string $title
 * @property integer $category_id
 * @property integer $created_by
 * @property integer $created_date
 * @property integer $modified_by
 * @property integer $modified_date
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class Category extends BespokeRegistryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
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
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('category_id, created_by, created_date, modified_by, modified_date', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, category_id, created_by, created_date, modified_by, modified_date', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'category_id'),
            'parent' => array(self::BELONGS_TO, 'Category', 'category_id'),
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
			'category_id' => 'Parent Category',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_date',$this->modified_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getCategoryOptions($include_root_categories = false){
        $criteria = new CDbCriteria;
        if (!$include_root_categories)
            $criteria->condition = "category_id > 0";

        $criteria->order = "title asc";

        $categoryArray = CHtml::listData(Category::model()->findAll($criteria),'id','title');

        return $categoryArray;
    }

    public function getParentCategoryOptions(){
        $criteria = new CDbCriteria;
        $criteria->condition = "category_id = 0";
        $criteria->order = "title asc";

        $categoryArray = CHtml::listData(Category::model()->findAll($criteria),'id','title');

        return $categoryArray;
    }

    public function beforeSave(){
        if ($this->category_id == "")
            $this->category_id = 0;

        return parent::beforeSave();
    }
}