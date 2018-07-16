<?php

namespace console\controllers;

use console\jobs\PackagistSendJob;
use console\jobs\PackagistUpdateJob;

class CronPackagistController extends CronBaseController
{
    /**
     * @return int
     */
    public function getSleepTime()
    {
        return 12 * 3600;
    }

    /**
     * 业务名称
     * @return string
     */
    public function getName()
    {
        return 'Packagist';
    }

    /**
     * 实际需要轮询的业务
     * @throws \Exception
     */
    public function service()
    {
        $currentHour = (int)date('h');
        if ($currentHour != 9) {
            // 每天 9 点更新一次数据
            $job = new PackagistUpdateJob();
            $job->execute();

            $job2 = new PackagistSendJob();
            $job2->execute();
        }
    }
}
