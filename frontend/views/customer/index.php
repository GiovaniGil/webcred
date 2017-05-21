<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'birthday',
            'document',
            'agency',
            // 'registry',
            // 'address',
            // 'complement',
            // 'zip_code',
            // 'neighbourhood',
            // 'city',
            // 'state',
            // 'phone1',
            // 'phone2',
            // 'phone3',
            // 'mail',
            // 'customer_password',
            // 'observation:ntext',
            // 'telemarketing',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>