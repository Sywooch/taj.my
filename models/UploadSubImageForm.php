<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 06.12.2018
 * Time: 13:37
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadSubImageForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $reviewSubImage;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['reviewSubImage'], 'file',
                'skipOnEmpty' => false,
                'extensions' => 'gif, jpg, png',
                'maxFiles' => 10
            ],
        ];
    }
}