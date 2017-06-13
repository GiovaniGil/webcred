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
use Exception;
use frontend\controllers\CustomerController;
use frontend\models\Customer;
use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\MultipleImportStrategy;
use Yii;
use yii\console\Controller;
use yii\web\Response;

class ChunksController extends CustomerController {

    public function actionIndex()
    {

        $data = [];
        $numberRowsAffected = 0;

        $fileChunks = glob(Yii::getAlias('@frontend')."/web/*.csv");
        if (sizeof($fileChunks) > 0) {
            $numberRowsAffected = $this->processChunk(array_reverse($fileChunks));
        } else
            $data = ['success' => false, 'msg' => 'Requisição incorreta.'];

    }
}