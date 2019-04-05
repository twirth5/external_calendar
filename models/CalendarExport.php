<?php


namespace humhub\modules\external_calendar\models;


use humhub\libs\UUID;
use Yii;
use humhub\components\ActiveRecord;
use humhub\modules\user\models\User;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $token
 * @property boolean $filter_participating
 * @property boolean $filter_mine
 * @property boolean $filter_only_public
 * @property boolean $include_profile
 * @property int $space_selection
 */
class CalendarExport extends ActiveRecord
{
    const SPACES_NONE = 0;
    const SPACES_ALL = 1;
    const SPACES_SELECTION = 1;

    public static function tableName()
    {
        return 'external_calendar_export';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            [['filter_only_public', 'filter_participating', 'filter_mine', 'include_profile'], 'boolean'],
            [['space_selection'], 'integer', 'min' => 0, 'max' => 2],

        ];
    }

    public function getExportUrl()
    {
        return Url::to(['/external_calendar/export/export', 'token' => $this->token], true);
    }

    /**
     * @param $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if(empty($this->token)) {
            $this->token = UUID::v4();
        }

        return parent::beforeSave($insert);
    }

    public function getSpaces()
    {
        $this->hasMany(CalendarExportSpaces::class, ['calendar_export_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function attributeLabels()
    {
        return [
            'name' =>  Yii::t('ExternalCalendarModule.export', 'Calendar export name'),
            'include_profile' =>  Yii::t('ExternalCalendarModule.export', 'Profile'),
            'filter_participating' => Yii::t('ExternalCalendarModule.export', 'Only include events I\'am participating'),
            'filter_mine' => Yii::t('ExternalCalendarModule.export', 'Only include events I\'ve created'),
            'filter_only_public' => Yii::t('ExternalCalendarModule.export', 'Only include public events')
        ];
    }
}