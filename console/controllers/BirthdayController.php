<?php
/**
 * Created by PhpStorm.
 * User: Giovani
 * Date: 03/06/2017
 * Time: 20:06
 */

namespace console\controllers;

use common\components\Notification;
use common\models\User;
use frontend\models\Customer;
use Yii;
use yii\console\Controller;

class BirthdayController extends Controller {

    public function actionIndex() {

        $users = User::find()->all();

        $birthdays = Yii::$app->db->createCommand('SELECT aniversarios.* FROM(
                                                        SELECT id, birthday, now() hoje ,  
                                                         /*anos bissextos ok nesta fórmula*/
                                                         (DAYOFYEAR(birthday)-(dayofyear(date_format(birthday,\'%Y-03-01\'))-60))-
                                                          DAYOFYEAR(CURRENT_DATE)-(dayofyear(date_format(CURRENT_DATE,\'%Y-03-01\'))-60) faltam_dias
                                                          FROM webcred.customer) aniversarios LEFT JOIN webcred.notification ON notification.key_id = aniversarios.id
                                                          WHERE aniversarios.faltam_dias > 0 and faltam_dias < 30 and (notification.key_id is null or (year(notification.created_at) != year(CURRENT_DATE)))')->queryAll();

        foreach($users as $user) {
            foreach ($birthdays as $birthday) {
                Notification::success(Notification::KEY_BIRTHDAY_REMINDER, $user['id'], $birthday['id']);
            }
        }
    }
}