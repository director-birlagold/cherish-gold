<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');



/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

class AppController extends Controller {
    public $components = array('Cookie', 'Session');
    public $helpers = array('Session');

    /**
     * This controller does not use a model
     *
     * @var array
     */

    public $uses = array('Adminuser', 'Price','Emaillist', 'Emailcontent', 'Shoppingcart', 'Smstemplate', 'Userroles', 'Userroles', 'Roleperm', 'Vendor', 'User');

	public function beforeRender() {
//		define('BASE_URL','/cherishgold/');

		$price = $this->Price->find('first', array('conditions' => array('type' => "Metals", 'metal_id ' => 1, 'metalcolor_id' => 2,'metal_fineness' => '995')));
		$price['Price']['price'] = ($price['Price']['price'] * 92) / 100;
		$this->Session->write("gold",$price['Price']['price']);
	}

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Cookie->name = 'view';
        $this->Cookie->time = 3600;  // or '1 hour'
        $this->Cookie->path = '/';
        $this->Cookie->domain = 'runnable.com';
        $this->Cookie->secure = false;
        $this->Cookie->key = '39lbkutg1i2l0kta6785d8qki5';
        $this->Cookie->httpOnly = true;

        if($this->Session->check('loginid') && $this->layout == 'frontend' && !$this->Session->check('User.wishlist_count')){
            $this->loadModel('Whislist');
            $wishlist_count = $this->Whislist->find('count',array(
                                        'conditions'=>array('Whislist.user_id'=>$this->Session->read('loginid'))
                                        ));
            $this->Session->write('User.wishlist_count',$wishlist_count);
        }
    }



    protected function str_rand($length = 8, $output = 'alphanum') {
        // Possible seeds
        $outputs['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
        $outputs['numeric'] = '0123456789';
        $outputs['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
        $outputs['hexadec'] = '0123456789abcdef';
        // Choose seed
        if (isset($outputs[$output])) {
            $output = $outputs[$output];
        }

        // Seed generator
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand($seed);
        // Generate
        $str = '';
        $output_count = strlen($output);
        for ($i = 0; $length > $i; $i++) {
            $str .= $output{mt_rand(0, $output_count - 1)};
        }
        return $str;
    }



    public function admin_logincheck() {
        if ($this->Session->read('Adminuser'))
            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
    }



    public function dateformat() {
        $da = $this->Dformate->find('list', array('conditions' => array('status' => 'Active'), 'fields' => array('did', 'php')));
        $date = array();
        foreach ($da as $val => $key) {
            $date = $date + array($val => date($key));
        }

        $this->set('dformat', $date);
    }

	

	public function getByUsername($user_id){
        $cust_query = $this->Roleperm->find('all', array(
			'joins' => array(
				array(
					'table' => 'permissions',
					'alias' => 'PermissionJoin',
					'type' => 'LEFT',
					'conditions' => array(
						'PermissionJoin.perm_id = Roleperm.perm_id'
					)
				)
			),
			'conditions' => array(
				'Roleperm.role_id' => $user_id
			),
			'fields' => array('PermissionJoin.*', 'Roleperm.*'),
			'order' => 'Roleperm.id DESC'
		));

		
		$user_privilage = array();
		for ($i=0; $i<sizeof($cust_query); $i++) {
			//$user_privilage[]
			$pername = $cust_query[$i]['PermissionJoin']['perm_desc'];
			$user_privilage[$pername] = true;
		}
		return $user_privilage;
		/*echo "<pre>";
		print_r($cust_query);
		exit;*/
	}

	

	// check if user has a specific privilege
    public function hasPrivilege($perm){
		$user_privilage = $_SESSION["Permissions"]["user_privilage"];
		//print_r($user_privilage[$perm]);
     	return isset($user_privilage[$perm]);       
    }



    public function checkadmin() {
        if (!$this->Session->read('Adminuser')) {
			//echo "here 1";
			//exit;
            $this->redirect(array('controller' => 'login', 'action' => 'index'));
        } else {
			//echo "here 2";
			//echo $this->Session->read('User.login_type');
			//exit;
			if( $this->Session->read('User.login_type') == 'Vendor'){
				$admindetails1 = $this->Vendor->find('first', array('conditions' => array('user_id' => $this->Session->read('Adminuser.admin_id'), 'status' => 'Active')));
				$adminuserdetails1 = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('Adminuser.admin_id'), 'status' => 'Active')));
				$check1['User']['login_type'] = 'Vendor';
				$check1['Adminuser']['admin_id'] = $adminuserdetails1['User']['user_id'];
				$check1['Adminuser']['admin_name'] = $admindetails1['Vendor']['Company_name'];
				$check1['Adminuser']['vendor_id'] = $admindetails1['Vendor']['vendor_id'];
				$check1['Adminuser']['role_id'] = $this->Session->read('Adminuser.role_id');
				$check1['Adminuser']['username'] = $adminuserdetails1['User']['email'];
				$check1['Adminuser']['user_type'] = $adminuserdetails1['User']['user_type'];
				$admindetails = $check1;
			}else{
				$admindetails = $this->Adminuser->find('first', array('conditions' => array('admin_id' => $this->Session->read('Adminuser.admin_id'), 'status' => 'Active')));
			}

            if (!empty($admindetails)) {
                $this->set('sessionadmin', $admindetails);
            } else {
                $this->redirect(array('action' => 'logout'));
            }
        }
    }



    public function logout() {
        $this->Session->delete('loginid');
        $this->Session->delete('User');
        $this->Session->delete('Order');
        $this->Session->delete('cart_process');
        $sesuser = $this->Session->read('socialsite');
        if ($sesuser == "facebook") {
            App::import('Vendor', 'Facebook', array('file' => 'Fb/facebook.php'));
            $facebook = new Facebook(array(
                'appId' => FACEBOOK_API_KEY,
                'secret' => FACEBOOK_API_SECRET,
            ));

            $accesstocken = $facebook->getAccessToken();
            $params = array('next' => BASE_URL, 'access_token' => $accesstocken);
            $logoutUrl = $facebook->getLogoutUrl($params); // $params is optional.	
            $facebook->destroySession();
            $this->redirect($logoutUrl);
        }
        $this->redirect(array('controller' => 'signin', 'action' => 'index'));
    }



    public function admin_logout() {
        $this->Session->delete('Adminuser');
        $this->redirect(array('controller' => 'login', 'action' => 'index'));
    }



    protected function mailsend($fromname, $from, $to, $subject, $message, $cc = NULL, $attachment = 0, $attachmentsfiles = '', $template = 'default', $layout = 'default') {
        App::uses('CakeEmail', 'Network/Email');

//       $Email = new CakeEmail();
//       $Email->from('arulmani090@gmail.com');
//       $Email->to('softwaretesterid@gmail.com');
//       $Email->subject('About');
//       $Email->send('My message');
//       return true;
        $email = new CakeEmail();
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.3') {
            $email->config('smtp');
        }

        $email->emailFormat('html');
        $email->from(array(trim($from) => $fromname));
        if ($attachment == 1) {
            $attachs = explode(",", $attachmentsfiles);
            $attachments = array();
            foreach ($attachs as $attach) {
                $attachments[] = $attach;
            }
            $email->attachments($attachments);
        }

        $email->template($template, $layout);
        $email->to(trim($to));
        $email->replyTo(trim($from));
        if ($cc != '' || $cc != NULL) {
            $email->cc($cc);
        }

        $email->subject($subject);
        $email->layout = $layout;
        $email->send($message);
        $email->reset();
    }

    // Function to get the client ip address
    protected function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        
        return $ipaddress;
    }

    public function usercheck() {
        $check = $this->Session->read('loginid');
        if (empty($check) && $check != 'True') {
            $this->redirect(array('controller' => 'signin', 'action' => 'index'));
        }

        $user = $this->User->find('first', array('conditions' => array('user_id' => $this->Session->read('User.user_id'), 'status' => 'Active')));
        if (!empty($user)) {
            $this->set('user', $user);
        } else {
            $this->redirect(array('action' => 'logout'));
        }
    }



    public function format($date) {
        return date("Y-m-d", strtotime(str_replace(array("/", ","), array("-", " "), $date)));
    }



    public function getFileExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }

        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }



    public function download($name) {
        $ext = explode('.', $name);
        $this->viewClass = 'Media';
        // Download app/outside_webroot_dir/example.zip
        $params = array(
            'id' => $name,
            'name' => $ext[0],
            'download' => true,
            'extension' => end($ext),
            'path' => 'webroot/img/shoppingrates' . DS
        );
        $this->set($params);
    }


    public function sendsms($phone, $message) {
        if (ENABLE_SMS) {
            include 'sendsms.php';
            $sendsms = new sendsms(SMS_SITE, SMS_METHOD, SMS_API_KEY, SMS_SENDER_ID);
            $sendsms->send_sms($phone, $message, '', 'xml');
        }
    }

    public function get_sms_message($id) {
        $message = '';
        $sms_template = $this->Smstemplate->findBySmsId($id);
        if (!empty($sms_template)) {
            $message = $sms_template['Smstemplate']['content'];
        }
        return $message;
    }

}