<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => '',
                'format' => 'raw',
                'value' => function ($model) {
                    $session =  Yii::$app->db->createCommand('SELECT user_id FROM session WHERE user_id = '.$model->id)->queryOne();

                    if($session)
                        return Html::tag('i', '', ['class' => 'fa fa-fw fa-user', 'style' => 'color:green']) ;
                    else
                        return Html::tag('i', '', ['class' => 'fa fa-fw fa-user', 'style' => 'color:red']) ;
                }
            ],
            //'id',
            'name',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
             'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn',
             'header' => 'Actions'],
        ],
    ]); ?>
</div>
