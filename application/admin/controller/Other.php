<?php
namespace app\admin\controller;
use think\Controller;
use gt3sdk\lib\GeetestLib;
use gt3sdk\config\config;
class Other extends Controller
{
	public function search_results()
	{
		return $this->fetch();
	}
	public function lockscreen()
	{
		return $this->fetch();
	}
	public function lnvoice()
	{
		return $this->fetch();
	}
	public function login()
	{
		/*echo ROOT_PATH. '<br>';
		echo dirname(__FILE__) . '<br>';
		echo dirname(dirname(__FILE__));exit;*/


		if(request()->isPost()){
			/*session_start();
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
			        echo '服务器正常{"status":"success"}';
			    } else {
			        echo '服务器正常{"status":"fail"}';
			    }
			} else {  //服务器宕机,走failback模式
			    if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
			        echo '服务器宕机{"status":"success"}';
			    } else {
			        echo '服务器宕机{"status":"fail"}';
			    }
			}


exit;
*/
			$data=input('post.');
			$data['upass']=md5($data['upass']);
			$reg=model('register');
			$result=$reg
				   ->where('email',$data['email'])
				   ->where('upass',$data['upass'])
				   ->find();
			if($result){
				session('uid',$result['id']);
				session('uname',$result['uname']);
				session('email',$result['email']);
				$this->success('登陆成功','index/index');
			}else{
				$this->error('登陆失败','other/login');
			}
		}else{
			return $this->fetch();
		}
	}
	public function gtapi1(){//极验第一次验证API1
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
	public function gtlogin(){
		return $this->fetch('gtlogin');
	}

	public function logout()
	{
		session(null);
		$this->success('退出登陆成功','other/login');
	}
	public function login_two()
	{
		return $this->fetch();
	}
	public function forgot_password()
	{
		return $this->fetch();
	}
	public function register()
	{
		if(request()->isPost()){
			$data=input('post.');
			$data['grade']=0;
			$data['upass']=md5($data['upass']);
			$stu=model('register');
			$stu->data($data,true);
			$result=$stu->allowField(true)->save();
			if($result){
      		  $this->success('添加新闻成功','other/login');
      		}else{
      		  $this->error('添加新闻失败,返回中,请稍等!');
      		}
		}else{
			return $this->fetch();
		}
	}
	public function other_404()
	{
		return $this->fetch();
	}
	public function other_500()
	{
		return $this->fetch();
	}
	public function empty_page()
	{
		return $this->fetch();
	}
	public function getPwd()
	{
		$email = input('post.email');
		$sql = model('xmone')->where('email',$email)->find();
		$id = $sql['id'];
		if(!$id){
			return 'noreg';
		}else{
			$getpsstime = time();
			$uid = $sql['id'];
			$token = md4($uid.$sql['uname'].$sql['upass']);
			$url = "http://www.tp5.com/admin/other/...?email=".$email."$token".$token;
			$time = date('Y-m-d H:i');
			$result = sendmail($time,$email,$url);
			if($result==1){
				$msg = 'xi';
			}else{
				$msg = $result;
			}
			return $msg;
		}
	}
	public function resetPwd(){
		$this->email = I('get.email');
		$this->display();
	}
}