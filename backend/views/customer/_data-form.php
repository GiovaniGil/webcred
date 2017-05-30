<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content">
    <div class="customer-form container">
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
            <div class="col-sm-2">
                <?= $form->field($model, 'document')->textInput() ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'agency')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'registry')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-1">
                <?= $form->field($model, 'complement')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'zip_code')->widget(\yii\widgets\MaskedInput::className(), array("mask" => "99999-999"
                )); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'neighbourhood')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'phone1',['template' =>
                    '<div class="form-group">
                    {label}
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        {input}
                    </div>
                </div>'
                ])->widget(\yii\widgets\MaskedInput::className(), array("mask" => "(99) 9999-9999[9]")); ?>

            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'phone2', ['template' =>
                    '<div class="form-group">
                    {label}
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        {input}
                    </div>
                </div>'
                ])->widget(\yii\widgets\MaskedInput::className(), array("mask" => "(99) 9999-9999[9]")); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'phone3', ['template' =>
                    '<div class="form-group">
                    {label}
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        {input}
                    </div>
                </div>'
                ])->widget(\yii\widgets\MaskedInput::className(), array("mask" => "(99) 9999-9999[9]")); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'mail',['template' =>
                    '<div class="form-group">
                    {label}
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-laptop"></i>
                        </div>
                        {input}
                    </div>
                </div>'
                ])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'customer_password')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'observation')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'telemarketing')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</section>