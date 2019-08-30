<?php
namespace app\shopadmin\controller;
use think\Controller;
use think\auth\Auth;
use think\Loader;
use gt3sdk\lib\GeetestLib;
use think\Validate;
use app\shopadmin\model\Register;
// use app\shopadmin\validate\User;
class Login extends Controller
{

    public function index(){
    	if( session('?userinfo') ) {//判断有没有用户登录
    		$this->redirect( url('shopadmin/index/index') );
    	}
    	return $this->fetch();//打开登陆界面
    }
    public function login(){
 
    			$validate = validate('user');
    	exit;

    	//二次滑动验证
    	session_start();
		require_once EXTEND_PATH . 'gt3sdk/config/config.php';		
		$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
		$data = array(
		        "user_id" => $_SESSION['user_id'], # 网站用户id
		        "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
		        "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
		    );
		if ($_SESSION['gtserver'] == 1) {   //服务器正常
		    $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
		    if ($result) {
		        // echo '服务器正常{"status":"success"}';
		    } else {
		    	$this->error('验证错误');
		        // echo '服务器正常{"status":"fail"}';
		    }
		} else {  //服务器宕机,走failback模式
		    if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
		        // echo '服务器宕机{"status":"success"}';
		    } else {
		    	$this->error('验证错误');
		        // echo '服务器宕机{"status":"fail"}';
		    }
		}
		$data= ['email'=>input('post.email'),
				'upass'=>input('post.upass')
		];
		$validate = Loader::validate('admin/aaa');
		// if(!$validate->check($data)){
		//     echo $validate->getError();
		// }
exit;
		$reg = new Register();//实例化用户表
		$data = $reg->where('email', input('post.email'))->where('upass',md5(input('post.upass')))->find();
		if(empty($data)){
			$this->error('邮箱或者密码错误');
		}
		unset($data['upass']);//删除密码
		session('user',$data);
		$this->success('登陆成功',url('shopadmin/index/index'));
    }

    /**
     * 退出登录
     */
    public function out()
    {
    	session(null);
    	return $this->success('退出成功！', url('shopadmin/login/index'));
    }

	//极验第一次验证API1
    public function gtapi1(){
    	require_once EXTEND_PATH . 'gt3sdk/config/config.php';
    	$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
    	session_start();
    	$data = array(
    			"user_id" => "test", # 网站用户id
    			"client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
    			"ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
    		);
    	$status = $GtSdk->pre_process($data, 1);
    	$_SESSION['gtserver'] = $status;
    	$_SESSION['user_id'] = $data['user_id'];
    	echo $GtSdk->get_response_str();
    }
	

	public function forgot_password(){
		//忘记密码
		return $this->fetch();
	}
	public function fmail(){
		//发送邮件
		$email = input('post.mail');
		$Register = new Register;
		$ux = $Register->where('email',$email)->field('id,uname,upass')->find();
		if(!$ux){
			return 'noreg';
		}else{
			$getpasstime = time();
			$id = $ux['id'];
			$token = md5($id.$ux['uname'].$ux['upass']);
			$url = "http://www.gl.com/shopadmin/login/xgpass?email=".$email."&token=".$token;
			$time = date('Y-m-d H:i');
			$emailbody = "亲爱的".$email."：<br/>您在".$time."提交了找回密码请求。请点击下面的链接重置密码（按钮1小时内有效）。<br/><a href='".$url."' target='_blank'>".$url."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。<br/>如果您没有提交找回密码请求，请忽略此邮件。";
			$result = SendMail($email,'重置密码',$emailbody);//sendmailf($time,$email,$url);
			if($result == true){
				$msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
				$Register->save(['getpasstime' => $getpasstime],['id' => $id]);
			}else{
				$msg = '发送失败';
			}
			echo $msg;
		}

	}

	public function xgpass(){//处理重置密码链接
		if(!request()->isGet()){
			return "<h1>链接错误</h1>";
		}
		if(!input('?get.eamil') && !input('?get.token')){
			return "<h1>链接错误</h1>";
		}

		$email = input('get.email');
		$token = input('get.token');
		$Register = new Register;//实例化用户表
		$ux = $Register->where('email',$email)->field('id,uname,upass,getpasstime')->find();
		if(empty($ux)){
			return "<h1>链接错误</h1>";
		}
		//获取提交重置时间
		$utime = $ux['getpasstime'];
		//获取现在时间戳
		$xtime = time();
		//判断是否超过1小时限制
		if(($xtime - $utime) > 3600){
			return "<h1>此链接已失效,链接超时</h1>";
		}
		//密令验证
		$xintoken = md5($ux['id'].$ux['uname'].$ux['upass']);
		if(!($token == $xintoken)){
			return "<h1>链接错误</h1>";
		}

		$this->assign('data',$ux);
		return $this->fetch();

	}
	public function upass(){
		if(!request()->isPost()){
			$this->error('类型错误');
		}

		$id = input('post.id');
		$pass = md5(input('post.pass'));
		$upass = md5(input('post.upass'));

		$result = $this->validate(
		    [
		        'pass'  => $pass,
		        'upass' => $upass,
		    ],
		    [
		        'pass|密码'	=> 'require|confirm:upass|token',
				'upass|密码'	=> 'require',
		    ]);
		if(true !== $result){
		    // 验证失败 输出错误信息
		    return $this->error($result);
		}

		$Register = new Register;//实例化用户表
		$jg = $Register->save(['upass' => $upass],['id' => $id]);
		if ($jg) {
			session(null);
			$this->success('修改成功',url('shopadmin/login/index'));
		}else{
			$this->error('修改失败');
		}
	}


}