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
    public $csv_number;
    public $expiration_date_year;
    public $expiration_date_month;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('name, card_type, card_number, csv_number, expiration_date_year, expiration_date_month', 'required'),                            
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