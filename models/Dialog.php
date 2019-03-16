<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 16:38
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Dialog extends ActiveRecord
{
    public static function tableName() {
        return '{{cc_dialog}}';
    }

    public function getDialogMessage()
    {
        return $this->hasMany(DialogMessage::class, ['dialog_id' => 'id'])
        ->alias('message');
    }

    public function getProfileTo()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_to'])->alias('to');
    }

    public function getProfileFrom()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_from'])->alias('from');
    }

}