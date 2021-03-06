<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */

$this->title = Yii::t('frontend','Create Customer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create" style="margin-left: 20%;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
