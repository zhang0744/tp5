<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use abc\Abc;


// 应用公共文件
function sendmailf($time,$email,$url){

	$smtpserver = "smtp.163.com"; //SMTP服务器
    $smtpserverport = 25; //SMTP服务器端口
    $smtpusermail = "zhanghao_7811@163.com"; //SMTP服务器的用户邮箱
    $smtpuser = "zhanghao_7811@163.com"; //SMTP服务器的用户帐号
    $smtppass = "zhanghao7811"; //SMTP服务器的用户密码                       abkfqdxuleorbagd
    $smtp = new Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $emailtype = "HTML"; //信件类型，文本:text；网页：HTML
    $smtpemailto = $email;
    $smtpemailfrom = $smtpusermail;
    $emailsubject = "gl.com - 找回密码";
    $emailbody = "亲爱的".$email."：<br/>您在".$time."提交了找回密码请求。请点击下面的链接重置密码（按钮24小时内有效）。<br/><a href='".$url."' target='_blank'>".$url."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。<br/>如果您没有提交找回密码请求，请忽略此邮件。";
    $smtp->debug = true;//是否显示发送的调试信息
    $rs = $smtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype);
	return $rs;
}


 /**
  * 配置youji
  */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer的自动加载器
// require 'vendor/autoload.php';

function SendMail($address,$title,$message){
    // vendor ('phpmailer.phpmailer.src.PHPMailer');
    $mail = new PHPMailer();
     // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet='UTF-8';
    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address);
    // 设置邮件正文
    $mail->Body=$message;
    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From='zhanghao_7811@163.com';
    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName='张hao';
    // 设置邮件标题
    $mail->Subject=$title;
    // 设置SMTP服务器。
    $mail->Host='smtp.163.com';
    // 设置为"需要验证"
    $mail->SMTPAuth=true;
    //smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Username='zhanghao_7811@163.com';
    //smtp登录的密码 使用生成的授权码 你的最新的授权码
    $mail->Password='zhanghao7811';
    //smtp端口号
    $mail->Port    = 25; 
    // 是否以HTML文档格式发送
    $mail->isHTML(true);
    // 调试模式输出 
    $mail->SMTPDebug = 0;
    // 发送邮件。    成功返回true或false
   return($mail->Send());
}

