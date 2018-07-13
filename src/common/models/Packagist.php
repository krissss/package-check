<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "packagist".
 *
 * @property int $id
 * @property string $vendor
 * @property string $package
 * @property string $latest_version
 * @property int $version_updated_at
 * @property string $type
 * @property string $repository
 */
class Packagist extends \common\models\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'packagist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vendor', 'package', 'latest_version', 'version_updated_at'], 'required'],
            [['version_updated_at'], 'integer'],
            [['vendor', 'package'], 'string', 'max' => 50],
            [['latest_version'], 'string', 'max' => 20],
            [['type', 'repository'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor' => 'Vendor',
            'package' => 'Package',
            'latest_version' => 'Latest Version',
            'version_updated_at' => 'Version Updated At',
            'type' => 'Type',
            'repository' => 'Repository',
        ];
    }
}
