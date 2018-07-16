<?php

namespace admin\controllers;

use admin\components\AuthWebController;
use admin\models\PackagistSearch;
use common\models\Packagist;
use kriss\actions\web\crud\CreateAction;
use kriss\actions\web\crud\DeleteAction;
use kriss\actions\web\crud\IndexAction;
use kriss\actions\web\crud\ModelOperateAction;
use kriss\actions\web\crud\UpdateAction;
use kriss\actions\web\crud\ViewAction;

class PackagistController extends AuthWebController
{
    public function actions()
    {
        $actions = parent::actions();

        // 列表
        $actions['index'] = [
            'class' => IndexAction::class,
            'searchModel' => PackagistSearch::class
        ];
        // 新增
        $actions['create'] = [
            'class' => CreateAction::class,
            'modelClass' => Packagist::class,
            'isAjax' => true,
            'view' => '_create_update',
        ];
        // 修改
        $actions['update'] = [
            'class' => UpdateAction::class,
            'modelClass' => Packagist::class,
            'isAjax' => true,
            'view' => '_create_update',
        ];
        // 详情
        $actions['view'] = [
            'class' => ViewAction::class,
            'modelClass' => Packagist::class,
            'isAjax' => true,
            'view' => '_view',
        ];
        // 删除
        $actions['delete'] = [
            'class' => DeleteAction::class,
            'modelClass' => Packagist::class,
        ];
        // 修改
        $actions['update-info'] = [
            'class' => ModelOperateAction::class,
            'modelClass' => Packagist::class,
            'doMethod' => 'updateInfo'
        ];

        return $actions;
    }
}
