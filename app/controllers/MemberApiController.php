<?php
namespace app\controllers;
use yii\rest\ActiveController;
use \yii\helpers\ArrayHelper;
use yii\filters\Cors;
use app\models\Member;
use yii\data\ActiveDataProvider;

class MemberApiController extends ActiveController{
    public $modelClass = 'app\models\Member';
    
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
            ]
        ], parent::behaviors());
    }
    
    public function actionCheckUniqueLoginFacebook($facebook_id){
        //Check exit facebook_id in member table
        $member =   Member::find()->where(['facebook_id' => $facebook_id])->one();
        $count  =   count($member);
        if($count > 0)
        {
            
            return [
                'message'   =>  'exit',
                'id'        =>  $member['id'],
                'gender'    =>  $member['gender']
            ];

            
        }else{
            return ['message' => 'not exit'];
        }
    }
    
    public function actionUpdateFacebookMember(){
        if(isset($_POST['address']))
        {
            $address = $_POST['address'];
        }else
        {
            $address = NULL;
        }
        if(isset($_POST['name']))
        {
            $name = $_POST['name'];
        }else
        {
            $name = NULL;
        }
        if(isset($_POST['email']))
        {
            $email = $_POST['email'];
        }else
        {
            $email = NULL;
        }
        if(isset($_POST['gender']))
        {
            $gender = $_POST['gender'];
        }else
        {
            $gender = NULL;
        }
        if(isset($_POST['birthday']))
        {
            $birthday = $_POST['birthday'];
        }else
        {
            $birthday = NULL;
        }
        if(isset($_POST['tel']))
        {
            $tel = $_POST['tel'];
        }else
        {
            $tel = NULL;
        }
        if(isset($_POST['job']))
        {
            $job = $_POST['job'];
        }else
        {
            $job = NULL;
        }
        if(isset($_POST['personalities']))
        {
            $personalities = $_POST['personalities'];
        }else
        {
            $personalities = NULL;
        }
        if(isset($_POST['educational_level']))
        {
            $educational_level = $_POST['educational_level'];
        }else
        {
            $educational_level = NULL;
        }
        if(isset($_POST['facebook_id']))
        {
            $facebook_id = $_POST['facebook_id'];
        }else
        {
            $facebook_id = NULL;
        }
        if(isset($_POST['about_yourself']))
        {
            $about_yourself = $_POST['about_yourself'];
        }else
        {
            $about_yourself = NULL;
        }
        
        $count = Member::updateAll([
            'name'  =>  $name,
            'email' =>  $email,
            'gender'=>  $gender,
            'address' => $address,
            'tel'   =>  $tel,
            'job'   =>  $job,
            'personalities' => $personalities,
            'about_yourself'=> $about_yourself,
            'birthday'  =>  $birthday,
            'educational_level' => $educational_level
        ], ['facebook_id' => $facebook_id]);
        
        return [
            'row_updated' => $count
        ];
    }
    
    //Function check unique username
    public function actionCheckUniqueUsername($username)
    {
        $result = Member::find()->where(['username' => $username])->one();
        $count = count($result);
        if($count > 0)
        {
            if($result['address'])
            {
                return [
                    'message'   =>  'exit',
                    'id'        =>  $result['id'],
                    'address'   =>  $result['address']
                ];
            }else
            {
                return [
                    'message' => 'exit',
                    'id'    =>  $result['id']
                ];
            }
            
        }else
        {
            return [
                'message' => 'not exit'
            ];
        }
    }
    
    //Function check unique id
    public function actionCheckUnique($id)
    {
        $result = Member::find()->where(['id' => $id])->one();
        $count = count($result);
        if($count > 0)
        {
            if($result['address'])
            {
                return [
                    'message'   =>  'exit',
                    'id'        =>  $result['id'],
                    'address'   =>  $result['address']
                ];
            }else
            {
                return [
                    'message' => 'exit',
                    'id'    =>  $result['id']
                ];
            }
            
        }else
        {
            return [
                'message' => 'not exit'
            ];
        }
    }
    
    //Function Login
    public function actionLoginByApp()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $result = Member::find()
                ->where([
                    'username' => $username,
                    'password' => $password
                ])->one();
        $count = count($result);
        if($count > 0)
        {
            return [
                'message' => 'success',
                'id' => $result['id'],
                'require_information' => $result['require_information'],
                'gender' => $result['gender']
            ];
        }else
        {
            return [
                'message' => 'error'
            ];
        }
    }
    
    //Function get member has id # id that received from client
    public function actionGetContact($id)
    {
        $require_information_member = Member::find()->with('requireInformation')->where(['id' => $id])->one()['requireInformation'][0];
        $column_sql = [];
        foreach($require_information_member as $key => $value)
        {
            if($key == 'gender' && $value != null) //[0]
            {
                $column_sql[] = $key;
            }
            if($key == 'educational_level' && $value != null) //[1]
            {
                $column_sql[] = $key;
            }
            if($key == 'job' && $value != null) //[2]
            {
                $column_sql[] = $key;
            }
            if($key == 'personalities' && $value != null) //[3]
            {
                $column_sql[] = $key;
            }
        }
        
        //Đếm số trường thông tin mà người đó muốn tìm kiếm
        $count_number_require_information = count($column_sql);
        if($count_number_require_information == 1) //Chắc chắn là gender
        {
            $a = $column_sql[0];
            $result = new ActiveDataProvider([
                'query' => Member::find()
                    ->where('id != '.$id)
                    ->andWhere([$a => $require_information_member[$a]])
            ]);
            return $result;
        }
        else if($count_number_require_information == 2)
        {
            $a = $column_sql[0];
            $b = $column_sql[1];
            $result = new ActiveDataProvider([
                'query' => Member::find()
                    ->where('id != '.$id)
                    ->andWhere([$a => $require_information_member[$a]])
                    ->andWhere([$b => $require_information_member[$b]])
            ]);
            return $result;
        }
        else if($count_number_require_information == 3)
        {
            $a = $column_sql[0];
            $b = $column_sql[1];
            $c = $column_sql[2];
            $result = new ActiveDataProvider([
                'query' => Member::find()
                    ->where('id != '.$id)
                    ->andWhere([$a => $require_information_member[$a]])
                    ->andWhere([$b => $require_information_member[$b]])
                    ->andWhere([$c => $require_information_member[$c]])
            ]);
            return $result;
        }
        else if($count_number_require_information == 4)
        {
            $a = $column_sql[0];
            $b = $column_sql[1];
            $c = $column_sql[2];
            $d = $column_sql[3];
            $result = new ActiveDataProvider([
                'query' => Member::find()
                    ->where('id != '.$id)
                    ->andWhere([$a => $require_information_member[$a]])
                    ->andWhere([$b => $require_information_member[$b]])
                    ->andWhere([$c => $require_information_member[$c]])
                    ->andWhere([$d => $require_information_member[$d]])
            ]);
            return $result;
            
        }
    }
    
    public function actionSetRequireInformation()
    {
        if(isset($_POST['member_id']))
        {
            $id = $_POST['member_id'];
            $count = Member::updateAll(
                    ['require_information' => 1], ['id' => $id]
            );
            return [
                'row_updated' => $count
            ];
        }
    }
    
    public function actionUpdateMember()
    {
        if(isset($_POST['member_id'])) //Điều kiện để thực hiện update
        {
            $member_id = $_POST['member_id'];
            
            if (isset($_POST['address'])) {
                $address = $_POST['address'];
            } else {
                $address = NULL;
            }
            if (isset($_POST['name'])) {
                $name = $_POST['name'];
            } else {
                $name = NULL;
            }
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
            } else {
                $email = NULL;
            }
            if (isset($_POST['gender'])) {
                $gender = $_POST['gender'];
            } else {
                $gender = NULL;
            }
            if (isset($_POST['birthday'])) {
                $birthday = $_POST['birthday'];
            } else {
                $birthday = NULL;
            }
            if (isset($_POST['tel'])) {
                $tel = $_POST['tel'];
            } else {
                $tel = NULL;
            }
            if (isset($_POST['job'])) {
                $job = $_POST['job'];
            } else {
                $job = NULL;
            }
            if (isset($_POST['personalities'])) {
                $personalities = $_POST['personalities'];
            } else {
                $personalities = NULL;
            }
            if (isset($_POST['educational_level'])) {
                $educational_level = $_POST['educational_level'];
            } else {
                $educational_level = NULL;
            }
            if (isset($_POST['facebook_id'])) {
                $facebook_id = $_POST['facebook_id'];
            } else {
                $facebook_id = NULL;
            }
            if (isset($_POST['about_yourself'])) {
                $about_yourself = $_POST['about_yourself'];
            } else {
                $about_yourself = NULL;
            }

            $count = Member::updateAll([
                        'name' => $name,
                        'email' => $email,
                        'gender' => $gender,
                        'address' => $address,
                        'tel' => $tel,
                        'job' => $job,
                        'personalities' => $personalities,
                        'about_yourself' => $about_yourself,
                        'birthday' => $birthday,
                        'educational_level' => $educational_level
                            ], ['id' => $member_id]);

            return [
                'row_updated' => $count
            ];
        }
    }
}
?>