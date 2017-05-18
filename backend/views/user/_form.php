<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->textInput() ?>

    <?= $form->field($model, 'password_hash', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->passwordInput(['minlength' => 6, 'maxlength' => 10]) ?>

    <?= $form->field($model, 'confirm_password', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->passwordInput(['minlength' => 6, 'maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?=  Html::a('Back', ['index', ], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
