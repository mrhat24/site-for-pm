<?php
namespace common\components;
use Yii;
use DateTime;
use DateTimeZone;

class DateHelper
{
    public static function getDateTimeByUserTimezone($d)
    {
        $date = new DateTime();
        //$date->setTimezone(new DateTimeZone('Europe/Moscow'));
        $date->setTimestamp($d);
        if(!Yii::$app->user->isGuest)        
        {
        $date->setTimezone(new DateTimeZone(Yii::$app->user->identity->timezone));
        return $date->format("d-m-Y H:i:s");
        }
        else
            return $date->format("d-m-Y H:i:s")."(МСК)";
    }
    
    public static function getDateByUserTimezone($d)
    {
        $date = new DateTime();
        //$date->setTimezone(new DateTimeZone('Europe/Moscow'));
        $date->setTimestamp($d);
        if(!Yii::$app->user->isGuest)        
        {
        $date->setTimezone(new DateTimeZone(Yii::$app->user->identity->timezone));
        return $date->format("d-m-Y");
        }
        else
            return $date->format("d-m-Y")."(МСК)";
    }
}