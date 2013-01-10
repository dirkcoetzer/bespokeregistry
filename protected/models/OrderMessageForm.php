<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class OrderMessageForm extends CFormModel
{
    public $message;
    public $first_name;
    public $last_name;
    public $mobile_phone;
    public $email;
    public $street;
    public $city;
    public $suburb;
    public $postal_code;
    public $gift_wrapping;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('message, first_name, last_name, mobile_phone, email, street, city, suburb, postal_code', 'required'),                            
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'message'=>'Remember me next time',
            'first_name'=>'First Name',
            'last_name'=>'Last Name',
            'mobile_phone'=>'Mobile Phone',
            'email'=>'Email',
            'street'=>'Address',
            'city'=>'City',
            'suburb' => 'Address',
            'postal_code'=>'Postal Code',
        );
    }
}
