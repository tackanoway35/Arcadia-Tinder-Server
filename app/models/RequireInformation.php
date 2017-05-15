<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\Member;

class RequireInformation extends ActiveRecord{
    public static function tableName() {
        return 'require_information';
    }
    
    public function rules() {
        return [
            [['member_id'], 'required'],
            [['member_id', 'distance'], 'integer'],
            [['educational_level', 'personalities', 'job', 'gender'], 'string'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'educational_level' => 'Education Level'
        ];
    }
    
    public function getMember(){
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }
}
?>