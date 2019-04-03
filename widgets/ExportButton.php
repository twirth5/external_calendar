<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\external_calendar\widgets;


use Yii;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\components\Widget;
use humhub\widgets\Button;

class ExportButton extends Widget
{
    /**
     * @var ContentContainerActiveRecord
     */
    public $container;

    public function run()
    {
        return Button::defaultType(Yii::t('ExternalCalendarModule.permissions', 'Export'))
            ->icon('fa-external-link')
            ->action('calendar.export', $this->container->createUrl('/calendar/export/create') );
    }

}