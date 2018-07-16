<?php
/** @var $this yii\web\view */
/** @var $model common\models\Packagist */

use kriss\widgets\SimpleAjaxForm;

$this->title = $model->isNewRecord ? '新增Packagist' : '修改Packagist';

$form = SimpleAjaxForm::begin(['header' => $this->title]);

echo $form->field($model, 'vendor');
echo $form->field($model, 'package');

SimpleAjaxForm::end();
