<?php

/**
 * Created by PhpStorm.
 * User: Алимжан
 * Date: 27.01.2015
 * Time: 12:24
 */

namespace backend\components\behaviors;

use Yii;
use cza\base\modules\Attachments\ModuleTrait;
use cza\base\models\ActiveRecord;
use yii\base\Behavior;
use yii\base\UnknownPropertyException;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use backend\models\c2\form\Config\Form;
use cza\base\modules\Attachments\behaviors\AttachmentBehavior;
use common\models\c2\entity\Config;

class ConfigAttachmentBehavior extends AttachmentBehavior {

    public function events() {
        return [
//            ActiveRecord::EVENT_BEFORE_VALIDATE => 'applyRules',
            Form::EVENT_AFTER_SAVE => 'saveUploads',
        ];
    }

    /**
     * @param $filePath string
     * @param $owner
     * @return bool|File
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function attachFile($filePath, $attribute, $extras = []) {
        $owner = $this->owner;
        if (empty($owner->id)) {
            throw new Exception('Parent model must have ID when you attaching a file');
        }
        if (!\file_exists($filePath)) {
            throw new Exception("File {$filePath} not exists");
        }

        $fileHash = md5(microtime(true) . $filePath);
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $newFileName = "{$fileHash}.{$fileType}";

        $fileDirPath = $this->getModule()->getFileDirPath($fileHash, $owner);
        $newFilePath = $fileDirPath . DIRECTORY_SEPARATOR . $newFileName;

        if (!copy($filePath, $newFilePath)) {
            throw new Exception("Cannot copy file! {$filePath}  to {$newFilePath}");
        }
        $file = new $this->attributesDefinition[$attribute]['class'];
        if (isset($this->attributesDefinition[$attribute]['enableVersions'])) {
            $file->setEnableVersions($this->attributesDefinition[$attribute]['enableVersions']);
        }

        $file->loadDefaultValues();
        $entityModel = $owner->getEntityByAttribute($attribute);
        $file->setAttributes([
            'name' => pathinfo($filePath, PATHINFO_FILENAME),
            'entity_id' => $entityModel->id,
//            'entity_class' => $owner->className(),
            'entity_class' => Config::className(),
            'entity_attribute' => $attribute,
            'hash' => $fileHash,
            'size' => filesize($filePath),
            'content' => isset($extras['content']) ? $extras['content'] : "",
            'extension' => $fileType,
            'mime_type' => FileHelper::getMimeType($filePath),
            'logic_path' => $this->getModule()->getFileLogicPath($fileHash, $owner),
        ]);

        if ($file->save()) {
//            $owner->updateAttributes([
//                'customer_value' => $attribute,
//            ]);
            @\unlink($filePath);
            return $file;
        } else {
            Yii::info($file->errors);
            return false;
        }
    }

    /**
     * @return File[]
     * @throws \Exception
     */
    public function getFiles($attribute, $order = ['id' => SORT_ASC]) {
        $modelClass = $this->attributesDefinition[$attribute]['class'];
        $fileQuery = $modelClass::find()
                ->andWhere([
            'entity_id' => $this->owner->getEntityAttributeId($attribute),
//            'entity_class' => $this->owner->className(),
            'entity_class' => Config::className(),
            'entity_attribute' => $attribute,
        ]);
        $fileQuery->orderBy($order);
        return $fileQuery->all();
    }

    public function getOneAttachment($attribute, $order = ['id' => SORT_ASC]) {
        $id = $this->owner->getEntityAttributeId($attribute);
        $modelClass = $this->attributesDefinition[$attribute]['class'];
        $fileQuery = $modelClass::find()
                ->andWhere([
            'entity_id' => $id,
//            'entity_class' => $this->owner->className(),
            'entity_class' => Config::className(),
            'entity_attribute' => $attribute,
        ]);
        $fileQuery->orderBy($order);
        return $fileQuery->one();
    }

}
