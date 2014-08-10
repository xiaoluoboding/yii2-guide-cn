<?php

namespace app\modules\guide\models;

use Yii;

/**
 * This is the model class for table "guidelist".
 *
 * @property integer $id
 * @property string $enname
 * @property string $cnname
 */
class Guidelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guidelist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['enname', 'cnname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'enname' => Yii::t('app', 'Enname'),
            'cnname' => Yii::t('app', 'Cnname'),
        ];
    }
}
