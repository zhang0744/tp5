<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Register;
use PHPMailer\PHPMailer\PHPMailer;
// use Smtp;
class Login extends Controller
{
	public function index()
	{
		return $this->fetch();
	}
	public function sendmail()
	{
		// new PHPMailer();exit;
		$res = SendMail('***@qq.com','发送标题','发送成功了耶');
        if(!$res){
            return $this->error('发送邮件失败');
        }
        return $this->success('发送邮件成功','/');






		// $email = input('post.mail');
		// echo $email;exit;
		/*$email = '1579397900@qq.com';
		$Register = new Register;
		$ux = $Register->where('email',$email)->field('id,uname,upass')->find();
		if(!$ux){
			echo 'noreg';
			exit;
		}else{
			$getpasstime = time();
			$id = $ux['id'];
			$token = md5($id.$ux['uname'].$ux['upass']);
			$url = "http://www.gl.com/admin/login/reset?email=".$email."&token=".$token;
			$time = date('Y-m-d H:i');
			$result = sendmailf($time,$email,$url);
			if($result == true){
				$msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！';
				$Register->save(['getpasstime' => $getpasstime],['id' => $id]);
			}else{
				$msg = $result;
			}
			echo $msg;
		}*/

		// return $this->fetch();
	}
	


}