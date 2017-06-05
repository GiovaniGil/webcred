<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'name', ['template' =>
                '<div class="form-group">
                    {label}
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </div>
                        {input}
                    </div>
                </div>'
            ])->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'birthday',['template' =>
                '<div class="form-group">
                        {label}
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {input}
                        </div>
                    </div>{hint}{error}'
            ])->widget(\yii\widgets\MaskedInput::className(), array("mask" => "99/99/9999",
                'options' => ['value' => Yii::$app->formatter->asDate($model->birthday, DATE), 'class' => 'form-control'])); ?>
        </div>
    </div>
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
        <div class="col-sm-4">
            <?= $form->field($model, 'confirm_password', ['template' => "{label}<div class='controls'>{input}</div>{hint}{error}"])->passwordInput(['minlength' => 6, 'maxlength' => 10]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend','Create') : Yii::t('backend','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php /*=  Html::a('Back', ['index', ], ['class' => 'btn btn-default']) */?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

    $(document).ready(function(){
        $("#user-password_hash").val('');
        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $.fn.datepicker.defaults.language = "pt-BR";
        $('#user-birthday').datepicker({});        
    });

JS;
$this->registerJs($script);
?>
