<?php
App::uses('AppController', 'Controller');
/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class ProductsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Session','Image');
	
	public $uses=array('Product','Vendorcontact','Vendor','Category','Subcategory','Productstone','Productimage','Size','Metalcolor','Metal','Diamond','Clarity','Color','Carat','Shape','Settingtype','Purity','Productmetal','Productgemstone','Productdiamond','Gemstone');
	public $layout='admin';
   
	public function admin_index() {
		$this->checkadmin();
		$this->Product->recursive=0;
		
		if(isset($this->request->data['searchfilter'])){
		$search=array();
		if($this->request->data['cdate']!=''){
		$search[]='cdate='.$this->request->data['cdate'];
		}if($this->request->data['edate']!=''){
		$search[]='edate='.$this->request->data['edate'];
		}
		if($this->request->data['searchvendorname']!=''){
		$search[]='searchvendorname='.$this->request->data['searchvendorname'];
		}
		if($this->request->data['productname']!=''){
		$search[]='productname='.$this->request->data['productname'];
		}
		if($this->request->data['productcode']!=''){
		$search[]='productcode='.$this->request->data['productcode'];
		}
		if($this->request->data['searchcategory']!=''){
		$search[]='searchcategory='.$this->request->data['searchcategory'];
		}if(!empty($search)){
		$this->redirect(array('action'=>'?search=1&'.implode('&',$search)));
		}else{
		$this->redirect(array('action'=>'index'));
		}
		}
		
		if($this->request->query('search')!=''){
		$search=array();
		$search=array('status !='=>'Trash');	
		if(($this->request->query('cdate')!='') && ($this->request->query('edate')!='')){
		$search=array_merge($search,array('Product.created_date BETWEEN \''.$_REQUEST['cdate'].'\' AND \''.$_REQUEST['edate'].'\''));
		}elseif($this->request->query('cdate')!=''){
		$search['created_date']=$this->request->query('cdate');
		}elseif($this->request->query('edate')!=''){
		$search['created_date']=$this->request->query('edate');
		}
		if($this->request->query('searchvendorname')!=''){
		$vendor=$this->Vendor->find('first',array('conditions'=>array('vendor_id'=>$this->request->query('searchvendorname'))));
		$this->set('vendor',$vendor);
		$search['vendor_id']=$vendor['Vendor']['vendor_id'];
		}if($this->request->query('productname')!=''){
		$search['product_name']=$this->request->query('productname');
		}
		if($this->request->query('productcode')!=''){
		$search['product_code']=$this->request->query('productcode');
		}
		if($this->request->query('searchcategory')!=''){
		//print_r($this->request->query('searchcategory'));exit;
		$search['category_id']=$this->request->query('searchcategory');
		
		}
		$this->paginate = array('conditions' => $search,'order'=>'product_id DESC');
		$this->set('product',$this->Paginator->paginate('Product'));
		
		}else
		{
		$this->paginate = array('conditions' => array('status !='=>'Trash'),'order'=>'product_id DESC');
		$this->set('product',$this->Paginator->paginate('Product'));
		}
		$vendorstatus=$this->Vendor->find('all',array('conditions'=>array('status'=>'Active')));			
		$this->set('vendorstatus',$vendorstatus); 
		$category=$this->Category->find('all',array('conditions'=>array('status !='=>'Trash')));	
		$this->set('category',$category);	
	}


	public function admin_add(){	
		$this->checkadmin();
		$vendorstatus=$this->Vendor->find('all',array('conditions'=>array('status'=>'Active')));			
		$this->set('vendorstatus',$vendorstatus); 
		$category=$this->Category->find('all',array('conditions'=>array('status'=>'Active')));		
		$this->set('categories',$category);
		$metals=$this->Metal->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'metal_id ASC'));			
		$this->set('metal',$metals); 
		$stone=$this->Diamond->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'diamond_id ASC'));			
		$this->set('stone',$stone); 
		$clarity=$this->Clarity->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'clarity_id ASC'));			
		$this->set('clarity',$clarity);
		$colors=$this->Color->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'color_id ASC'));				
		$this->set('colors',$colors);
		$carats=$this->Carat->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'carat_id ASC'));				
		$this->set('carats',$carats);
		$shapes=$this->Shape->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'shape_id ASC'));				
		$this->set('shape',$shapes);
		$type=$this->Settingtype->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'settingtype_id ASC'));			
		$this->set('type',$type); 
		$gem=$this->Gemstone->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'gemstone_id ASC'));			
		$this->set('gem',$gem); 
		if($this->request->is('post')){
		$product=$this->Product->find('first',array('conditions'=>array('vendor_product_code'=>$this->request->data['Product']['vendor_product_code'],'status !='=>'Trash')));
		if(empty($product)){
		if(!empty($this->request->data['Product']['metal_color'])){
		$this->request->data['Product']['metal_color']=implode(",",$this->request->data['Product']['metal_color']);
		}
		$this->request->data['Product']['vendor_id'] =$this->request->data['Product']['vendor_id'];
		$this->request->data['Product']['product_type']=implode(",",$this->request->data['Product']['product_type']);	
			
		$this->request->data['Product']['status'] ='Active';
		if(!empty($this->request->data['Product']['certificate_image']['name'])){
		$this->request->data['Product']['certificate_image']=$this->Image->upload_image_and_thumbnail($this->request->data['Product']['certificate_image'],800,800,215,133,"certificate",'1');
		}else{ $this->request->data['Product']['certificate_image']='';
		}
		$this->request->data['Product']['created_date'] =date('Y-m-d H:i:s');
		$this->request->data['Product']['modify_date'] =date('Y-m-d H:i:s');
		$messages = $this->Product->find('first',array('conditions'=>array('category_id'=>$this->request->data['Product']['category_id'],'status !='=>'Trash'), 'fields' => array('MAX(Product.pid) AS maxid', '*')));
		if (!empty($messages[0]['maxid'])) {
		$tiid = $messages[0]['maxid'] + 1;
		} else {
		$tiid = 1;
		}
		$this->request->data['Product']['pid']=$tiid;
		$projectcode=sprintf("%06d",$tiid);
		$this->request->data['Product']['product_code']=$projectcode;
		$this->Product->save($this->request->data);
		$product_id=$this->Product->getLastInsertID();
		if(!empty($this->request->data['Productmetal'])) {
		if(!empty($this->request->data['Productmetal']['size']))
		{
		foreach($this->request->data['Productmetal']['size'] as $size){
		$this->request->data['Productmetal']['product_id']=$product_id;
		$this->request->data['Productmetal']['type']='Size';
		$this->request->data['Productmetal']['value']=$size;
		$this->request->data['Productmetal']['category_id']=$this->request->data['Product']['category_id'];
		$this->Productmetal->saveAll($this->request->data);
		}}
		if(!empty($this->request->data['Productmetal']['purity']))
		{ 
		foreach($this->request->data['Productmetal']['purity'] as $purity){
		$this->request->data['Productmetal']['product_id']=$product_id;
		$this->request->data['Productmetal']['type']='Purity';
		$this->request->data['Productmetal']['value']=$purity;
		$this->request->data['Productmetal']['category_id']=$this->request->data['Product']['category_id'];
		$this->Productmetal->saveAll($this->request->data);
		}}}
		if($this->request->data['Product']['gemstone']=='Yes') {
		if(!empty($this->request->data['Productgemstone'])) {
		foreach($this->request->data['Productgemstone'] as $product_stone){
		$product_stone['product_id']=$product_id;
		$product_stone['vendor_id']=$this->request->data['Product']['vendor_id'];
		$this->Productgemstone->saveAll($product_stone);				
		}	  }
		}
		if(!empty($this->request->data['Productimage']['image'])){
		foreach($this->request->data['Productimage']['image'] as $image){
		$this->request->data['Productimage']['status']='Active';
		$this->request->data['Productimage']['product_id']=$product_id;
		$this->request->data['Productimage']['imagename']=$this->Image->upload_image_and_thumbnail($image,800,800,215,133,"product",'1');
		$this->Productimage->saveAll($this->request->data);
		}
		}
		if($this->request->data['Product']['stone']=='Yes') {
		foreach($this->request->data['Productdiamond'] as $product_stone){
		$product_stone['product_id']=$product_id;
		$product_stone['vendor_id']=$this->request->data['Product']['vendor_id'];
		$this->Productdiamond->saveAll($product_stone);				
		}}
		$this->Session->setFlash('<div class="success msg">Product save successfully.</div>','default');
		$this->redirect(array('action'=>'index')); 
		}else{
		$this->Session->setFlash('<div class="error msg">Vendor Product Code  already exits.</div>','');
		}
		}

	}
		  public function admin_edit($id){
			$this->checkadmin();
			$vendorstatus=$this->Vendor->find('all',array('conditions'=>array('status'=>'Active')));			
			$this->set('vendorstatus',$vendorstatus); 
			$category=$this->Category->find('all',array('conditions'=>array('status'=>'Active')));		
			$this->set('categories',$category);
			$metals=$this->Metal->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'metal_id ASC'));			
			$this->set('metal',$metals); 
			$stone=$this->Diamond->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'diamond_id ASC'));			
			$this->set('stone',$stone); 
			$clarity=$this->Clarity->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'clarity_id ASC'));			
			$this->set('clarity',$clarity);
			$carats=$this->Carat->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'carat_id ASC'));				
			$this->set('carats',$carats);
			$shapes=$this->Shape->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'shape_id ASC'));				
			$this->set('shape',$shapes);
			$type=$this->Settingtype->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'settingtype_id ASC'));			
			$this->set('type',$type); 
			$metalcolor=$this->Metalcolor->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'metalcolor_id ASC'));			
			$this->set('metalcolor',$metalcolor); 
			$images=$this->Productimage->find('all',array('conditions'=>array('product_id'=>$this->params['pass'][0],'status'=>'Active')));
			$this->set('images',$images);
			$gem=$this->Gemstone->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'gemstone_id ASC'));			
			$this->set('gem',$gem); 
			$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$this->params['pass']['0'])));
			$this->set('product',$product);
			$new_stone=$this->Productgemstone->find('all',array('conditions'=>array('product_id'=>$this->params['pass']['0'])));
			$this->set('new_stone',$new_stone);
			$new_size=$this->Productdiamond->find('all',array('conditions'=>array('product_id'=>$this->params['pass']['0'])));
			$this->set('new_size',$new_size);
			$new_metal=$this->Productmetal->find('all',array('conditions'=>array('product_id'=>$this->params['pass']['0'])));
			$this->set('new_metal',$new_metal);
			$vendor=$this->Vendor->find('all',array('conditions'=>array('vendor_id'=>$product['Product']['vendor_id'])));
			$this->set('vendor',$vendor);
			$product_id=$product['Product']['product_id'];	
			
			if($this->request->is('post')){
			$check=$this->Product->find('first',array('conditions'=>array('vendor_product_code'=>$this->request->data['Product']['vendor_product_code'],'status !='=>'Trash','product_id !='=>$this->params['pass']['0'])));
			if(empty($check)){ 
			$this->request->data['Product']['product_id'] =$product['Product']['product_id'];
			if($this->request->data['Product']['certificate_image']['name']!=''){
			$this->request->data['Product']['certificate_image']=$this->Image->upload_image_and_thumbnail($this->request->data['Product']['certificate_image'],800,800,215,133,"certificate",'1');
			}else{
			$this->request->data['Product']['certificate_image']=$product['Product']['certificate_image'];	
			}
			if(!empty($this->request->data['Product']['metal_color'])){
			$this->request->data['Product']['metal_color']=implode(",",$this->request->data['Product']['metal_color']);
			}			
			$this->request->data['Product']['vendor_id'] =$this->request->data['Product']['vendor_id'];
			$this->request->data['Product']['product_type']=implode(",",$this->request->data['Product']['product_type']);	
			$this->Product->save($this->request->data);
			if(!empty($this->request->data['Productmetal'])) {
			if(!empty($this->request->data['Productmetal']['size']))
			{
			$this->Productmetal->deleteAll(array('product_id'=>$this->params['pass']['0'],'type'=>'Size'));
			foreach($this->request->data['Productmetal']['size'] as $size){
			$this->request->data['Productmetal']['product_id']=$product_id;
			$this->request->data['Productmetal']['type']='Size';
			$this->request->data['Productmetal']['value']=$size;
			$this->request->data['Productmetal']['category_id']=$this->request->data['Product']['category_id'];
			$this->Productmetal->saveAll($this->request->data);
			}}
			if(!empty($this->request->data['Productmetal']['purity']))
			{ 
			$this->Productmetal->deleteAll(array('product_id'=>$this->params['pass']['0'],'type'=>'Purity'));
			foreach($this->request->data['Productmetal']['purity'] as $purity){
			$this->request->data['Productmetal']['product_id']=$product_id;
			$this->request->data['Productmetal']['type']='Purity';
			$this->request->data['Productmetal']['value']=$purity;
			$this->request->data['Productmetal']['category_id']=$this->request->data['Product']['category_id'];
			$this->Productmetal->saveAll($this->request->data);
			}}}
			$this->Productgemstone->deleteAll(array('product_id'=>$this->params['pass']['0']));
			if($this->request->data['Product']['gemstone']=='Yes') {
			if(!empty($this->request->data['Productgemstone'])) {
			foreach($this->request->data['Productgemstone'] as $product_stone){
			$product_stone['product_id']=$product_id;
			$product_stone['vendor_id']=$this->request->data['Product']['vendor_id'];
			$this->Productgemstone->saveAll($product_stone);				
			}	}}
			if(!empty($this->request->data['Productimage']['image'])){
			foreach($this->request->data['Productimage']['image'] as $image){
			if(!empty($image['name'])){
			$this->request->data['Productimage']['status']='Active';
			$this->request->data['Productimage']['product_id']=$product_id;
			$this->request->data['Productimage']['imagename']=$this->Image->upload_image_and_thumbnail($image,800,800,215,133,"product",'1');
			$this->Productimage->saveAll($this->request->data);
			}
			}
			}$this->Productdiamond->deleteAll(array('product_id'=>$this->params['pass']['0']));		
			if($this->request->data['Product']['stone']=='Yes') {
				
			foreach($this->request->data['Productdiamond'] as $product_stone){
				$product_stone['product_id']=$product_id;
				$product_stone['vendor_id']=$this->request->data['Product']['vendor_id'];
				$this->Productdiamond->saveAll($product_stone);				
			}	
			}
			$this->Session->setFlash('<div class="success msg">Product save successfully.</div>','default');
			$this->redirect(array('action'=>'index')); 
			}else{
			$this->Session->setFlash('<div class="error msg">Vendor product code  already exits.</div>','');
			}
			}
			
		}

		public function admin_changestatus($id,$status){
			$this->checkadmin();
			$this->request->data['Product']['product_id']=$id;
			$this->request->data['Product']['status']=$status;
			$this->Product->save($this->request->data);
			$this->Session->setFlash('<div class="success msg">'.__('Product Status updated successfully').'.</div>','');
			$this->redirect(array('action'=>'index'));
       }

      
	   public function vendor_code(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$id = $this->request->data;
			$vendorcode = $this->Vendor->find('first',array('conditions'=>array('vendor_id'=>$id)));
			echo $vendorcode['Vendor']['vendor_code'];
			
			
			}
	   }
		
	  public function category(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$id = $this->request->data;
			$subcategory = $this->Subcategory->find('all',array('conditions'=>array('category_id'=>$id,'status'=>'Active')));
			
			if (!empty($subcategory)) {
			echo json_encode($subcategory);
			} else {
			echo '[]';
			}
			
			}
	 }
	 
	 public function stone(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$stone=$this->Diamond->find('all',array('conditions'=>array('status'=>'Active')));
			
			if (!empty($stone)) {
			echo json_encode($stone);
			} else {
			echo '[]';
			}
			}
		 
	 }
	 public function stone_clarity(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$stone_clarity=$this->Clarity->find('all',array('conditions'=>array('status'=>'Active')));			
			if (!empty($stone_clarity)) {
			echo json_encode($stone_clarity);
			} else {
			echo '[]';
			}
			}
		 
	 }
	 public function stone_color(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$id=$_REQUEST['id'];
			$stone_color=$this->Color->find('all',array('conditions'=>array('clarity'=>$id,'status'=>'Active')));			
			if (!empty($stone_color)) {
			echo json_encode($stone_color);
			} else {
			echo '[]';
			}
			}
		 
	 }
	  public function diamonds(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$stone_color=$this->Jeweltype->find('all',array('conditions'=>array('type'=>'Stone Color','status'=>'Active')));			
			if (!empty($stone_color)) {
			echo json_encode($stone_color);
			} else {
			echo '[]';
			}
			}
		 
	 }
	  public function stone_carat(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$stone_carat=$this->Carat->find('all',array('conditions'=>array('status'=>'Active')));			
			if (!empty($stone_carat)) {
			echo json_encode($stone_carat);
			} else {
			echo '[]';
			}
			}
			
	 }
	  public function gem(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$gemstone=$this->Gemstone->find('all',array('conditions'=>array('status'=>'Active')));			
			if (!empty($gemstone)) {
			echo json_encode($gemstone);
			} else {
			echo '[]';
			}
			}
		 
	 }
	  public function stone_shape(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$stone_shape=$this->Shape->find('all',array('conditions'=>array('status'=>'Active')));			
			if (!empty($stone_shape)) {
			echo json_encode($stone_shape);
			} else {
			echo '[]';
			}
			}
		 
	 }
	  public function setting_type(){
			if ($this->request->is('ajax')) {
			$this->layout = '';
			$this->render(false);
			$setting=$this->Settingtype->find('all',array('conditions'=>array('status'=>'Active')));			
			if (!empty($setting)) {
			echo json_encode($setting);
			} else {
			echo '[]';
			}
			}
		 
	 }
	 
	 
	 public function admin_delete() {
			$this->checkadmin();				
			if(!empty($this->params['pass']['0'])){
			$this->Product->id = $this->params['pass']['0'];
			$id = $this->params['pass']['0'];
			if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid Product'));
			}			
			
			$this->request->data['Product']['product_id']=$this->params['pass']['0'];
			$this->request->data['Product']['status']='Trash';
			$this->Product->save($this->request->data);
			$this->Session->setFlash("<div class='success msg'>".__('Product has been deleted successfully')."</div>",'');		
			$this->redirect(array('action' => 'index'));
			}else{
			if(!empty($this->request->data['action'])){
			foreach($this->request->data['action'] as $productdelete){
			if($productdelete >0){
			$this->request->data['Product']['product_id']=$productdelete;
			$this->request->data['Product']['status']='Trash';
			$this->Product->saveAll($this->request->data);
			}
			}
			}
			$this->Session->setFlash("<div class='success msg'>".__('Product has been deleted successfully')."</div>",'');		
			$this->redirect(array('action' => 'index'));
			}
		}
		
		public function admin_addimages(){
			$this->checkadmin();
			$product=$this->Product->find('first',array('conditions'=>array('product_id'=>$this->params['pass']['0'])));
			$this->set('product',$product);
			$vendor=$this->Vendor->find('all',array('conditions'=>array('vendor_id'=>$product['Product']['vendor_id'])));
			$this->set('vendor',$vendor);
			if ($this->request->is('post')) {
			$project = $this->Productimage->find('first');
			$count=count($this->request->data['Productimage']['image']);
			$this->request->data['Productimage']['status']='Active';
			$this->request->data['Productimage']['product_id']=$this->params['pass']['0'];
			for($i=0;$i<$count;$i++){
			if(!empty($this->request->data['Productimage']['image'][$i]['name'])){
			$this->request->data['Productimage']['image'][$i]=$this->Image->upload_image_and_thumbnail($this->request->data['Productimage']['image'][$i],480,385,265,218,"product");	
			}
			}foreach($this->request->data['Productimage']['image'] as $images) {
			$this->request->data['Productimage']['imagename']=$images;			
			$this->Productimage->saveAll($this->request->data);			
			}
			$this->Session->setFlash('<div class="success msg">Inserted Successfully</div>');
			$this->redirect(array('action' => 'addimages',$this->params['pass']['0']));
			}
			$images=$this->Productimage->find('all',array('conditions'=>array('product_id'=>$this->params['pass'][0],'status'=>'Active')));
			$this->set('images',$images);
	}
	
	public function admin_deleteimages(){
			$this->checkadmin();
			if(!empty($this->params['pass']['1'])){
			$this->Productimage->id = $this->params['pass']['1'];
			$id = $this->params['pass']['1'];
			if (!$this->Productimage->exists()) {
			throw new NotFoundException(__('Invalid Image'));
			}$this->request->data['Productimage']['image_id']=$this->params['pass']['1'];
			$this->request->data['Productimage']['status']='Trash';
			$this->Productimage->save($this->request->data);
			$this->Session->setFlash("<div class='success msg'>".__('Product Image has been deleted successfully')."</div>",'');		
			$this->redirect(array('action' => 'admin_edit',$this->params['pass']['0']));
			}else{
			if(!empty($this->request->data['action'])){
			foreach($this->request->data['action'] as $imagedelete){
			if($imagedelete >0){
			$this->request->data['Productimage']['image_id']=$imagedelete;
			$this->request->data['Productimage']['status']='Trash';
			$this->Productimage->saveAll($this->request->data);
			}
			}
			}
			$this->Session->setFlash("<div class='success msg'>".__('Images has been deleted successfully')."</div>",'');		
			$this->redirect(array('action' => 'admin_edit' ,$this->params['pass']['0']));
			}	
			
		
	}
	
	
	public function admin_product_export() {
	
			$this->layout='';
			$this->render(false);
			ini_set('max_execution_time', 600); 	
			//create a file
			//$filename = "product_details.csv";
			//$csv_file = fopen('php://output', 'w');
			
			//header('Content-type: application/csv');
			//header('Content-Disposition: attachment; filename="'.$filename.'"');
			
			$results_head=$this->Product->find('all',array('conditions'=>array('status !='=>'Trash')));
			$pro_diamond_hd[]=array();
			$pro_gemstone_hd[]=array();
			foreach($results_head as $results_head){
				$pro_diamond_hd[]=$this->Productdiamond->find('count',array('conditions'=>array('product_id'=>$results_head['Product']['product_id'])));
			
			$pro_gemstone_hd[]=$this->Productgemstone->find('count',array('conditions'=>array('product_id'=>$results_head['Product']['product_id'])));
			
			//pr($pro_gemstone_hd);exit;
			}pr($pro_diamond_hd);
			pr($pro_gemstone_hd);
			exit;
			
			
			$results=$this->Product->find('all',array('conditions'=>array('status !='=>'Trash')));
			$header_row = array("S.No","Product Nmae","Product Code","Link","Category","Sub Category","Vendor","vendor product code","Metal","Metal Color","Product weight","Stone","Special Work","Gemstone","Special Work Description","Special work charge","vendor_making_charge","vat_cst","vendor_delivery_tat","product_delivery_tat","status","Diamond","Stone Clarity","Stone Color","Stone Carat","no_of_diamonds","stone_shape","stone weight","setting_type","Diamond 1","Stone Clarity 1","Stone Color 1","Stone Carat 1","no_of_diamonds 1","stone_shape 1","stone weight 1","setting_type 1","Stone 2","Stone Clarity 2","Stone Color 2","Stone Carat 2","no_of_diamonds 2","stone_shape 2","stone weight 2 ","setting_type 2","Gemstone 1","size 1","Shape 1","Stone weight 1","no of Stone 1","Setting type 1","Gemstone 2","size 2","Shape 2","Stone Weight 2","no of Stone 2","Setting Type 2","Size 1","Value 1","Size 2","Value 2","Purity 1","Value 1","Purity 2","Value 2");
			fputcsv($csv_file,$header_row,',','"');
			$i=1;
			foreach($results as $results){	
			
			$product=$this->Productdiamond->find('all',array('conditions'=>array('product_id'=>$results['Product']['product_id']),array('limit'=>'3')));
			$product_count=$this->Productdiamond->find('count',array('conditions'=>array('product_id'=>$results['Product']['product_id'])));
			$productgem=$this->Productgemstone->find('all',array('conditions'=>array('product_id'=>$results['Product']['product_id']),array('limit'=>'2')));
			$productgem_count=$this->Productgemstone->find('count',array('conditions'=>array('product_id'=>$results['Product']['product_id'])));
			$productmetal=$this->Productmetal->find('all',array('conditions'=>array('product_id'=>$results['Product']['product_id'],'type'=>'Size'),array('limit'=>'2')));
			$productmetal_count=$this->Productmetal->find('count',array('conditions'=>array('product_id'=>$results['Product']['product_id'],'type'=>'Size')));
			$productsize=$this->Productmetal->find('all',array('conditions'=>array('product_id'=>$results['Product']['product_id'],'type'=>'Purity'),array('limit'=>'2')));
			$productsize_count=$this->Productmetal->find('count',array('conditions'=>array('product_id'=>$results['Product']['product_id'],'type'=>'Purity')));
			
			$products=array();
			foreach($product as $product_details){
			$products[]=$product_details['Productdiamond']['diamond'];
			$products[]=$product_details['Productdiamond']['clarity'];
			$products[]=$product_details['Productdiamond']['color'];
			$products[]=$product_details['Productdiamond']['carat'];
			$products[]=$product_details['Productdiamond']['noofdiamonds'];
			$products[]=$product_details['Productdiamond']['shape'];
			$products[]=$product_details['Productdiamond']['stone_weight'];
			$products[]=$product_details['Productdiamond']['settingtype'];
			
			}
			if($product_count <3){
			for($s=$product_count+1;$s<=3;$s++){
			$products[]=' ';
			$products[]=' ';
			$products[]=' ';
			$products[]=' ';
			$products[]=' ';
			$products[]=' ';
			$products[]=' ';
			$products[]=' ';
			}
			}
			$productgemstonenew=array();
			foreach($productgem as $productgemstone){
			$productgemstonenew[]=$productgemstone['Productgemstone']['gemstone'];
			$productgemstonenew[]=$productgemstone['Productgemstone']['size'];
			$productgemstonenew[]=$productgemstone['Productgemstone']['shape'];
			$productgemstonenew[]=$productgemstone['Productgemstone']['no_of_stone'];
			$productgemstonenew[]=$productgemstone['Productgemstone']['stone_weight'];
			$productgemstonenew[]=$productgemstone['Productgemstone']['settingtype'];
			}
			if($productgem_count <2){
			for($s=$productgem_count+1;$s<=3;$s++){
			$productgemstonenew[]=' ';
			$productgemstonenew[]=' ';
			$productgemstonenew[]=' ';
			$productgemstonenew[]=' ';
			$productgemstonenew[]=' ';
			$productgemstonenew[]=' ';
			}
			}
			$productmetalnew=array();
			
			foreach($productmetal as $productmetaldiv){
			$productmetalnew[]=$productmetaldiv['Productmetal']['type'];
			$productmetalnew[]=$productmetaldiv['Productmetal']['value'];
			}
			if($productmetal_count <2){
			for($s=$productmetal_count+1;$s<=2;$s++){
			$productmetalnew[]=' ';
			$productmetalnew[]=' ';
			}
			}
			
			$productsizenew=array();
			
			foreach($productsize as $productsizediv){
			$productsizenew[]=$productsizediv['Productmetal']['type'];
			$productsizenew[]=$productsizediv['Productmetal']['value'];
			}
			if($productsize_count <2){
			for($s=$productsize_count+1;$s<=2;$s++){
			$productsizenew[]=' ';
			$productsizenew[]=' ';
			}
			}
			$vendor=$this->Vendor->find('first',array('conditions'=>array('vendor_id'=>$results['Product']['vendor_id'])));
			$name=$vendor['Vendor']['Company_name'];
			
			$category=$this->Category->find('first',array('conditions'=>array('category_id'=>$results['Product']['category_id'])));
			$category1=$category['Category']['category'];
			if(!empty($results['Product']['subcategory_id'])){
			$sub=$this->Subcategory->find('first',array('conditions'=>array('subcategory_id'=>$results['Product']['subcategory_id'])));
			$subcategory=$sub['Subcategory']['subcategory'];
			}
			else
			{
			$subcategory='';
			}
			
			
			
			$row = array(
			$i,
			$results['Product']['product_name'],				
			$results['Product']['product_code'],
			$results['Product']['link'],
			$category1,
			$subcategory,
			$name,
			$results['Product']['vendor_product_code'],
			$results['Product']['metal'],
			$results['Product']['metal_color'],
			$results['Product']['metal_weight'],
			$results['Product']['stone'],
			$results['Product']['special_work'],
			$results['Product']['gemstone'],
			$results['Product']['special_work_description'],
			$results['Product']['special_work_charge'],
			$results['Product']['vendor_making_charge'],
			$results['Product']['vat_cst'],
			$results['Product']['vendor_delivery_tat'],
			$results['Product']['product_delivery_tat'],
			$results['Product']['status']
			);
			$row=array_merge($row,$products); 
			$row=array_merge($row,$productgemstonenew); 
			$row=array_merge($row,$productmetalnew); 
			$row=array_merge($row,$productsizenew); 
			
			$i++;	
			//fputcsv($csv_file,$row,',','"');
			}
			//fclose($csv_file);
	
	 
 }
  
  
   public function productsize(){
		
		$this->layout = '';
		$this->render(false);
		$id =$_REQUEST['id'];
		$size = $this->Size->find('all',array('conditions'=>array('category_id'=>$id),'group'=>'size','order'=>'size_id ASC'));
		$category=$this->Category->find('first',array('conditions'=>array('category_id'=>$id)));
		if(!empty($size)) {
		echo '<input type="checkbox" id="selecctall">&nbsp;Select all&nbsp;<br>';
		foreach($size as $size) { 
		if($category['Category']['category']!='Bangles') {
		$val=$size['Size']['size_value'];
		}else{
		$val=$size['Size']['size_value'];
		}
		
		echo '<input type="checkbox" name="data[Productmetal][size][]"  class="validate[required] checkbox1" value="'.$val.'"/>'.$size['Size']['size'].'&nbsp;';
		}
		
		}else {
		echo 'No';
		}
		
		
		}
		
		
		 public function metalcolor(){
		
				$this->layout = '';
				$this->render(false);
				$id =$_REQUEST['id'];
				if($id!='0'){
				$metalnew = $this->Metal->find('first',array('conditions'=>array('metal_name'=>$id)));
				$metal = $this->Metalcolor->find('all',array('conditions'=>array('metal_id'=>$metalnew['Metal']['metal_id'])));
				
				if(!empty($metal)) {
				
				foreach($metal as $metal) { 
				
				echo '<input type="checkbox" name="data[Product][metal_color][]" class="validate[required] colosdiv" value="'.$metal['Metalcolor']['metalcolor'].'"/>'.$metal['Metalcolor']['metalcolor'].'&nbsp;';
				
				}
				}else
				{
				echo 'No';
				}
				}else{
					echo 'No';
				}
		
		 }
		 
		 
		 
		 public function gold_purity(){
		
		$this->layout = '';
		$this->render(false);
		$purity = $this->Purity->find('all',array('conditions'=>array('status'=>'Active')));
	      if (!empty($purity)) {
                echo json_encode($purity);
            } else {
                echo '[]';
            }
		 }
		

		 
		 
		 
	public function metal_weight(){
		
		$this->layout = '';
		$this->render(false);
	    $jewel = $this->Size->find('all',array('conditions'=>array('category_id'=>$_REQUEST['id'])));
		//if(!empty($jewel))
		//{
			$purity = $this->Purity->find('all',array('conditions'=>array('status'=>'Active')));
			 if (!empty($purity)) {
				  //echo '<fieldset><legend>Metal Details</legend> <dt><label for="name">Gold Purity <span class="required">*</span></label></dt><dd>';
				 echo '<input type="checkbox" id="selecctall_purity">&nbsp;Select all&nbsp;<br>'; 
			  foreach($purity as $purities) {
			  echo' <input type="checkbox" name="data[Productmetal][purity][]" value="'.$purities['Purity']['purity'].'" class="checkboxp">'.$purities['Purity']['purity'].'K';
              }
			  echo '</dd></fieldset>';
			  
            }		
		 //}
		 //else
				/* {
					 		$gold = $this->Purity->find('all',array('conditions'=>array('status'=>'Active'),'order'=>'purity_id ASC'));			

					echo '<fieldset><legend>Metal Details</legend> <dt><label for="name">Gold Purity <span class="required">*</span></label></dt><dd> <select name="data[Productmetal][purity][0]" id="goldpurity" class="validate[required]"><option value="">Select</option>';
					foreach($gold as $golds) {
						echo ' <option value="'.$golds['Purity']['purity_id'].'">'.$golds['Purity']['purity'].'K </option>';
					}
						echo '</select>';*/
						//</dd>';
//					   
//						echo '<dt><label for="name">Weight<span class="required">*</span></label></dt>';
//						echo '<dd><input type="text" name="data[Productmetal][0][weight]" id="weight"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10 value=""/>&nbsp;</dd> '; 
//						echo '  <dt><label for="name">Gold Difference</label></dt>';
//                        echo '<dd><input type="text" name="data[Productmetal][0][gold_diff]" id="gold_diff"  class="validate[custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value=""/>&nbsp;';*/
		                /*echo '  &nbsp;&nbsp;&nbsp;<button type="button"  class="button add_weight" name="addstone" value="">Add </button></dd></fieldset>';
                        echo ' <input type="hidden" name="offical_contacts" id="add_weight_cat" value="0"/>';*/
				 
			//}
			
		  }
		  
		  
	 public function gold_purity_check(){
		
		$this->layout = '';
		$this->render(false);
		$purity = $this->Purity->find('all',array('conditions'=>array('status'=>'Active')));
	      if (!empty($purity)) {
			  foreach($purity as $purities) {
			   echo '<input type="checkbox" name="data[Productsize][goldpurity][]" value="'.$purities['Purity']['purity_id'].'">'.$purities['Purity']['purity'].'K';
              }
            } else {
                echo '';
            }
		 }
		 
		
		 
		 
}
