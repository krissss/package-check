<?php
/** @var $this yii\web\View */
/** @var $dataProvider */
/** @var $searchModel */

use kriss\widgets\ActionColumn;
use kriss\widgets\DatetimeColumn;
use kriss\widgets\SimpleDynaGrid;
use yii\helpers\Html;

$this->title = 'Packagist列表';
$this->params['breadcrumbs'] = [
    $this->title,
];

echo $this->render('_search', [
    'model' => $searchModel,
]);

$columns = [
    [
        'attribute' => 'id',
    ],
    [
        'attribute' => 'vendor',
    ],
    [
        'attribute' => 'package',
    ],
    [
        'attribute' => 'latest_version',
    ],
    [
        'class' => DatetimeColumn::class,
        'attribute' => 'version_updated_at',
    ],
    [
        'attribute' => 'type',
    ],
    [
        'attribute' => 'homepage',
    ],
    [
        'attribute' => 'repository',
    ],
    [
        'class' => DatetimeColumn::class,
        'attribute' => 'updated_at',
    ],
    [
        'class' => ActionColumn::class,
        'groupButtons' => [
            ['action' => 'view', 'label' => '详情', 'cssClass' => 'show_ajax_modal',],
            ['action' => 'update', 'label' => '修改', 'type' => 'primary', 'cssClass' => 'show_ajax_modal',],
            ['action' => 'update-info', 'label' => '立即更新', 'type' => 'success',],
            ['action' => 'delete', 'label' => '删除', 'type' => 'danger', 'options' => ['data-confirm' => '确定删除？'],],
        ],
    ],
];

$simpleDynaGrid = new SimpleDynaGrid([
    'dynaGridId' => 'dynagrid-packagist-index',
    'columns' => $columns,
    'dataProvider' => $dataProvider,
    'extraToolbar' => [
        [
            'content' => Html::a('新增', ['create'], ['class' => 'btn btn-primary show_ajax_modal'])
        ]
    ]
]);
$simpleDynaGrid->renderDynaGrid();
