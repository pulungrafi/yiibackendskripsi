<?php

namespace backend\models;

use yii\db\ActiveRecord;

class UserRole extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_role';
    }

    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['name'], 'in', 'range' => ['Peternak', 'Admin', 'Calon Pembeli Ternak'], 'message' => 'Invalid user role.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
        ];
    }
}
