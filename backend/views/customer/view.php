<?php

use asinfotrack\yii2\audittrail\widgets\AuditTrail;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Customers') , 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="customer-update" style="margin-left: 20%;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>