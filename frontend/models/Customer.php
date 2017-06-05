<?php

namespace frontend\models;

use asinfotrack\yii2\audittrail\behaviors\AuditTrailBehavior;
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
 * @property string $folder
 */
class Customer extends \yii\db\ActiveRecord
{
    public $file;
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
            [['birthday'], 'safe'],
            [['document'], 'integer'],
            [['observation'], 'string'],
            [['folder'], 'string'],
            [['file'], 'file'],
            [['name', 'agency', 'registry', 'address', 'complement', 'zip_code', 'neighbourhood', 'city', 'state', 'phone1', 'phone2', 'phone3', 'mail', 'customer_password', 'telemarketing'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'name' => Yii::t('frontend', 'Name'),
            'birthday' => Yii::t('frontend', 'Birthday'),
            'document' => Yii::t('frontend', 'Document'),
            'agency' => Yii::t('frontend', 'Agency'),
            'registry' => Yii::t('frontend', 'Registry'),
            'address' => Yii::t('frontend', 'Address'),
            'complement' => Yii::t('frontend', 'Complement'),
            'zip_code' => Yii::t('frontend', 'Zip Code'),
            'neighbourhood' => Yii::t('frontend', 'Neighbourhood'),
            'city' => Yii::t('frontend', 'City'),
            'state' => Yii::t('frontend', 'State'),
            'phone1' => Yii::t('frontend', 'Phone1'),
            'phone2' => Yii::t('frontend', 'Phone2'),
            'phone3' => Yii::t('frontend', 'Phone3'),
            'mail' => Yii::t('frontend', 'Mail'),
            'customer_password' => Yii::t('frontend', 'Customer Password'),
            'observation' => Yii::t('frontend', 'Observation'),
            'telemarketing' => Yii::t('frontend', 'Telemarketing'),
            'folder' => Yii::t('frontend', 'Folder'),
            'file' => Yii::t('frontend','File')
        ];
    }

    public function behaviors()
    {
        return [
            // ...
            'audittrail'=>[
                'class'=>AuditTrailBehavior::className(),

                // some of the optional configurations
                'ignoredAttributes'=>['created_at','updated_at'],
                'consoleUserId'=>1,
                'attributeOutput'=>[
                    'id'=>function ($value) {
                        $model = Customer::findOne($value);
                        return sprintf('%s %s', $model->name, $model->birthday);
                    },
                    'last_checked'=>'datetime',
                ],
            ],
            // ...
        ];
    }


    public static function findByDocument($document){
        $model = Customer::find()->where(['document'=>$document])->one();
        return $model;
    }
}
