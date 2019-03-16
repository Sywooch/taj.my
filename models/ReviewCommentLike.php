<?php

namespace app\models;

use yii\db\ActiveRecord;

class ReviewCommentLike extends ActiveRecord
{

    public static function tableName() {
        return '{{yy_review_comment_likes}}';
    }
}
