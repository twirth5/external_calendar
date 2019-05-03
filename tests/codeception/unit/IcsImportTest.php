<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\external_calendar\tests\codeception\unit;

use humhub\modules\external_calendar\models\ExternalCalendar;
use humhub\modules\external_calendar\models\ExternalCalendarEntry;
use humhub\modules\user\models\User;
use Yii;
use tests\codeception\_support\HumHubDbTestCase;

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 17.09.2017
 * Time: 20:25
 */

class IcsImportTest extends HumHubDbTestCase
{
    public function testImportAndUpdateEvent()
    {
        $this->becomeUser('Admin');

        $externalCalendar = new ExternalCalendar(User::findOne(1), [
            'allowFiles' => true,
            'title' => 'test',
            'url' => Yii::getAlias('@external_calendar/tests/codeception/data/test1.ics')
        ]);

        $externalCalendar->save();

        $this->assertTrue($externalCalendar->save());

        $externalCalendar->sync();

        $this->assertEquals(1, ExternalCalendarEntry::find()->count());

        $externalCalendar->url =  Yii::getAlias('@external_calendar/tests/codeception/data/test1Update.ics');

        $externalCalendar->sync();

        $this->assertEquals(2, ExternalCalendarEntry::find()->count());
    }

    public function testImportAndDeleteEvent()
    {
        $this->becomeUser('Admin');

        $externalCalendar = new ExternalCalendar(User::findOne(1), [
            'allowFiles' => true,
            'title' => 'test',
            'url' => Yii::getAlias('@external_calendar/tests/codeception/data/test1Update.ics')
        ]);

        $externalCalendar->save();

        $this->assertTrue($externalCalendar->save());

        $externalCalendar->sync();

        $this->assertEquals(2, ExternalCalendarEntry::find()->count());

        $externalCalendar->url =  Yii::getAlias('@external_calendar/tests/codeception/data/test1.ics');

        $externalCalendar->sync();

        $this->assertEquals(1, ExternalCalendarEntry::find()->count());
    }
}