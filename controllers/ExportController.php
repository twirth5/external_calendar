<?php


namespace humhub\modules\external_calendar\controllers;

use humhub\modules\external_calendar\models\CalendarExport;
use Yii;
use humhub\components\Controller;
use humhub\modules\external_calendar\models\CalendarExportSpaces;
use humhub\modules\space\widgets\Chooser;

class ExportController extends Controller
{
    public $requireContainer = false;

    public function actionEdit()
    {
        $model = new CalendarExport(['user_id' => Yii::$app->user->id]);

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->renderAjax('config', ['model' => new CalendarExport(), 'showOverview' => true]);
        }

        return $this->renderAjax('config', ['model' => $model, 'showOverview' => false]);
    }

    public function actionSearchSpace($keyword)
    {
        $result = [];
        foreach (CalendarExportSpaces::getCalendarMemberSpaces($keyword) as $space) {
            $result[] = Chooser::getSpaceResult($space);
        }

        return $this->asJson($result);
    }

}