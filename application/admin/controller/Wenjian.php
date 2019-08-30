<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Shoptp;
use app\admin\model\Shopxx;
class Wenjian extends Controller
{
    public function index(){
        $this->assign('url','123');
        return $this->fetch();

    }
    public function abc(){//更新商品信息
        //行为
        /*\think\Hook::add('app_init','app\\admin\\behavior\\Test');
        \think\Hook::add('app_inita','app\\admin\\behavior\\Test');
        $params = '123';
        $aa = \think\Hook::listen('app_init',$params);
        // var_dump($aa);
        echo $aa['0'];*/

        if(request()->isPost()){//是否是post方式提交

            $data = input("post.");
            $xxid = $data['id'];//商品id
            $psid = $data['stuid'];//图片id字符串
            $shopxx = new Shopxx;
            $xxdata = $shopxx->where("id",$xxid)->find();
            $dbtid = explode(",",$xxdata['tuid']);//将数据库中的图片id转换成数组
            $pstid = explode(",",$psid);//将post提交过来的图片id转换成数组
            $chaid = array_diff($dbtid,$pstid);//比较两个数组键值的差值,返回差集数组
            // var_dump($dbtid);
            // var_dump($pstid);
            // var_dump($chaid);
            // 删除图片
            foreach ($chaid as $key => $value) {
                $shoptp = new Shoptp;
                $xxdata = $shoptp->where("id",$value)->find();
                $aa = ROOT_PATH . 'public' . DS . 'uploads' . DS . $xxdata['tudz'];//生成图片文件路径
                if(!unlink($aa)){//删除指定文件
                    echo "删除".$aa."失败";
                }else{
                    $shoptp->destroy($value);//删除图片表里指定的数据
                }
            }


            $nd = ""; //新上传文件id
            // $shoptp = new Shoptp;
            //获取新上传文件
            $files = request()->file('file');
            if($files){//判断是否有文件上传

                foreach($files as $file){
                    // 移动到框架应用根目录/public/uploads/ 目录下
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                    if($info){
                        // 成功上传后 获取上传信息
                        // 输出 jpg
                        // echo $info->getExtension(); 
                        // 输出 42a79759f284b767dfcb2a0197904287.jpg
                        // echo $info->getFilename();
                        // $sc[] = ['tudz' => $info->getSaveName()];
                        $dzh = str_ireplace("\\","/",$info->getSaveName());//将地址中的反斜杠替换为正斜杠
                        $shoptp = new Shoptp(['tudz' => $dzh]);
                        $shoptp->save();//将上传的图片地址存到数据库
                        $sc[] = $shoptp->id;//获取自增id
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
                $nd = implode(",",$sc);//将id数组转换为字符串
            }

            if($nd != ""){//判断有没有新增的图片
                $psid = $psid.",".$nd;//将提交的id数据和新上传图片的id合并
            }
            $shopxx->allowField(true)->save(["tuid" => $psid],['id' => $xxid]);//更新数据库
        }else{
            $shopxx = new Shopxx;
            $shoptp = new Shoptp;
            $da = $shopxx->where("id","1")->find();//获取商品信息
            $aa = explode(",",$da['tuid']);//将字符串转换为数组
            $tudz = [];
            foreach ($aa as $key => $value) {
                $tu = $shoptp->where('id',$value)->find();//获取图片信息
                $tudz[] = $tu['tudz'];//将图片地址存为数组
            }
            
            // var_dump($da);exit;
            $this->assign("id",$da['id']);//商品id
            $this->assign("tu",$tudz);//图片地址数组
            $this->assign("tuid",$aa);//图片id数组
            $this->assign("tuids",$da['tuid']);//图片id字符串
            return $this->fetch();
        }
        
    }
    public function arr(){
        
        for ($i=0; $i < 10; $i++) { 
            $a[] = $i;
        }
        var_dump($a);
    }
    public function delete(){
        
        return 123;
    }
}