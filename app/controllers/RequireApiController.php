<?php
namespace app\controllers;
use yii\rest\ActiveController;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use app\models\RequireInformation;

class RequireApiController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\RequireInformation';
    
    public function behaviors() {
        return ArrayHelper::merge([
            'class' => Cors::className()
        ], parent::behaviors());
    }
    
    public function actionCheckUniqueRequireInformation($member_id)
    {
        $result = RequireInformation::find()->where(['member_id' => $member_id])->one();
        $count = count($result);
        if($count > 0) //Exits
        {
            return [
                'message' => 'exit',
                'id' => $result['id']
            ];
        }else
        {
            return [
                'message' => 'not exit'
            ];
        }
    }
    
    public function actionUpdateRequireInformation()
    {
        if(isset($_POST['member_id']))
        {
            $member_id = $_POST['member_id'];
        }else
        {
            $member_id = NULL;
        }
        
        if(isset($_POST['gender']))
        {
            $gender = $_POST['gender'];
        }else
        {
            $gender = NULL;
        }
        
        if(isset($_POST['job']))
        {
            $job = $_POST['job'];
        }else
        {
            $job = NULL;
        }
        
        if(isset($_POST['educational_level']))
        {
            $educational_level = $_POST['educational_level'];
        }else
        {
            $educational_level = NULL;
        }
        
        if(isset($_POST['personalities']))
        {
            $personalities = $_POST['personalities'];
        }else
        {
            $personalities = NULL;
        }
        
        if(isset($_POST['distance']))
        {
            $distance = $_POST['distance'];
        }else
        {
            $distance = NULL;
        }
        
        $count = RequireInformation::updateAll(
                [
                    'job' => $job,
                    'gender' => $gender,
                    'educational_level' => $educational_level,
                    'personalities' => $personalities,
                    'distance' => $distance
                ], [ 'member_id' => $member_id]
        );
        
        return [
            'row_updated' => $count
        ];
    }
    
    //Function get distance current member
    public function actionGetDistance($member_id)
    {
        $result = RequireInformation::find()->where(['member_id' => $member_id])->one();
        return [
            'distance' => $result['distance']
        ];
    }
    
    //Function get information by member_id
    public function actionGetDetail($member_id)
    {
        $result = RequireInformation::find()->where(['member_id' => $member_id])->one();
        return $result;
    }
}

