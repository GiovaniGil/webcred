<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['type' => 'date', 'value' => Yii::$app->formatter->asDatetime($model->birthday, DATE)]) ?>

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
<?php
$script = <<< JS

    $(document).ready(function(){
        jQuery.datetimepicker.setLocale('pt-BR');
        $("#customer-birthday").datetimepicker({
            timepicker:false,
            format:'d/m/Y',
            maxDate:'+1970/01/01'
        });
    });

JS;
$this->registerJs($script);
?>