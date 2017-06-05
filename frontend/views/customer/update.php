<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */

$this->title = Yii::t('frontend', 'Update Customer {customer}', ['customer' => explode(' ',$model->name)[0]]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('frontend', 'Update');
?>
<div class="customer-update" style="margin-left: 20%;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
