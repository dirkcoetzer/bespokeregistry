<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class OrderCheckoutForm extends CFormModel
{
    public $name;
    public $card_type;
    public $card_number;
    public $cvv_number;
    public $expiration_date_year;
    public $expiration_date_month;
    public $order_id;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('name, card_type, card_number, cvv_number, expiration_date_year, expiration_date_month', 'required'),                            
            array('order_id', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name'=>'Name on Card',
            'first_name'=>'Card Type',
            'last_name'=>'Card Number',
            'mobile_phone'=>'CSV Number',            
        );
    }
}
