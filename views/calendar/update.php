<?php

use yii\helpers\Html;
use humhub\modules\calendar\widgets\ContainerConfigMenu;

/* @var $this yii\web\View */
/* @var $model \humhub\modules\external_calendar\models\ExternalCalendar */
/* @var $contentContainer \humhub\modules\content\models\ContentContainer */

$this->title = Yii::t('ExternalCalendarModule.views_calendar', 'Update {modelClass}', [
        'modelClass' => Yii::t('ExternalCalendarModule.views_calendar', 'Calendar'),
    ]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= ContainerConfigMenu::widget() ?>

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'contentContainer' => $contentContainer,
        ]) ?>
    </div>
</div>
