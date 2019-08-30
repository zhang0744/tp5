<?php
namespace app\shopadmin\controller;
use think\Controller;
use think\auth\Auth;
use think\Loader;
class Base extends Controller
{
    public function _initialize()
    {	
    	if( !session('?user') ) {
    		$this->error('请先登录', url('shopadmin/Login/index'));
    	}
    	// $userRow = session('user');




		/*$auth = new Auth();
		$lj = request()->module().'/'.request()->controller().'/'.lcfirst(request()->action());
		// echo $lj;
		$jg = $auth->check($lj,session('uid'));
		if(!$jg){
			return $this->error("没有权限");
		}*/
	}
	/*
	public function index()
	{
		$lj = request()->module().'/'.request()->controller().'/'.lcfirst(request()->action());
		// $bb = new Loader();
		$abc = Loader::parseName("auth_group_access",1);
		echo "<br>".$abc;
		return "<br><h1>Index</h1>";
	}
	public function add_session()
	{
		session('uname','zh');
		session('uid','1');
	}
	
	public function delete_session()
	{
		session(null);
	}*/
	
}