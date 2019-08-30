<?php
namespace app\shopadmin\controller;
use \think\Controller;

class Index extends Base
{
	//dashboard
    public function index()
    {
    	// $this-> assign('aa','1');
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

    //layouts
    public function layouts()
    {
    	return $this->fetch();
    }

    //graphs

    public function c3()
    {
    	return $this->fetch();
    }

    //ui elements
    public function typography()
    {
    	return $this->fetch();
    }
    public function icons()
    {
    	return $this->fetch();
    }
    public function draggable_panels()
    {
    	return $this->fetch();
    }
    public function resizeable_panels()
    {
    	return $this->fetch();
    }
    public function buttons()
    {
    	return $this->fetch();
    }
    public function video()
    {
    	return $this->fetch();
    }
    public function tabs_panels()
    {
    	return $this->fetch();
    }
    public function tabs()
    {
    	return $this->fetch();
    }
    public function notifications()
    {
    	return $this->fetch();
    }
    public function helper_classes()
    {
    	return $this->fetch();
    }
    public function badges_labels()
    {
    	return $this->fetch();
    }

    //grid_options
    public function grid_options()
    {
    	return $this->fetch();
    }

    //tables
    public function table_basic()
    {
    	return $this->fetch();
    }
    public function table_data_tables()
    {
    	return $this->fetch();
    }
    public function table_foo_table()
    {
    	return $this->fetch();
    }
    public function jq_grid()
    {
    	return $this->fetch();
    }

    //e-commerce
    public function ecommerce_products_grid()
    {
    	return $this->fetch();
    }
    public function ecommerce_product_list()
    {
    	return $this->fetch();
    }
    public function ecommerce_product()
    {
    	return $this->fetch();
    }
    public function ecommerce_product_detail()
    {
    	return $this->fetch();
    }
    public function ecommerce_cart()
    {
    	return $this->fetch();
    }
    public function ecommerce_orders()
    {
    	return $this->fetch();
    }
    public function ecommerce_payments()
    {
    	return $this->fetch();
    }

    //gallery
    public function basic_gallery()
    {
    	return $this->fetch();
    }
    public function slick_carousel()
    {
    	return $this->fetch();
    }
    public function carousel()
    {
    	return $this->fetch();
    }

    //css animations
    public function css_animation()
    {
    	return $this->fetch();
    }


    public function fl_add()
    {
    	return $this->fetch();
    }
    
    public function arr()
    {
        $a['a'] = 'A';
        $a['b'] = 'B';
        echo is_array($a);
        return json($a);
        
    }

}
