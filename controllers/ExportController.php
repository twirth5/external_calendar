<?php


namespace humhub\modules\external_calendar\controllers;

use humhub\modules\calendar\interfaces\CalendarService;
use humhub\modules\external_calendar\models\CalendarExport;
use humhub\modules\external_calendar\models\VCalendar;
use Yii;
use humhub\components\Controller;
use humhub\modules\external_calendar\models\CalendarExportSpaces;
use humhub\modules\space\widgets\Chooser;
use yii\web\HttpException;
use \DateTime;

class ExportController extends Controller
{
    public $requireContainer = false;

    public function actionExport($token)
    {
        try {
            $export = CalendarExport::findOne(['token' => $token]);

            if (!$export) {
                throw new HttpException(404);
            }

            $service = new CalendarService();

            if (!$export->filter_only_public) {
                Yii::$app->user->setIdentity($export->user);
            }

            $start = new DateTime('-6 month');
            $end = new DateTime('+12 month');

            $items = [[]];
            foreach ($export->getContainers() as $container) {
                $items[] = $service->getCalendarItems($start, $end, $export->getFilterArray(), $container);
            }

            $items = array_merge(...$items);

            $cal = new VCalendar(['items' => $items]);

            return $cal->serialize();

            return Yii::$app->response->sendContentAsFile($cal->serialize(), uniqid() . '.ics', ['mimeType' => 'text/calendar']);

        } finally {
            Yii::$app->user->setIdentity(null);
        }
    }

    public function actionEdit($id = null)
    {
        if (empty($id)) {
            $model = new CalendarExport(['user_id' => Yii::$app->user->id]);
        } else {
            $model = CalendarExport::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
        }

        if (!$model) {
            throw new HttpException(404);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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