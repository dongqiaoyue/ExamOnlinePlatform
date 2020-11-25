<?php

namespace app\modules\aid\controllers;
use app\models\teachplan\Teachingclassmannage;
use app\models\aid\Staticmodulepercent;
use app\models\aid\Module;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use app\models\aid\Gradescoreset;
use yii\rest\ActiveController;

//模块比例
class ModuleProportionController extends \app\controllers\BaseController
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {

    	$m_Dic = new TbcuitmoonDictionary();
    	$get=\Yii::$app->request->get();
        $com= new commonFuc;
        $AllModule=new Staticmodulepercent();
        $gradescore = '';
        $AllClass='';
        $newModule='';
        $otherModule=array();
        $classI='';
       	$choice1='请选择学期';
    	$choice2='请选择计划班';
        //如果指定了学期，就获取班级信息
        if(isset($get['term']))
        {
            $choice1=$get['term'];
            $AllClass=Teachingclassmannage::find()->where(
                ['Term'=>$get['term'],
                'TeacherName'=>\Yii::$app->session->get('UserName'),
                'CourseID'=>\Yii::$app->session->get('courseCode')
                ])->asArray()->all();
        }
        //如果指定了TeachingID，就获取相关的信息
        if(isset($get['classInfo']))
        {
            //ABCD比例
            $gradescore=Gradescoreset::find()->where('TeachingClassID=:TeachingClassID',[':TeachingClassID'=>$get['classInfo']])->orderBy('GradeName ASC')->asArray()->all();
            //static 模块
            $AllModule=Staticmodulepercent::find()->where('TeachingClassId=:TeachingClassId',[':TeachingClassId'=>$get['classInfo']])->asArray()->one();
            //教学班级信息
            $classI=Teachingclassmannage::find()->where('TeachingClassId=:TeachingClassId',[':TeachingClassId'=>$get['classInfo']])->asArray()->one();
            //其他 模块
            $otherModule=Module::find()->where('TeachingClassId=:TeachingClassId',[':TeachingClassId'=>$get['classInfo']])->asArray()->all();
            //计划班选择
            $choice2=$classI['TeachingName'];
        }
        //新StaticModule
        if($AllModule==NULL)
        {
            $AllModule['StaticID']=$com->create_id();
            if(isset($get['classInfo']))
                $AllModule['TeachingClassID']=$get['classInfo'];
        }
        //新Module
        if($newModule==NULL)
        {
            $newModule['ModuleID']=$com->create_id();
            if(isset($get['classInfo']))
                $newModule['TeachingClassID']=$get['classInfo'];
        }
        //新Gradescoreset
        if($gradescore==NULL)
        {
            $x=array('A','B','C','D','E');
            for($i=0; $i<5; $i++)
            {
                $gradescore[$i]=new Gradescoreset();
                $gradescore[$i]['SetID']=$com->create_id();
                $gradescore[$i]['GradeName']=$x[$i];
                if(isset($get['classInfo']))
                    $gradescore[$i]['TeachingClassID']=$get['classInfo'];
            }
        }
        //var_dump($gradescore);
        return $this->render('index',[
            'term' => $m_Dic->getDictionaryList('学期'),
            'classInfo'=>$AllClass,
            'choice1'=>$choice1,
            'choice2'=>$choice2,
            'teachingClass'=>$classI,
            'AllModule'=>$AllModule,
            'otherModules'=>$otherModule,
            'Module'=>$newModule,
            'AllGradeS'=>$gradescore,
            ]);
    }
    //添加module
    public function actionAddmodule()
    {
        $post=\Yii::$app->request->post();
        $new_module=new Module();
        $com=new commonFuc();
        $new_module['ModuleID']=$com->create_id();
        if(isset($post['Module']))
        {
            if($new_module->load($post) && $new_module->save())
                echo "添加成功";  
            else
                echo "添加失败";
        }
        
    }
    
    //更新module
    public function actionUpdatemodule()
    {
        $AllModule=new Staticmodulepercent();
        if(\Yii::$app->request->isPost)
        {
            $post=\Yii::$app->request->post();
            $sum=0;
            //var_dump($post);
            if(isset($post['Staticmodulepercent']))
                foreach ($post['Staticmodulepercent'] as $value)
                    $sum+= is_numeric($value) ? (int)$value : 0;
            foreach ($post as $val)
                $sum+=isset($val['ModulePercent']) && is_numeric($val['ModulePercent']) ? (int)$val['ModulePercent'] : 0;
            if($sum==100)
            {
                foreach ($post as $val)
                {
                    $num=isset($val['ModulePercent'])&&is_numeric($val['ModulePercent']) ? (int)$val['ModulePercent'] : 0;
                    if(isset($val['ModuleID']))
                        Module::updateAll(['ModulePercent'=>$num],['ModuleID'=>$val['ModuleID']]);
                }
                if(isset($post['Staticmodulepercent']['StaticID']) && $AllModule->load($post))
                {
                    $tmp=Staticmodulepercent::find()->where('StaticID=:StaticID',[':StaticID'=>$post['Staticmodulepercent']['StaticID']])->one();
                    !$tmp ? $AllModule->save() : $AllModule->updateAll($post['Staticmodulepercent'],['StaticID'=>$post['Staticmodulepercent']['StaticID']]);
                }
                    
            }
        }
        echo "更新完成";
    }
    //删除module
    public function actionDeletemodule()
    {
        $tmp='';
        if(\Yii::$app->request->isGet)
        {

            $get=\Yii::$app->request->get();
            if(isset($get['ModuleID']) && isset($get['ModulePercent']) && $get['ModulePercent']==0)
            {
                $tmp=Module::find()->where('ModuleID=:ModuleID',[':ModuleID'=>$get['ModuleID']])->one();
                if($tmp!=NULL)
                {
                    Module::deleteAll('ModuleID=:ModuleID',[':ModuleID'=>$get['ModuleID']]);
                    echo "删除成功";
                }else{
                    echo "删除失败";
                }
            }
        }
    }
    
    //更新和添加
    public function actionUpdategrade()
    {
        $tmp='';
        $obj= new Gradescoreset();
        if(\Yii::$app->request->isPost)
        {
            $post=\Yii::$app->request->post();
            //var_dump($post);
            foreach ($post as $val)
            {
                if(isset($val['SetID']))
                {
                    //var_dump($val);
                    $tmp='';
                    $tmp=Gradescoreset::find()->where('SetID=:SetID',[':SetID'=>$val['SetID']])->one();
                    if($tmp==NULL)
                    {
                        $obj['SetID']=$val['SetID'];
                        $obj['GradeName']=$val['GradeName'];
                        $obj['TeachingClassID']=$val['TeachingClassID'];
                        $obj['Score']= (int)$val['Score'] ? (int)$val['Score'] : 0;
                        if($obj->save())
                            echo "更新成功";
                        else
                            echo "更新失败";
                        $obj=new Gradescoreset();
                    }
                    else
                    {
                        $val['Score'] = (int)$val['Score'];
                        if(Gradescoreset::updateAll($val,['SetID'=>$val['SetID']]))
                            echo "更新成功";
                    }
                    
                }
            }
        }
        else
            echo "更新错误";
    }

}
