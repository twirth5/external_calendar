<?php
/* @var $this \humhub\components\View */

use humhub\modules\external_calendar\models\CalendarExport;
use yii\data\ActiveDataProvider;
use humhub\widgets\GridView;

$dataProvider = new ActiveDataProvider([
    'query' => CalendarExport::find()->where(['user_id' => Yii::$app->user->id]),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

?>
<div class="modal-body">
    <div class="alert alert-info">
        <?=  Yii::t('ExternalCalendarModule.export', 'Only share generat') ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    ]);?>
</div>

