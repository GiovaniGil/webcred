<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
-->

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'document')->textInput() ?>

    <?= $form->field($model, 'agency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registry')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'complement')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'neighbourhood')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'telemarketing')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>

    $(document).ready(function(){
        jQuery.datetimepicker.setLocale('pt-BR');
        $("#customer-birthday").datetimepicker({
            timepicker:false,
            format:'d/m/Y',
            maxDate:'+1970/01/01'
        });
    });

</script>