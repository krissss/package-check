<?php

namespace console\jobs;

use common\components\Logger;
use common\models\base\ConfigString;
use common\models\Packagist;
use common\models\PackagistNeedSend;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\queue\JobInterface;
use yii\queue\Queue;

class PackagistSendJob extends BaseObject implements JobInterface
{
    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue = null)
    {
        $packagistNeedSendModels = PackagistNeedSend::find()->all();
        if (!$packagistNeedSendModels) {
            Logger::queueJob('无消息发送');
            return;
        }
        $models = Packagist::find()
            ->select(['vendor', 'package', 'latest_version', 'repository'])
            ->where(['id' => ArrayHelper::getColumn($packagistNeedSendModels, 'packagist_id')])
            ->all();

        // 发送钉钉消息
        $date = date('Y-m-d H:i');
        $title = "{$date} packagist 更新列表";
        $count = 0;
        $markdown = [];
        $markdown[] = "> {$title}";
        foreach ($models as $model) {
            $markdown[] = "- [{$model->vendor}/{$model->package}:{$model->latest_version}]({$model->repository})";
            $count++;
        }
        ConfigString::getDingTalk()->sendMarkdown($title, implode("\n\n", $markdown));
        Logger::queueJob("消息发送:{$count}条");

        // 删除已经发送的
        PackagistNeedSend::deleteAll(['id' => ArrayHelper::getColumn($packagistNeedSendModels, 'id')]);
    }
}
