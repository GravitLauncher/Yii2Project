<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadSkinForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png'],
        ];
    }

    public function upload($filename, $cloak)
    {
        if ($this->validate()) {
            if($cloak)
            {
                $this->imageFile->saveAs('uploads/cloaks/' . $filename . '.png');
            }
            else
            {
                $this->imageFile->saveAs('uploads/skins/' . $filename . '.png');
            }
            return true;
        } else {
            return false;
        }
    }
}
