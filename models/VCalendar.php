<?php


namespace humhub\modules\external_calendar\models;


use humhub\modules\calendar\interfaces\CalendarItem;
use yii\base\Model;
use Sabre\VObject;

/**
 * Class VCalendar serves as wrapper around sabledavs vobject api.
 *
 */
class VCalendar extends Model
{
    /**
     * @var CalendarItem
     */
    public $items;

    public function serialize()
    {
        $cal = new VObject\Component\VCalendar([]);

        foreach($this->items as $item)
        {
            $this->addEvent($cal, $item);
        }

        return $cal->serialize();
    }

    /**
     * @param $cal VObject\Component\VCalendar
     * @param $item CalendarItem
     * @return []
     * @throws \Exception
     */
    private function addEvent($cal, $item)
    {
        $dtend = $item->getEndDateTime();

        if($item->isAllDay()) {
            $dtend = $dtend->add(new \DateInterval('P1D'));
        }

        $result = [
            'DTSTART' => $item->getStartDateTime(),
            'DTEND' => $dtend,
            'SUMMARY' =>$item->getTitle(),
            'URL' => $item->getUrl(),
        ];

        if(property_exists($item, 'location')) {
            $result['LOCATION'] = $item->location;
        }

        if(property_exists($item, 'description')) {
            $result['DESCRIPTION'] = $item->description;
        }

        if(property_exists($item, 'uid')) {
            $result['uid'] = $item->uid;
        }

        $evt = $cal->add('VEVENT', $result);

        if($item->isAllDay()) {
            if(isset($evt->DTSTART)) {
                $evt->DTSTART['VALUE'] = 'DATE';
            }

            if(isset($evt->DTEND)) {
                $evt->DTEND['VALUE'] = 'DATE';
            }
        }

        return $result;
    }
}