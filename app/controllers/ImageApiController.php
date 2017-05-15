<?php
namespace app\controllers;
use yii\rest\ActiveController;
use \yii\helpers\ArrayHelper;
use yii\filters\Cors;
use app\models\Image;

class ImageApiController extends ActiveController{
    public $modelClass = 'app\models\Image';
    
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
            ]
        ], parent::behaviors());
    }
    
    //Function to check member added image or not
    public function actionCheckImageExit($member_id){
        $result = Image::find()->where(['member_id' => $member_id])->all();
        $count = count($result);
        if($count > 0)
        {
            return [
                'message' => 'exit',
                'number' => $count
            ];
        }else {
            return [
                'message' => 'not exit',
                'number' => 0
            ];
        }
    }
    
    public function actionUpdateImage(){
        if(isset($_POST['member_id']))
        {
            $member_id = $_POST['member_id'];
        }
        if(isset($_POST['avatar']))
        {
            $avatar = $_POST['avatar'];
            $count = Image::updateAll([
                'avatar' => $avatar,
            ],[ 'member_id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
        
        if(isset($_POST['image1']))
        {
            $image1 = $_POST['image1'];
            $count = Image::updateAll([
                'image1' => $image1,
            ],[ 'member_id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
        
        if(isset($_POST['image2']))
        {
            $image2 = $_POST['image2'];
            $count = Image::updateAll([
                'image2' => $image2,
            ],[ 'member_id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
        
        if(isset($_POST['image3']))
        {
            $image3 = $_POST['image3'];
            $count = Image::updateAll([
                'image3' => $image3,
            ],[ 'member_id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
        
        if(isset($_POST['image4']))
        {
            $image4 = $_POST['image4'];
            $count = Image::updateAll([
                'image4' => $image4,
            ],[ 'member_id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
        
        if(isset($_POST['image5']))
        {
            $image5 = $_POST['image5'];
            $count = Image::updateAll([
                'image5' => $image5,
            ],[ 'member_id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
        
        if(isset($_POST['image6']))
        {
            $image6 = $_POST['image6'];
            $count = Image::updateAll([
                'image6' => $image6,
            ],[ 'member_id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
    }
    
    public function actionGetMemberImage($member_id){
        return Image::find()->where(['member_id' => $member_id])->one();
    }
}
?>