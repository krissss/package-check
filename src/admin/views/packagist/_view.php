<?php
/** @var $this yii\web\view */
/** @var $model common\models\Packagist */

use kriss\widgets\SimpleAjaxView;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;

$this->title = 'Packagist详情';

SimpleAjaxView::begin(['header' => $this->title, 'modalSize' => 'lg']);

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'latest_version_package',
            'value' => VarDumper::dumpAsString(json_decode($model->latest_version_package, true), 10, true),
            'format' => 'html',
        ],
        [
            'attribute' => 'package_info',
            'value' => VarDumper::dumpAsString(json_decode($model->package_info, true), 10, true),
            'format' => 'html',
        ],
    ]
]);

SimpleAjaxView::end();
