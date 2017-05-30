<?php
use asinfotrack\yii2\audittrail\widgets\AuditTrail;
use common\models\User;
use yii\helpers\Html;

?>
<section class="content">
    <div class="customer-form">
        <?=
        AuditTrail::widget([
            'model'=>$model,

            // some of the optional configurations
            'userIdCallback'=>function ($userId, $model) {
                return User::findOne($userId)->username;
            },
            'changeTypeCallback'=>function ($type, $model) {
                return Html::tag('span', strtoupper($type), ['class'=>'label label-info']);
            },
            'dataTableOptions'=>['class'=>'table table-condensed table-bordered'],
        ]) ?>
    </div>
</section>
