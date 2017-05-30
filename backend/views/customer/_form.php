<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$form = ActiveForm::begin(); ?>

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
                'form' => $form
            ]),
            'active' => true
        ],
        [
            'label' => 'Arquivos',
            'content' =>  $this->render('_files', [
               // 'searchModel' => $searchModel,
                'model' => $model,
                'form' => $form
            ]),
            //'headerOptions' => [...],
            'options' => ['id' => 'files'],
        ],
            [
            'label' => 'Log de Alteração',
            'content' =>  $this->render('_log', [
               // 'searchModel' => $searchModel,
                'model' => $model,
                'form' => $form
            ]),
            //'headerOptions' => [...],
            'options' => ['id' => 'log'],
        ],
    ],
    //'options' => ['class' =>'nav nav-pills nav-justified']
]);
?>
<!--<div class="form-group">
    <?/*= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) */?>
</div>-->

<?php ActiveForm::end(); ?>
