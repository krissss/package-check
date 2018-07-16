<?php

namespace common\models;

use common\models\base\ConfigString;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "packagist".
 *
 * @property int $id
 * @property string $vendor 供应商
 * @property string $package 包名
 * @property string $latest_version 最新版本
 * @property int $version_updated_at 版本更新时间
 * @property string $type 包类型
 * @property string $homepage 主页
 * @property string $repository 代码地址
 * @property string $latest_version_package 最新版本信息
 * @property string $package_info 包信息
 * @property int $updated_at 更新时间
 */
class Packagist extends \common\models\base\ActiveRecord
{
    const EVENT_AFTER_VERSION_UPDATE = 'version_update';

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
            [['vendor', 'package'], 'required'],
            [['version_updated_at', 'updated_at'], 'integer'],
            [['latest_version_package', 'package_info'], 'string'],
            [['vendor', 'package'], 'string', 'max' => 50],
            [['latest_version'], 'string', 'max' => 20],
            [['type', 'homepage', 'repository'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor' => '供应商',
            'package' => '包名',
            'latest_version' => '最新版本',
            'version_updated_at' => '版本更新时间',
            'type' => '包类型',
            'homepage' => '主页',
            'repository' => '代码地址',
            'latest_version_package' => '最新版本信息',
            'package_info' => '包信息',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'vendor' => 'eg: yiisoft',
            'package' => 'eg: yii2',
        ];
    }

    /**
     * 更新信息
     */
    public function updateInfo()
    {
        $package = ConfigString::getPackagist()->getPackageByName($this->vendor, $this->package);
        if ($package) {
            // 将规整的版本号作为 key
            $packageVersions = ArrayHelper::index($package['versions'], 'version_normalized');
            unset($package['versions']);

            $versions = array_keys($packageVersions);
            // 去除 dev 版本
            $versions = array_filter($versions, function ($v) {
                return strpos($v, 'dev') === false;
            });
            // 获取最大的版本号
            $maxVersion = 0;
            array_map(function ($v) use (&$maxVersion) {
                $maxVersion = version_compare($v, $maxVersion) == 1 ? $v : $maxVersion;
            }, $versions);

            // 更新最大版本号
            $hasUpdated = false;
            if ($this->latest_version != $maxVersion) {
                $versionPackage = $packageVersions[$maxVersion];

                $this->latest_version = $maxVersion;
                $this->version_updated_at = strtotime($versionPackage['time']);
                $this->type = $versionPackage['type'];
                $this->homepage = $versionPackage['homepage'];
                $this->repository = $package['repository'];
                $this->latest_version_package = json_encode($versionPackage);
                $this->package_info = json_encode($package);

                $hasUpdated = true;
            }
            $this->updated_at = time();
            $this->save(false);

            $hasUpdated && PackagistNeedSend::createOne($this->id);
        }
    }
}
