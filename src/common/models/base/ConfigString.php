<?php

namespace common\models\base;

use common\components\Packagist;
use common\components\QiNiu;
use Yii;

class ConfigString
{
    // component
    const COMPONENT_QI_NIU = 'qi_niu';
    const COMPONENT_PACKAGIST = 'packagist';

    // log category
    const CATEGORY_NEED_SOLVED = 'need-solved';
    const CATEGORY_QUEUE_JOB = 'queue-job';

    /**
     * @return null|object|QiNiu
     */
    public static function getQiNiu()
    {
        return Yii::$app->get(static::COMPONENT_QI_NIU);
    }

    /**
     * @return \League\Flysystem\Filesystem
     */
    public static function getDisk()
    {
        return static::getQiNiu()->getDisk();
    }

    /**
     * @return null|object|Packagist
     */
    public static function getPackagist()
    {
        return Yii::$app->get(static::COMPONENT_PACKAGIST);
    }
}
