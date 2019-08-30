<?
namespace app\shopadmin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'email|邮箱'  =>  'require|email|token',
        'upass|密码' =>  'require',
    ];

}