<?php
namespace app\admin\controller;
use \think\Controller;

class Index extends Controller
{
    public function index()
    {
    	$this-> assign('aa','1');
     	return $this->fetch();
    }
    public function dashboard_2()  
    {
    	return $this->fetch();
    }
    public function dashboard_3()
    {
    	return $this->fetch();
    }
    public function dashboard_4()
    {
    	return $this->fetch();
    }
    public function dashboard_5()
    {
    	return $this->fetch();
    }
    public function layouts()
    {
    	return $this->fetch();
    }
}
