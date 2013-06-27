<?php
class TokenRecord extends CActiveRecord
{
    public static function model()
    {
        return parent::model(__CLASS__);
    }

    public function tableName()
    {
        return 'rest_client';
    }
    
    public function rules()
    {
        return array(
        	array('name, username, password', 'length', 'max'=>50),
			array('name, uri, username, password, token, token_updated, last_checked', 'safe'),
			array('name', 'unique', 'message' => "This name is already exists."),
        );
    }

}