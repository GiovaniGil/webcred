<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$this->registerCssFile('/webcred/common/treeview/css/filetree.css');

echo Tabs::widget([
    'items' => [
        [
            'label' => 'Dados do Cliente',
            'icon' => 'user',
            'content' =>  $this->render('_data-form', [
                // 'searchModel' => $searchModel,
                'model' => $model,
                /*'form' => $form*/
            ]),
            'active' => true
        ],
        [
            'label' => 'Arquivos',
            'content' =>  $this->render('_files', [
               // 'searchModel' => $searchModel,
                'model' => $model,
                /*'form' => $form*/
            ]),
            //'headerOptions' => [...],
            'options' => ['id' => 'myveryownID'],
        ],
    ],
    //'options' => ['class' =>'nav nav-pills nav-justified']
]);
?>

