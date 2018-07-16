<?php

namespace console\jobs;

use common\components\Logger;
use common\models\Packagist;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

class PackagistUpdateJob extends BaseObject implements JobInterface
{
    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue = null)
    {
        $count = 0;
        foreach (Packagist::find()->each(100) as $model) {
            /** @var $model Packagist */
            $model->updateInfo();
            $count++;
        }
        Logger::queueJob("packagist 更新:{$count}条");
    }
}
