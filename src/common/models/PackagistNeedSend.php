<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "packagist_need_send".
 *
 * @property int $id
 * @property int $packagist_id Packagist ID
 *
 * @property Packagist $packagist
 */
class PackagistNeedSend extends \common\models\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'packagist_need_send';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['packagist_id'], 'required'],
            [['packagist_id'], 'integer'],
            [['packagist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packagist::class, 'targetAttribute' => ['packagist_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'packagist_id' => 'Packagist ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackagist()
    {
        return $this->hasOne(Packagist::class, ['id' => 'packagist_id']);
    }

    /**
     * @param $packagistId
     */
    public static function createOne($packagistId)
    {
        Yii::$app->db->createCommand()->upsert(static::tableName(), [
            'packagist_id' => $packagistId
        ], false)->execute();
    }
}
