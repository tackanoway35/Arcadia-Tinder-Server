<?php
namespace app\models;
use app\models\Member;
use yii\db\ActiveRecord;

class Image extends ActiveRecord
{
    public static function tableName() {
        return 'image';
    }
    
    public function rules() {
        return [
            [['member_id'], 'required'],
            [['member_id'], 'integer'],
            [['avatar', 'image1', 'image2', 'image3', 'image4', 'image5', 'image6', 'image7', 'image8'], 'string']
        ];
    }
    
    public function getMember(){
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }
}
