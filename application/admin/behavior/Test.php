<?php
namespace app\admin\behavior;

class Test 
{
	public function run(&$params)
    {
        // 行为逻辑
        return "run返回文字";
    }

    //应用初始化标签位
    public function appInit(&$params)
    {
    	return "<h1>appInit应用初始化标签位返回文字,$params</h1>";
    }
    //应用结束标签位
    public function appEnd(&$params)
    {
    	return "appEnd返回文字";
    }    
}