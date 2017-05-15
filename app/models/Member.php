<?php
namespace app\models;
use yii\db\ActiveRecord;
use app\models\Image;
use app\models\RequireInformation;
use app\models\Setting;
    
class Member extends ActiveRecord
{
    public static function tableName() {
        return 'member';
    }
    
    public function rules() {
        return [
            [['name', 'gender', 'email'], 'required'],
            [['name', 'gender', 'email', 'job', 'tel', 'educational_level', 'personalities', 'facebook_id', 'gmail_id', 'about_yourself', 'username', 'password', 'address'], 'string'],
            [['time', 'birthday', 'require_information'], 'integer'],
            ['time', 'default', 'value' => time()],
        ];
    }
    
    public function attributeLabels() {
        return [
            'birthday' => 'Birth day',
            'educational_level' => 'Education level',
            'about_yourself' => 'About Yourself'
        ];
    }
    
    public function getImage(){
        return $this->hasMany(Image::className(), ['member_id' => 'id']);
    }
    
    public function getRequireInformation(){
        return $this->hasMany(RequireInformation::className(), ['member_id' => 'id']);
    }
    
    public function getSetting(){
        return $this->hasMany(Setting::className(), ['member_id' => 'id']);
    }
    
    public function extraFields() {
        return ['image','requireInformation','setting'];
    }
}
?>