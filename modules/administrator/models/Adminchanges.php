<?php

namespace app\modules\administrator\models;

use \yii\db\ActiveRecord;

class Adminchanges extends ActiveRecord
{
    public static function tableName() {
        return '{{cc_review_changes}}';
    }
	
	public function getReview() {
        return $this->hasOne(\app\models\Review::class, ['id' => 'review_id'])
        ->alias('r');
		
	}
}
