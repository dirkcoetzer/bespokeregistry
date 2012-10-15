<?php
abstract class BespokeRegistryActiveRecord extends CActiveRecord{

    const STATUS_CLOSED = 0;
    const STATUS_OPEN = 1;

    /**
    * Prepares create_time, create_user_id, update_time and update_user_
    id attributes before performing validation.
    */
    protected function beforeValidate(){
        if($this->isNewRecord){
            // set the create date, last updated date and the user doing the creating
            $this->created_date = $this->modified_date = time();
            $this->created_by = $this->modified_by = Yii::app()->user->id;
        }else{
            //not a new record, so just set the last updated time and last updated user id
            $this->modified_date = time();
            $this->modified_by = Yii::app()->user->id;
        }
        return parent::beforeValidate();
    }

    public function getStatusOptions(){
        return array(
            self::STATUS_CLOSED=>'Closed',
            self::STATUS_OPEN=>'Open',
        );
    }

    /**
    * @return string the status text display for the current issue
    */
    public function getStatusText(){
        $statusOptions=$this->getStatusOptions();
        return isset($statusOptions[$this->status_id]) ? $statusOptions[$this->status_id] : "unknown status ({$this->status_id})";
    }
}
