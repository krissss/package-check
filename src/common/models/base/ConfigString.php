<?php

namespace common\models\base;

use common\components\DingTalk;
use common\components\Packagist;
use Yii;
use yii\queue\file\Queue;

class ConfigString
{
    // component
    const COMPONENT_PACKAGIST = 'packagist';
    const COMPONENT_DING_TALK = 'ding_talk';

    // log category
    const CATEGORY_NEED_SOLVED = 'need-solved';
    const CATEGORY_QUEUE_JOB = 'queue-job';

    /**
     * @return null|object|Packagist
     */
    public static function getPackagist()
    {
        return Yii::$app->get(static::COMPONENT_PACKAGIST);
    }

    /**
     * @return null|object|DingTalk
     */
    public static function getDingTalk()
    {
        return Yii::$app->get(static::COMPONENT_DING_TALK);
    }

    /**
     * @return null|object|Queue
     * @throws \yii\base\InvalidConfigException
     */
    public static function getQueue()
    {
        return Yii::$app->get('queue');
    }
}
