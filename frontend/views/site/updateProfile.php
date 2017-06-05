<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('backend','Update User {user}', ['user' => $model->username]);

?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_profile', [
        'model' => $model,
    ]) ?>

</div>
