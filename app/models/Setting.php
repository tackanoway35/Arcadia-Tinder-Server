<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\Member;

class Setting extends ActiveRecord{
    public static function tableName() {
        return 'setting';
    }
    
    public function rules() {
        return [
            [['member_id', 'name', 'email', 'gender', 'birthday', 'educational_level', 'personalities', 'tel', 'job', 'about_yourself'], 'integer']
        ];
    }
    
    public function getMember(){
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }
}
?>