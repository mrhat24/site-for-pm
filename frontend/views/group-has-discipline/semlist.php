<?php
use yii\helpers\ArrayHelper;
use common\components\DateHelper;
foreach ($arr as $ar)
{
                 echo '<option value="'.$ar->id.'">'.$ar->semester_number." - (".
                         DateHelper::getDateByUserTimezone($ar->begin_date).':'.
                         DateHelper::getDateByUserTimezone($ar->end_date).') </option>';           
}