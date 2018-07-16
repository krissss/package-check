<?php

use common\models\base\ConfigString;

return [
    ConfigString::COMPONENT_PACKAGIST => [
        'class' => \common\components\Packagist::class,
    ],
    ConfigString::COMPONENT_DING_TALK => [
        'class' => \common\components\DingTalk::class,
        'webhook' => getenv('DING_TALK_WEB_HOOK')
    ],
];
