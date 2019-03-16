<?php

namespace app\models;

use yii\db\ActiveRecord;

class UserInvite extends ActiveRecord
{

    public static function tableName() {
        return '{{cc_user_invites}}';
    }
}
