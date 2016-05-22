<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::parseExtensions('xml');
Router::connect('/', array('controller' => 'webpages', 'action' => 'index'));
Router::connect('/admin/', array('controller' => 'login', 'action' => 'index','admin'=>true));
Router::connect('/admin', array('controller' => 'login', 'action' => 'index','admin'=>true));
//Router::connect('/category/*', array('controller' => 'webpages', 'action' => 'jewellery'));
//Router::connect('/subcategory/*', array('controller' => 'webpages', 'action' => 'category_list'));
Router::connect('/details/*', array('controller' => 'webpages', 'action' => 'product'));
Router::connect('/about-us', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/disclaimer', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/certified-jewelers', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/delivery-details', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/jewellery-experience', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/returns-policy', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/transparent-pricing', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/privacy-policy', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/faq-s', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/contact-us', array('controller' => 'contactuses', 'action' => 'contact'));
Router::connect('/management-team', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/benefit-advantages', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/customer-testimonials', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/payment-option', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/shipping-policy', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/terms-and-conditions', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/identify-your-ring-size', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/diamonds-guide', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/jewellery-care', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/site-map', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/locate-out-outlet', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/how-to-identify-fake-jewellery', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/account-details', array('controller' => 'staticpages', 'action' => 'staticpage'));
Router::connect('/jewellery', array('controller' => 'webpages', 'action' => 'jewellery'));
Router::connect('/orders/delete/*', array('controller' => 'orders','action'=>'delete'));
Router::connect('/product/*', array('controller' => 'webpages','action'=>'product'));
Router::connect('/shoppingcarts/remove/*', array('controller' => 'shoppingcarts','action'=>'remove'));
Router::connect('/signin/profile/*', array('controller' => 'signin','action'=>'profile'));


//nwely added
Router::connect('/franchiseeproducts/edit/:id', array('controller' => 'franchiseeproducts', 'action' => 'productedit'), array('pass' => array('id')));
Router::connect('/franchiseeproducts/view/:id', array('controller' => 'franchiseeproducts', 'action' => 'view'), array('pass' => array('id')));
Router::connect('/orders/pdf/:id', array('controller' => 'orders', 'action' => 'orderpdf'), array('pass' => array('id')));
Router::connect('/orders/mail/:id', array('controller' => 'orders', 'action' => 'send_email'), array('pass' => array('id')));

Router::connect('/testimonials', array('controller' => 'webpages', 'action' => 'testimonials'));
Router::connect('/customersay', array('controller' => 'webpages', 'action' => 'customersay'));


Router::connect('/bgp-plan/registration', array('controller' => 'customermaster', 'action' => 'registration'));
Router::connect('/bgp-plan/thankyou', array('controller' => 'customermaster', 'action' => 'thankyou'));
Router::connect('/customer/dashboard', array('controller' => 'customermaster', 'action' => 'dashboard'));
Router::connect('/customer/edit', array('controller' => 'customermaster', 'action' => 'edit'));
Router::connect('/customer/editdetails', array('controller' => 'customermaster', 'action' => 'editdetails'));
Router::connect('/customer/relation-manager', array('controller' => 'customermaster', 'action' => 'manager'));
Router::connect('/customer/generateForm_dn', array('controller' => 'customermaster', 'action' => 'generateForm_dn'));
Router::connect('/customer/generateAC', array('controller' => 'customermaster', 'action' => 'generateAC'));
Router::connect('/pay', array('controller' => 'payatom', 'action' => 'pay'));
Router::connect('/pay/response', array('controller' => 'payatom', 'action' => 'response'));
Router::connect('/generateXML', array('controller' => 'customermaster', 'action' => 'generateXML'));


////$url =  $_SERVER['REQUEST_URI'];
//$url =  explode('?',$_SERVER['REQUEST_URI']);
//$url=$url[0];
//$url = explode('/', $url);
//
//$category="";
//$sub_category="";
//$prodcut_name="";
//
//if(isset($url[2]))
//$category=$url[2];
//if(isset($url[3]))
//$sub_category=$url[3];
//if(isset($url[4]))
//$prodcut_name=$url[4];

$url =  $_SERVER['REQUEST_URI'];
$category="";
$sub_category="";
$prodcut_name="";
if(strpos($url,'?') !== false){
    $url =  explode('?',$_SERVER['REQUEST_URI']);
    $url=$url[0];
}
 
 $url = explode('/', $url);
if(isset($url[2]) && strpos($url[2],'type')===false)
{
    $explode_arr = explode("-",$url[2]);
    
    if(count($explode_arr)>1)
    {
    	$category=$explode_arr[0];
        $type=$explode_arr[1];
    }
    else
    {
       $category=$url[2];
    }
}
if(isset($url[3]) && strpos($url[3],'type')===false)
    $sub_category=$url[3];
if(isset($url[4]) && strpos($url[4],'type')===false)
    $prodcut_name=$url[4]; 

/* $url = explode('/', $url);
if(isset($url[1]) && strpos($url[1],'type')===false)
{
    $explode_arr = explode("-",$url[1]);
    
    if(count($explode_arr)>1)
    {
    	$category=$explode_arr[0];
        $type=$explode_arr[1];
    }
    else
    {
       $category=$url[1];
    }
}
if(isset($url[2]) && strpos($url[2],'type')===false)
    $sub_category=$url[2];
if(isset($url[3]) && strpos($url[3],'type')===false)
    $prodcut_name=$url[3]; */



if(!empty($prodcut_name) && $sub_category!='shipping_address'){		
		App::import('Model', 'Product');
		$page = new Product();
		$prodcut_name=$prodcut_name;		
		$spage = $page->find('first',array('conditions'=>array('product_id'=>$prodcut_name)));			
		if(!empty($spage))
		{
		Router::connect('/*', array('controller' => 'webpages', 'action' => 'product_details'));
		}
	}

	else if(!empty($sub_category) && $sub_category!='load_more'){		
		App::import('Model', 'Subcategory');
		$page = new Subcategory();
		$spage = $page->find('first',array('conditions'=>array('link'=>$sub_category)));

		if(!empty($spage))
		{	
		Router::connect('/*', array('controller' => 'webpages', 'action' => 'product'));
		}
	}	
	
	else if(!empty($category)){		
		App::import('Model', 'Category');
		$page = new Category();
		$spage = $page->find('first',array('conditions'=>array('link'=>$category)));		
		if(!empty($spage))
		{
		Router::connect('/*', array('controller'=>'webpages','action'=>'category_list'));
		}
	}
	
//Router::connect('/admin/:controller/:action', array('admin'=>true));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
