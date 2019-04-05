<?php

use humhub\widgets\ModalButton;
use yii\widgets\ActiveForm;
use humhub\modules\space\widgets\SpacePickerField;
use yii\helpers\Url;
use humhub\modules\external_calendar\models\CalendarExportSpaces;

/* @var $this \humhub\components\View */
/* @var $model \humhub\modules\external_calendar\models\CalendarExport */

$saveButtonLabel = $model->isNewRecord ?  Yii::t('ExternalCalendarModule.base', 'Generate export Url') :  Yii::t('base', 'Save');

?>

<?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>
    <div class="modal-body">
        <?= $form->field($model, 'name')->textInput(['max' => 100]) ?>

        <br>

        <div class="calendar-filters">

            <div class="row">
                <div class="col-sm-4">
                    <strong>
                        <?= Yii::t('ExternalCalendarModule.export', 'Include events from:'); ?>
                    </strong>
                </div>
                <div class="col-sm-4">
                    <strong>
                        <?= Yii::t('ExternalCalendarModule.export', 'Additional filters:'); ?>
                    </strong>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-sm-4 ">
                    <?= $form->field($model, 'include_profile')->checkbox() ?>
                    <?= $form->field($model, 'space_selection')->radio(['label' => Yii::t('ExternalCalendarModule.export', 'No spaces'), 'value' => 0])?>
                    <?= $form->field($model, 'space_selection')->radio(['label' => Yii::t('ExternalCalendarModule.export', 'All my spaces'), 'value' => 1])?>
                    <?= $form->field($model, 'space_selection')->radio(['label' => Yii::t('ExternalCalendarModule.export', 'Only following spaces:'), 'value' => 2])?>
                    <?= $form->field($model, 'spaces')->widget(SpacePickerField::class,
                        ['defaultResults' => CalendarExportSpaces::getCalendarMemberSpaces(), 'url' => Url::to(['/external_calendar/export/search-space'])])->label(false)?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'filter_participating')->checkbox() ?>
                    <?= $form->field($model,'filter_mine')->checkbox() ?>
                    <?= $form->field($model, 'filter_only_public')->checkbox() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <?= ModalButton::submitModal(Url::to(['/external_calendar/export/edit', 'id' => $model->id]), $saveButtonLabel); ?>
    </div>

<?php ActiveForm::end() ?>