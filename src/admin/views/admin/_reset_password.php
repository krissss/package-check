<?php
/** @var $this yii\web\View */
/** @var $model common\models\Admin */

use kriss\widgets\SimpleAjaxForm;

$form = SimpleAjaxForm::begin(['header' => '重置密码']);

echo $form->field($model, 'password_hash')->passwordInput(['value' => '']);

$form->end();
