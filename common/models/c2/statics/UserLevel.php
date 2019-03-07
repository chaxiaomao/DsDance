<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * ConfigType
 *
 * @author ben
 */
class UserLevel extends AbstractStaticClass {

    const TYPE_STUDENT = 1;
    const TYPE_TEACHER = 2;
    
    protected static $_data;

    /**
     * 
     * @param type $id
     * @param type $attr
     * @return string|array
     */
    public static function getData($id = '', $attr = '') {
        if (is_null(static::$_data)) {
            static::$_data = [
                static::TYPE_STUDENT => ['id' => static::TYPE_STUDENT, 'label' => Yii::t('app.c2', 'Student')],
                static::TYPE_TEACHER => ['id' => static::TYPE_TEACHER, 'label' => Yii::t('app.c2', 'Teacher')],
            ];
        }
        if ($id !== '' && !empty($attr)) {
            return static::$_data[$id][$attr];
        }
        if ($id !== '' && empty($attr)) {
            return static::$_data[$id];
        }
        return static::$_data;
    }

}
