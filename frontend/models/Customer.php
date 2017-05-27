<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $name
 * @property date $birthday
 * @property integer $document
 * @property string $agency
 * @property string $registry
 * @property string $address
 * @property string $complement
 * @property string $zip_code
 * @property string $neighbourhood
 * @property string $city
 * @property string $state
 * @property string $phone1
 * @property string $phone2
 * @property string $phone3
 * @property string $mail
 * @property string $customer_password
 * @property string $observation
 * @property string $telemarketing
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'birthday'], 'required'],
            [['birthday'], 'date'],
            [['document'], 'integer'],
            [['observation'], 'string'],
            [['name', 'agency', 'registry', 'address', 'complement', 'zip_code', 'neighbourhood', 'city', 'state', 'phone1', 'phone2', 'phone3', 'mail', 'customer_password', 'telemarketing'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'birthday' => 'Birthday',
            'document' => 'Document',
            'agency' => 'Agency',
            'registry' => 'Registry',
            'address' => 'Address',
            'complement' => 'Complement',
            'zip_code' => 'Zip Code',
            'neighbourhood' => 'Neighbourhood',
            'city' => 'City',
            'state' => 'State',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'phone3' => 'Phone3',
            'mail' => 'Mail',
            'customer_password' => 'Customer Password',
            'observation' => 'Observation',
            'telemarketing' => 'Telemarketing',
        ];
    }

    public static function findByDocument($document){
        $model = Customer::find()->where(['document'=>$document])->one();
        return $model;
    }
}
