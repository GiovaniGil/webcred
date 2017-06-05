<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['action' => 'index.php?r=site/profile']); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'username', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'email', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'password_hash', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->passwordInput(['minlength' => 6, 'maxlength' => 10]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend','Create') : Yii::t('backend','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php /*=  Html::a('Back', ['index', ], ['class' => 'btn btn-default']) */?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
