<?php
/** @var $this yii\web\view */
/** @var $model common\models\Packagist */

use kriss\widgets\SimpleSearchForm;

$form = SimpleSearchForm::begin(['action' => ['index']]);

echo $form->field($model, 'vendor');
echo $form->field($model, 'package');

echo $form->renderFooterButtons();

$form->end();
