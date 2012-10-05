<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property integer $sku
 * @property string $title
 * @property string $description
 * @property string $price
 * @property integer $category_id
 * @property string $image
 * @property string $image_thumb
 * @property integer $created_by
 * @property integer $created_date
 * @property integer $modified_by
 * @property integer $modified_date
 *
 * The followings are the available model relations:
 * @property Category $category
 */
class Product extends BespokeRegistryActiveRecord
{
    var $file;
    var $apply_price_recursively;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Product the static model class
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
		return '{{product}}';
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
                    array('sku', 'unique'),
                    array('category_id, contribution_item, created_by, created_date, modified_by, modified_date', 'numerical', 'integerOnly'=>true),
                    array('title, sku', 'length', 'max'=>150),
                    array('price', 'length', 'max'=>10),
                    array('description, image, image_thumb', 'length', 'max'=>255),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('id, sku, title, description, price, contribution_item, category_id, image, image_thumb, created_by, created_date, modified_by, modified_date', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
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
			'price' => 'Price',
            'contribution_item' => 'Contribution Item',
			'category_id' => 'Category',
			'image' => 'Image',
			'image_thumb' => 'Image Thumb',
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
		$criteria->compare('price',$this->price,true);
        $criteria->compare('contribution_item',$this->contribution_item,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('image_thumb',$this->image_thumb,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_date',$this->modified_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave(){
        // START: Save the image
        $filePath = CUploadedFile::getInstance($this,'file');
        if ($filePath){
            $image = Yii::app()->image->load($filePath->tempName);
            $image->resize(400, 400, Image::WIDTH);
            $prefix = time().'_';
            $newFilePath = 'images/products/'.$prefix.$filePath->name;
            $image->save($newFilePath, false); // or $image->save('images/small.jpg');
            
            $thumb = Yii::app()->image->load($filePath->tempName);
            $thumb->resize(180, 180, Image::WIDTH);
            $newThumbPath = 'images/products/thumbs/'.$prefix.$filePath->name;
            $thumb->save($newThumbPath, false); // or $image->save('images/small.jpg');

            $this->image = $newFilePath;
            $this->image_thumb = $newThumbPath;
        }
        // END: Save the image

        return parent::beforeSave();
    }

    public function getProductOptions(){
        return CHtml::listData(Product::model()->findAll(array('order' => 'title')),'id','title');
    }
}