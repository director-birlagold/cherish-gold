<?php
App::uses('AppController', 'Controller');
/**
 * Discounts Controller
 *
 * @property Discount $Discount
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DiscountsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public $layout='admin';
	public $uses=array('Discount','User','Product','Category');
	
	  public function admin_index() {
							$this->checkadmin();
							$this->Discount->recursive=0;
							/*$this->paginate = array('conditions' => '','order'=>'discount_id DESC');
							$this->set('discounts',$this->Paginator->paginate('Discount'));
							*/
							
							
			if(isset($this->request->data['searchfilter'])){
			$search=array();
			if($this->request->data['cdate']!=''){
				$search[]='cdate='.$this->request->data['cdate'];
			}
			
			if($this->request->data['edate']!=''){
				$search[]='edate='.$this->request->data['edate'];
			}
			if($this->request->data['searchtype']!=''){
				$search[]='searchtype='.$this->request->data['searchtype'];
			}
			if(!empty($search)){
				$this->redirect(array('action'=>'?search=1&'.implode('&',$search)));
			}else{
				$this->redirect(array('action'=>'index'));
			}
		}
			
			
			if(isset($_REQUEST['search'])){
			$search=array();
					
			if(!empty($_REQUEST['cdate']) && (!empty($_REQUEST['edate']))){
				$search=array_merge($search,array('Discount.created_date BETWEEN \''.$_REQUEST['cdate'].'\' AND \''.$_REQUEST['edate'].'\''));
				
			}elseif(!empty($_REQUEST['cdate'])){
				$search=array_merge($search,array('Discount.created_date >='=>$_REQUEST['cdate']));
				
			}elseif(!empty($_REQUEST['edate'])){
				$search=array_merge($search,array('Discount.created_date <='=>$_REQUEST['edate']));
			}
			if(!empty($_REQUEST['searchtype'])){
			$search=array_merge($search,array('Discount.type '=>$_REQUEST['searchtype']));	
				
			}
			
			 $search=array_merge($search);
			 $this->paginate = array('conditions' =>$search,'order'=>'Discount.discount_id DESC');
			$this->set('discounts',$this->Paginator->paginate('Discount'));
			
		}
		else{
			$this->paginate = array('conditions' => '','order'=>'Discount.discount_id DESC');
			$this->set('discounts',$this->Paginator->paginate('Discount'));
		}
		  }
	public function admin_add(){
		$this->checkadmin();
		$users=$this->User->find('all',array('conditions'=>array('status !='=>'Trash','user_type'=>0)));
		$this->set('users',$users);
		$products=$this->Product->find('all',array('conditions'=>array('status !='=>'Trash')));
		$this->set('products',$products);
		$category=$this->Category->find('all',array('conditions'=>array('status !='=>'Trash')));
		$this->set('category',$category);
		
			if($this->request->is('post')){
				if(!empty($this->request->data['Discount']['voucher_code'])){
				$discountvocuchercode=$this->Discount->find('all',array('conditions'=>array('status !='=>'Trash','voucher_code'=>$this->request->data['Discount']['voucher_code'])));
				if(empty($discountvocuchercode)){
					$this->request->data['Discount']['voucher_code']=$this->request->data['Discount']['voucher_code'];
				}else{
					 $this->Session->setFlash("<div class='error msg'>" . __('This Voucher code already exists') . "</div>");
                     $this->redirect(array('controller' => 'discounts', 'action' => 'index'));
				}
							
				}
				
				if(!empty($this->request->data['productname'])){
					//print_r($this->request->data['productname']);exit;
				$this->request->data['Discount']['product_id']=implode(",",$this->request->data['productname']);
				}
				if(!empty($this->request->data['username'])){
					$this->request->data['Discount']['user_id']=implode(",",$this->request->data['username']);
				}
				if(!empty($this->request->data['category'])){
					//pr($this->request->data['category']);exit;
					$this->request->data['Discount']['category_id']=implode(",",$this->request->data['category']);
				}
			
				$this->request->data['Discount']['start_date']=date('Y-m-d',strtotime($this->request->data['Discount']['start_date']));
				$this->request->data['Discount']['expired_date']=date('Y-m-d',strtotime($this->request->data['Discount']['expired_date']));
				$this->request->data['Discount']['created_date']=date("Y-m-d H:i:s");
				$this->request->data['Discount']['status']='Active';
				
				
				$this->Discount->save($this->request->data);
				$this->Session->setFlash('<div class="success msg">Discount has been added successfully.</div>','');
				$this->redirect(array('action'=>'index'));
			}
			
		
	}
	
			 public function admin_edit($id){
				 
							 $this->checkadmin();
						 if (!$this->Discount->exists($id)){
							throw new NotFoundException(__('Invalid Question'));
						}
				$users=$this->User->find('all',array('conditions'=>array('status !='=>'Trash','user_type'=>0)));
				$this->set('users',$users);
				$products=$this->Product->find('all',array('conditions'=>array('status !='=>'Trash')));
				$this->set('products',$products);
				$category=$this->Category->find('all',array('conditions'=>array('status !='=>'Trash')));
				$this->set('category',$category);													
					if ($this->request->is('post') || $this->request->is('put')) {
				$this->request->data['Discount']['discount_id']=$id;
				if(!empty($this->request->data['Discount']['voucher_code'])){
				$discountvocuchercode=$this->Discount->find('all',array('conditions'=>array('status !='=>'Trash','voucher_code'=>$this->request->data['Discount']['voucher_code'],'discount_id !='=>$id)));
				if(empty($discountvocuchercode)){	
				$this->request->data['Discount']['voucher_code']=$this->request->data['Discount']['voucher_code'];
				}else{
				$this->Session->setFlash("<div class='error msg'>" . __('This Voucher code already exists') . "</div>");
                 $this->redirect(array('controller' => 'discounts', 'action' => 'index'));	
				}
				}		
				if(!empty($this->request->data['productname'])){
				$this->request->data['Discount']['product_id']=implode(",",$this->request->data['productname']);
				}
				if(!empty($this->request->data['username'])){
						$this->request->data['Discount']['user_id']=implode(",",$this->request->data['username']);
				}
				$this->request->data['Discount']['start_date']=date('Y-m-d',strtotime($this->request->data['Discount']['start_date']));
				$this->request->data['Discount']['expired_date']=date('Y-m-d',strtotime($this->request->data['Discount']['expired_date']));
				$this->request->data['Discount']['modify_date']=date("Y-m-d H:i:s");
				$this->request->data['Discount']['status']='Active';
				$this->Discount->save($this->request->data);	
				$this->Session->setFlash('<div class="success msg">Discount has been updated successfully.</div>','');
				$this->redirect(array('action'=>'index'));		
											}
					$discount=$this->Discount->find('first',array('conditions'=>array('discount_id'=>$id)));			
					$this->set('discount',$discount);
											
											
			 }
	
	
	
	
	 public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Discount']['discount_id'] = $id;
        $this->request->data['Discount']['status'] = $status;
        $this->Discount->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }
   
	
	 public function admin_delete() {
								$this->checkadmin();				
								if(!empty($this->params['pass']['0'])){
									$this->Discount->id = $this->params['pass']['0'];
									$id = $this->params['pass']['0'];
									if (!$this->Discount->exists()) {
										throw new NotFoundException(__('Invalid Question'));
									}			
									 $this->Discount->delete(array('discount_id'=>$this->params['pass']['0']));
									 $this->Session->setFlash("<div class='success msg'>".__('Discount Details has been deleted successfully')."</div>",'');		
									 $this->redirect(array('action' => 'index'));
								}else{
									$this->Discount->deleteAll(array('discount_id IN ('.implode(",",$this->request->data['action']).')'),false,false);			
									$this->Session->setFlash("<div class='success msg'>".__('Discount Details has been deleted successfully')."</div>",'');		
									$this->redirect(array('action' => 'index'));
								}
							}
	
	
	
}
