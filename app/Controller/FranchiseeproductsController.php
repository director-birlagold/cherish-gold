<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FranchiseeproductsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Mpdf');
    public $uses = array('User', 'Adminuser', 'State', 'Accounttype', 'Proof', 'Nomination', 'Bankdetail', 'Payment', 'Outlet', 'Franchiseeproof', 'Officeuse', 'Otherdetail', 'Category', 'Product', 'Franchiseeproduct');
    public $layout = 'webpage';

    /**
     * admin_index method
     *
     * @return void
     */
    
    public function index() {
        $this->usercheck();
        if($this->Session->read('User.user_type') == 1){
            $title = 'All Jewellery | shagunn.in';
            $this->set('title', $title);
        }else{
            $this->redirect('/');
        }
    }
    
    public function view($cat_id = NULL) {
        $this->usercheck();
        if($this->Session->read('User.user_type') == 1){
            $products = $this->Franchiseeproduct->findAllByUserIdAndCategoryId($this->Session->read('User.user_id'), $cat_id);
            $title = 'All Jewellery | shagunn.in';

            $category = $this->Category->findByCategoryId($cat_id);
            $this->set(compact('products', 'title', 'category'));
        }else{
            $this->redirect('/');
        }
    }
	
	public function downloadpdf($cat_id = NULL) {
        $this->usercheck();
		$this->layout = '';
		$cat_id = (int)$_GET['id'];
        if($this->Session->read('User.user_type') == 1){
            $products = $this->Franchiseeproduct->findAllByUserIdAndCategoryId($this->Session->read('User.user_id'), $cat_id);
            $title = 'All Jewellery | shagunn.in';

            $category = $this->Category->findByCategoryId($cat_id);
            $this->set(compact('products', 'title', 'category'));
			$filename = str_replace('/', '_', $category . '.pdf');
			$this->Mpdf->init(array('en-GB-x', 'A4', '', '', 10, 10, 10, 10, 6, 3));
			$filepath = 'files/invoices/' . $filename;
			$this->Mpdf->setFilename($filepath);
			$this->Mpdf->setOutput($output);
        }else{
			$this->redirect('/');
        }
    }
    
    public function productedit($cat_id = NULL) {
        $this->usercheck();
        if($this->Session->read('User.user_type') == 1){
            if($this->request->is('post') || $this->request->is('put')){
                $this->Franchiseeproduct->deleteAll(array(
                    'Franchiseeproduct.user_id' => $this->Session->read('User.user_id'), 
                    'Franchiseeproduct.category_id' => $cat_id), false);
                foreach ($this->request->data['Franchiseeproduct'] as $product_id => $franchiseeproduct) {
                    if(isset($franchiseeproduct['checked']) &&  $franchiseeproduct['checked'] == 1){
                        $save_record = array(
                            'Franchiseeproduct' => array(
                                'user_id' => $this->Session->read('User.user_id'),
                                'product_id' => $product_id,
                                'category_id' => $franchiseeproduct['category_id']
                                ));

                        if(isset($franchiseeproduct['franchise_product_id'])){
    //                        $this->Franchiseeproduct->franchise_product_id = $franchiseeproduct['franchise_product_id'];
    //                        $this->Franchiseeproduct->read(null, $franchiseeproduct['franchise_product_id']);
                            $save_record['Franchiseeproduct']['franchise_product_id'] = $franchiseeproduct['franchise_product_id'];
                        }
    //                    echo '<pre>';
    //                    print_r($this->Franchiseeproduct);
    //
    //
                        $this->Franchiseeproduct->saveAll($save_record);
                    }
                }
                $this->redirect('edit/'.$cat_id);
            }
            $category = $this->Category->findByCategoryId($cat_id);
            $products = $this->Product->findAllByCategoryIdAndStatus($cat_id, 'active');
            $this->set(compact('products','category'));
        }else{
            $this->redirect('/');
        }
    }
}
