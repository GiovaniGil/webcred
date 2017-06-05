<?php
/**
 * Created by PhpStorm.
 * User: Giovani
 * Date: 03/06/2017
 * Time: 13:57
 */


namespace common\components;

use Yii;
use frontend\models\Customer;
//use common\models\Message;
use machour\yii2\notifications\models\Notification as BaseNotification;

class Notification extends BaseNotification
{

    /**
     * A new message notification
     */
    const KEY_NEW_MESSAGE = 'new_message';
    /**
     * A meeting reminder notification
     */
    const KEY_BIRTHDAY_REMINDER = 'birthday_reminder';
    /**
     * No disk space left !
     */
    const KEY_NO_DISK_SPACE = 'no_disk_space';

    /**
     * @var array Holds all usable notifications
     */
    public static $keys = [
        self::KEY_NEW_MESSAGE,
        self::KEY_BIRTHDAY_REMINDER,
        self::KEY_NO_DISK_SPACE,
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        switch ($this->key) {
            case self::KEY_BIRTHDAY_REMINDER:
                $customer = Customer::findOne($this->key_id);
                return '<i class="fa fa-birthday-cake" aria-hidden="true"></i> '. Yii::t('app', 'Birthday of {customer}', [
                    'customer' => explode(' ',$customer->name)[0].' - '.Yii::$app->formatter->asDate($customer->birthday, DATE_DM)
                ]);

            case self::KEY_NEW_MESSAGE:
                return Yii::t('app', 'You got a new message');

            case self::KEY_NO_DISK_SPACE:
                return Yii::t('app', 'No disk space left');
        }
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        switch ($this->key) {
            case self::KEY_BIRTHDAY_REMINDER:
                return Yii::t('app', 'Congratulations!');

            /*case self::KEY_NEW_MESSAGE:
                $message = Message::findOne($this->key_id);
                return Yii::t('app', '{customer} sent you a message', [
                    'customer' => $meeting->customer->name
                ]);

            case self::KEY_NO_DISK_SPACE:
                // We don't have a key_id here
                return 'Please buy more space immediately';*/
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        switch ($this->key) {
            case self::KEY_BIRTHDAY_REMINDER:
                return 'index.php?r=customer/update&id='.$this->key_id;

            case self::KEY_NEW_MESSAGE:
                return ['message/read', 'id' => $this->key_id];

            case self::KEY_NO_DISK_SPACE:
                return 'https://aws.amazon.com/';
        };
    }

}