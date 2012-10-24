<?php

/**
 * This is the model class for table "{{registry}}".
 *
 * The followings are the available columns in table '{{registry}}':
 * @property integer $id
 * @property string $title
 * @property integer $event_date
 * @property string $image
 * @property string $image_thumb
 * @property string $message
 * @property string $email
 * @property string $mobile_phone
 * @property string $home_phone
 * @property string $address
 * @property integer $created_by
 * @property integer $created_date
 * @property integer $modified_by
 * @property integer $modified_date
 */
class Registry extends BespokeRegistryActiveRecord
{
    var $file;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Registry the static model class
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
		return '{{registry}}';
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
			array('owner_id, event_date, status_id, created_by, created_date, modified_by, modified_date', 'numerical', 'integerOnly'=>true),
			array('title, email', 'length', 'max'=>100),
			array('image, image_thumb', 'length', 'max'=>255),
			array('mobile_phone, home_phone', 'length', 'max'=>20),
			array('message, address', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, owner_id, event_date, image, image_thumb, message, email, mobile_phone, home_phone, address, first_transaction_notification_sent, created_by, created_date, modified_by, modified_date', 'safe', 'on'=>'search'),
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
            'owner' => array(self::BELONGS_TO, 'YumUser', 'owner_id')
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
            'owner_id' => 'Owner',
			'event_date' => 'Event Date',
			'image' => 'Image',
			'image_thumb' => 'Image Thumb',
			'message' => 'Message',
			'email' => 'Email',
			'mobile_phone' => 'Mobile Phone',
			'home_phone' => 'Home Phone',
			'address' => 'Address',
            'status_id' => 'Status',
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
        $criteria->compare('owner_id',$this->owner_id,true);
		$criteria->compare('event_date',$this->event_date);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('image_thumb',$this->image_thumb,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('mobile_phone',$this->mobile_phone,true);
		$criteria->compare('home_phone',$this->home_phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('status_id',$this->status_id,true);
        $criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_date',$this->modified_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getOwnerOptions(){
        $usersArray = CHtml::listData(YumUser::model()->findAll(array('order' => 'username')),'id','username');
        return $usersArray;
    }

    public function getRegistryOptions(){
        return CHtml::listData(Registry::model()->findAll(array('order' => 'title')),'id','title');
    }

    public function beforeValidate(){
        $this->event_date = strtotime($this->event_date);
        
        return parent::beforeValidate();
    }
    
    public function beforeSave(){
        // START: Save the image
        $filePath = CUploadedFile::getInstance($this,'file');
        if ($filePath){
            $image = Yii::app()->image->load($filePath->tempName);
            $image->resize(400, 400, Image::WIDTH);
            $prefix = time().'_';
            $newFilePath = 'images/registries/'.$prefix.$filePath->name;
            $image->save($newFilePath, false); // or $image->save('images/small.jpg');

            $thumb = Yii::app()->image->load($filePath->tempName);
            $thumb->resize(80, 80, Image::WIDTH);
            $newThumbPath = 'images/registries/thumbs/'.$prefix.$filePath->name;
            $thumb->save($newThumbPath, false); // or $image->save('images/small.jpg');

            $this->image = $newFilePath;
            $this->image_thumb = $newThumbPath;
        }
        // END: Save the image

        return parent::beforeSave();
    }
}