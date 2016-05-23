<?php

App::uses('AppController', 'Controller');
App::import('Product', 'payu');

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
    public $components = array('Paginator', 'Session', 'Image', 'Mpdf');
    public $uses = array('Product', 'Vendorcontact', 'Vendor', 'Category', 'Subcategory', 'Productstone', 'Productimage', 'Size',
        'Metalcolor', 'Metal', 'Diamond', 'Clarity', 'Color', 'Carat', 'Shape', 'Settingtype', 'Purity', 'Productmetal',
        'Productgemstone', 'Productdiamond', 'Gemstone', 'Price', 'Collectiontype', 'Order', 'Franchiseebrokerage', 'Menu', 'ShoppingAssistance');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Product->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['cdate'] != '') {
                $search[] = 'cdate=' . $this->request->data['cdate'];
            }if ($this->request->data['edate'] != '') {
                $search[] = 'edate=' . $this->request->data['edate'];
            }
            if ($this->request->data['searchvendorname'] != '') {
                $search[] = 'searchvendorname=' . $this->request->data['searchvendorname'];
            }
            if ($this->request->data['productname'] != '') {
                $search[] = 'productname=' . $this->request->data['productname'];
            }
            if ($this->request->data['productcode'] != '') {
                $search[] = 'productcode=' . $this->request->data['productcode'];
            }
            if ($this->request->data['searchcategory'] != '') {
                $search[] = 'searchcategory=' . $this->request->data['searchcategory'];
            }if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        if ($this->request->query('search') != '') {
            $search = array();
            $search = array('status !=' => 'Trash');
            if (($this->request->query('cdate') != '') && ($this->request->query('edate') != '')) {
                $search = array_merge($search, array('Product.created_date BETWEEN \'' . $_REQUEST['cdate'] . '\' AND \'' . $_REQUEST['edate'] . '\''));
            } elseif ($this->request->query('cdate') != '') {
                $search['created_date'] = $this->request->query('cdate');
            } elseif ($this->request->query('edate') != '') {
                $search['created_date'] = $this->request->query('edate');
            }
            if ($this->request->query('searchvendorname') != '') {
                $vendor = $this->Vendor->find('first', array('conditions' => array('vendor_id' => $this->request->query('searchvendorname'))));
                $this->set('vendor', $vendor);
                $search['vendor_id'] = $vendor['Vendor']['vendor_id'];
            }if ($this->request->query('productname') != '') {
                $search = array_merge($search, array('Product.product_name Like "%' . $this->request->query('productname') . '%"'));
            }
            if ($this->request->query('productcode') != '') {
                $result = preg_split('/(?<=\d)(?=[a-z])|(?<=[a-z])(?=\d)/i', $this->request->query('productcode'));
                $cat = $result[0];
                $productcode = $result[1];
                $cat = $this->Category->findByCategoryCode($cat);
                if(!empty($cat))
                    $search['category_id'] = $cat['Category']['category_id'];
                $search = array_merge($search, array('Product.product_code Like "%' . $productcode . '%"'));
            }
            if ($this->request->query('searchcategory') != '') {
                //print_r($this->request->query('searchcategory'));exit;
                $search['category_id'] = $this->request->query('searchcategory');
            }
			
			
			/* start for vendor session condition*/
				if ( isset($_SESSION['Adminuser']['vendor_id']) && !empty($_SESSION['User']['login_type'] ) && $_SESSION['User']['login_type'] == "Vendor" ) {
					$search['vendor_id'] = $_SESSION['Adminuser']['vendor_id'];
				}
			/* end for vendor session condition*/
			
			//print_r($search);
			//exit;
			

            $this->paginate = array('conditions' => $search, 'order' => 'product_id DESC');
            $this->set('product', $this->Paginator->paginate('Product'));
        } else {
            //$this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'product_id DESC');
			
			if ( isset($_SESSION['Adminuser']['vendor_id']) && !empty($_SESSION['User']['login_type'] ) && $_SESSION['User']['login_type'] == "Vendor" ) {
				$this->paginate = array('conditions' => array('status !=' => 'Trash', 'vendor_id' => $_SESSION['Adminuser']['vendor_id'] ), 'order' => 'product_id DESC');
			}else{
				$this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'product_id DESC');
			}
			
			
            $this->set('product', $this->Paginator->paginate('Product'));
        }
        $vendorstatus = $this->Vendor->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('vendorstatus', $vendorstatus);
        $category = $this->Category->find('all', array('conditions' => array('status !=' => 'Trash')));
        $this->set('category', $category);
    }

    public function admin_search() {
        $this->checkadmin();
        $this->Product->recursive = 0;

        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['productname'] != '') {
                $search[] = 'productname=' . $this->request->data['productname'];
            }
            if ($this->request->data['productcode'] != '') {
                $search[] = 'productcode=' . $this->request->data['productcode'];
            }
            if (!empty($search)) {
                $this->redirect(array('action' => 'search?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'search'));
            }
        }

        if ($this->request->query('search') != '') {
            $search = array();
            $search = array('status !=' => 'Trash');
            if ($this->request->query('productname') != '') {
//                $search['product_name'] = $this->request->query('productname');
                $search = array_merge($search, array('Product.product_name Like "%' . $this->request->query('productname') . '%"'));
            }
            if ($this->request->query('productcode') != '') {
                $search = array_merge($search, array('Product.product_code Like "%' . $this->request->query('productcode') . '%"'));
//                $search['product_code'] = $this->request->query('productcode');
            }
            $this->paginate = array('conditions' => $search, 'order' => 'product_id DESC');
            $this->set('product', $this->Paginator->paginate('Product'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'product_id DESC');
            $this->set('product', $this->Paginator->paginate('Product'));
        }
        $vendorstatus = $this->Vendor->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('vendorstatus', $vendorstatus);
        $category = $this->Category->find('all', array('conditions' => array('status !=' => 'Trash')));
        $this->set('category', $category);
    }

    public function admin_add() {
        $this->checkadmin();
        $vendorstatus = $this->Vendor->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('vendorstatus', $vendorstatus);
        $category = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('categories', $category);
        $metals = $this->Metal->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
        $this->set('metal', $metals);
        $stone = $this->Diamond->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'diamond_id ASC'));
        $this->set('stone', $stone);
        $clarity = $this->Clarity->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'clarity_id ASC'));
        $this->set('clarity', $clarity);
        $colors = $this->Color->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'color_id ASC'));
        $this->set('colors', $colors);
        $carats = $this->Carat->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'carat_id ASC'));
        $this->set('carats', $carats);
        $shapes = $this->Shape->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'shape_id ASC'));
        $this->set('shape', $shapes);
        $type = $this->Settingtype->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'settingtype_id ASC'));
        $this->set('type', $type);
        $gem = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
        $this->set('gem', $gem);
        $collectiontype = $this->Collectiontype->find('all', array('conditions' => '', 'order' => 'collectiontype_id ASC'));
        $this->set('collectiontype', $collectiontype);
		$shopping_assistance_type = $this->ShoppingAssistance->find('all', array('conditions' => '', 'order' => 'shopping_assistance_id ASC'));
        $this->set('shopping_assistance_type', $shopping_assistance_type);

        if ($this->request->is('post')) {
            $product = $this->Product->find('first', array('conditions' => array('vendor_product_code' => $this->request->data['Product']['vendor_product_code'], 'status !=' => 'Trash')));
            if (empty($product)) {
			
				//print_r($_POST);
				//exit;
                if (!empty($this->request->data['Product']['metal_color'])) {
                    /* saran */

                    $metal_color_id = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $this->request->data['Product']['metal_color'][0]), 'fields' => array('metalcolor_id')));

                    $this->request->data['Product']['metal_color_id'] = $metal_color_id['Metalcolor']['metalcolor_id'];
                    $this->request->data['Product']['metal_color'] = implode(",", $this->request->data['Product']['metal_color']);
                }
                $this->request->data['Product']['vendor_id'] = $this->request->data['Product']['vendor_id'];
                if (!empty($this->request->data['Product']['product_type'])) {
                    $this->request->data['Product']['product_type'] = implode(",", $this->request->data['Product']['product_type']);
                }
                if (!empty($this->request->data['Product']['collection_type'])) {
                    $this->request->data['Product']['collection_type'] = implode(",", $this->request->data['Product']['collection_type']);
                }
				if (!empty($this->request->data['Product']['shopping_assistance_type'])) {
                    $this->request->data['Product']['shopping_assistance_type'] = implode(",", $this->request->data['Product']['shopping_assistance_type']);
                }
                if (!empty($this->request->data['Product']['product_view_type'])) {
                    $this->request->data['Product']['product_view_type'] = implode(",", $this->request->data['Product']['product_view_type']);
                }
                if (!empty($this->request->data['Product']['best_seller'])) {
                    $this->request->data['Product']['best_seller'] = $this->request->data['Product']['best_seller'];
                }
                if (!empty($this->request->data['Product']['popular'])) {
                    $this->request->data['Product']['popular'] = $this->request->data['Product']['popular'];
                }
                $this->request->data['Product']['status'] = 'Active';
                if (!empty($this->request->data['Product']['certificate_image']['name'])) {
                    $this->request->data['Product']['certificate_image'] = $this->Image->upload_image_and_thumbnail($this->request->data['Product']['certificate_image'], 800, 800, 215, 133, "certificate", '1');
                } else {
                    $this->request->data['Product']['certificate_image'] = '';
                }
                $this->request->data['Product']['created_date'] = date('Y-m-d H:i:s');
                $this->request->data['Product']['modify_date'] = date('Y-m-d H:i:s');
                $messages = $this->Product->find('first', array('conditions' => array('category_id' => $this->request->data['Product']['category_id'], 'status !=' => 'Trash'), 'fields' => array('MAX(Product.pid) AS maxid', '*')));
                if (!empty($messages[0]['maxid'])) {
                    $tiid = $messages[0]['maxid'] + 1;
                } else {
                    $tiid = 1;
                }
                $this->request->data['Product']['pid'] = $tiid;
                $projectcode = sprintf("%06d", $tiid);
                $this->request->data['Product']['product_code'] = $projectcode;

                $this->request->data['Product']['product_name'] = trim($this->request->data['Product']['product_name']);
				
				//$this->request->data['Product']['short_description'] = trim($this->request->data['Product']['short_description']);
				
                /* saran */
                $this->request->data['Product']['metal_purity'] = $this->request->data['Productmetal']['purity'][0];
                /* saran */
                //$this->request->data['Product']['product_size']=$this->request->data['Productmetal']['size'][0];
                //added by prakash
                $this->request->data['Product']['metal_fineness'] = !empty($this->data['Product']['metal_fineness']) ? implode(",", $this->data['Product']['metal_fineness']) : 0;
                $this->request->data['Product']['submenu_ids'] = !empty($this->data['Product']['submenu_ids']) ? implode(",", $this->data['Product']['submenu_ids']) : '';
                $this->request->data['Product']['offer_ids'] = !empty($this->data['Product']['offer_ids']) ? implode(",", $this->data['Product']['offer_ids']) : '';
                
				if(isset($this->data['Product']['sub_menu_image'])){
					$this->Product->updateAll(array('sub_menu_image'=>0), array('category_id'=>$this->data['Product']['category_id'],'subcategory_id' => $this->data['Product']['subcategory_id']));
				}
				
				//
                $this->Product->save($this->request->data);
                $product_id = $this->Product->getLastInsertID();
                if (!empty($this->request->data['Productmetal'])) {
                    if (!empty($this->request->data['Productmetal']['size'])) {
                        foreach ($this->request->data['Productmetal']['size'] as $size) {
                            $this->request->data['Productmetal']['product_id'] = $product_id;
                            $this->request->data['Productmetal']['type'] = 'Size';
                            $this->request->data['Productmetal']['value'] = $size;
                            $this->request->data['Productmetal']['category_id'] = $this->request->data['Product']['category_id'];
                            $this->Productmetal->saveAll($this->request->data);
                        }
                    }
                    if (!empty($this->request->data['Productmetal']['purity'])) {
                        foreach ($this->request->data['Productmetal']['purity'] as $purity) {
                            $this->request->data['Productmetal']['product_id'] = $product_id;
                            $this->request->data['Productmetal']['type'] = 'Purity';
                            $this->request->data['Productmetal']['value'] = $purity;
                            $this->request->data['Productmetal']['category_id'] = $this->request->data['Product']['category_id'];
                            $this->Productmetal->saveAll($this->request->data);
                        }
                    }
                }
                if ($this->request->data['Product']['gemstone'] == 'Yes') {
                    if (!empty($this->request->data['Productgemstone'])) {
                        foreach ($this->request->data['Productgemstone'] as $product_stone) {
                            /* saran */
                            $gemstone_1 = $product_stone['gemstone'];
                            $shape_1 = $product_stone['shape'];

                            $shape_id = $this->Shape->find('first', array('conditions' => array('shape' => $shape_1), 'fields' => array('shape_id')));
                            $gemstone_id = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstone_1), 'fields' => array('gemstone_id')));

                            $price_value_id = $this->Price->find('first', array('conditions' => array('gemstoneshape' => $shape_id['Shape']['shape_id'], 'gemstone_id' => $gemstone_id['Gemstone']['gemstone_id']), 'fields' => array('price')));


                            $product_stone['stone_price'] = $price_value_id['Price']['price'];

                            $product_stone['product_id'] = $product_id;
                            $product_stone['vendor_id'] = $this->request->data['Product']['vendor_id'];
                            $this->Productgemstone->saveAll($product_stone);
                        }
                    }
                }
                if (!empty($this->request->data['Productimage']['image'])) {
                    foreach ($this->request->data['Productimage']['image'] as $image) {
                        if (!empty($image['name'])) {
                            $this->request->data['Productimage']['status'] = 'Active';
                            $this->request->data['Productimage']['product_id'] = $product_id;
                            // $this->request->data['Productimage']['imagename'] = $this->Image->upload_image_and_thumbnail($image, 800, 800, 215, 133, "product", '1');
                            $this->request->data['Productimage']['imagename'] = $this->Image->upload_image_and_thumbnail($image, 800, 800, 215, 133, "product");

                            $this->Productimage->saveAll($this->request->data);
                        }
                    }
                }
                if ($this->request->data['Product']['stone'] == 'Yes') {
                    /* saran */
                    $loop_1 = 0;
                    $value_1 = 0;

                    foreach ($this->request->data['Productdiamond'] as $product_stone) {
                        $product_stone['product_id'] = $product_id;
                        $product_stone['vendor_id'] = $this->request->data['Product']['vendor_id'];
                        $this->Productdiamond->saveAll($product_stone);
                    }

                    $diamonddiv = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $product_id), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));

                    $stoneweight = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $product_id, 'color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => 'SUM(stone_weight) AS sweight'));

                    $color_id = $this->Color->find('first', array('conditions' => array('color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('color_id')));
                    $clarity_id = $this->Clarity->find('first', array('conditions' => array('clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('clarity_id')));

                    $this->request->data['Product']['product_id'] = $product_id;
                    $this->request->data['Product']['stoneweight'] = $stoneweight[0]['sweight'];
                    $this->request->data['Product']['stone_clarity_id'] = $clarity_id['Clarity']['clarity_id'];
                    $this->request->data['Product']['stone_color_id'] = $color_id['Color']['color_id'];
                    $this->Product->save($this->request->data);
                }

                $this->Session->setFlash('<div class="success msg">Product save successfully.</div>', 'default');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Vendor Product Code  already exits.</div>', '');
            }
        }
    }

    public function admin_edit($id) {
        $this->checkadmin();
        $vendorstatus = $this->Vendor->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('vendorstatus', $vendorstatus);
        $category = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('categories', $category);
        $metals = $this->Metal->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
        $this->set('metal', $metals);
        $stone = $this->Diamond->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'diamond_id ASC'));
        $this->set('stone', $stone);
        $clarity = $this->Clarity->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'clarity_id ASC'));
        $this->set('clarity', $clarity);
        $carats = $this->Carat->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'carat_id ASC'));
        $this->set('carats', $carats);
        $shapes = $this->Shape->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'shape_id ASC'));
        $this->set('shape', $shapes);
        $type = $this->Settingtype->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'settingtype_id ASC'));
        $this->set('type', $type);
        $metalcolor = $this->Metalcolor->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metalcolor_id ASC'));
        $this->set('metalcolor', $metalcolor);
        $images = $this->Productimage->find('all', array('conditions' => array('product_id' => $this->params['pass'][0], 'status' => 'Active')));
        $this->set('images', $images);
        $gem = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
        $this->set('gem', $gem);
        $product = $this->Product->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'])));
        $this->set('product', $product);
        $new_stone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $this->params['pass']['0'])));
        $this->set('new_stone', $new_stone);
        $new_size = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $this->params['pass']['0'])));
        $this->set('new_size', $new_size);
        $new_metal = $this->Productmetal->find('all', array('conditions' => array('product_id' => $this->params['pass']['0'])));
        $this->set('new_metal', $new_metal);
        $vendor = $this->Vendor->find('all', array('conditions' => array('vendor_id' => $product['Product']['vendor_id'])));
        $this->set('vendor', $vendor);
        $collectiontype = $this->Collectiontype->find('all', array('conditions' => '', 'order' => 'collectiontype_id ASC'));
        $this->set('collectiontype', $collectiontype);
		$shopping_assistance_type = $this->ShoppingAssistance->find('all', array('conditions' => '', 'order' => 'shopping_assistance_id ASC'));
        $this->set('shopping_assistance_type', $shopping_assistance_type);
        $product_id = $product['Product']['product_id'];

        if ($this->request->is('post')) {
            $check = $this->Product->find('first', array('conditions' => array('vendor_product_code' => $this->request->data['Product']['vendor_product_code'], 'status !=' => 'Trash', 'product_id !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $this->request->data['Product']['product_id'] = $product['Product']['product_id'];
                if ($this->request->data['Product']['certificate_image']['name'] != '') {
                    $this->request->data['Product']['certificate_image'] = $this->Image->upload_image_and_thumbnail($this->request->data['Product']['certificate_image'], 800, 800, 215, 133, "certificate", '1');
                } else {
                    $this->request->data['Product']['certificate_image'] = $product['Product']['certificate_image'];
                }

                if (!empty($this->request->data['Product']['metal_color'])) {
                    $metal_color = $this->request->data['Product']['metal_color'][0];
                    $this->request->data['Product']['metal_color'] = implode(",", $this->request->data['Product']['metal_color']);
                    /* saran */

                    $metal_color_id = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $metal_color), 'fields' => array('metalcolor_id')));
                    $this->request->data['Product']['metal_color_id'] = $metal_color_id['Metalcolor']['metalcolor_id'];
                }
                $this->request->data['Product']['vendor_id'] = $this->request->data['Product']['vendor_id'];
                /* saran */
                $this->request->data['Product']['metal_purity'] = $this->request->data['Productmetal']['purity'][0];
                /* saran */
                //$this->request->data['Product']['product_size']=$this->request->data['Productmetal']['size'][0];
                if (!empty($this->request->data['Product']['product_type'])) {
                    $this->request->data['Product']['product_type'] = implode(",", $this->request->data['Product']['product_type']);
                } else {
                    $this->request->data['Product']['product_type'] = "";
                }
                if (!empty($this->request->data['Product']['collection_type'])) {
                    $this->request->data['Product']['collection_type'] = implode(",", $this->request->data['Product']['collection_type']);
                } else {
                    $this->request->data['Product']['collection_type'] = "";
                }
				if (!empty($this->request->data['Product']['shopping_assistance_type'])) {
                    $this->request->data['Product']['shopping_assistance_type'] = implode(",", $this->request->data['Product']['shopping_assistance_type']);
                }else {
                    $this->request->data['Product']['shopping_assistance_type'] = "";
                }
                if (!empty($this->request->data['Product']['product_view_type'])) {
                    $this->request->data['Product']['product_view_type'] = implode(",", $this->request->data['Product']['product_view_type']);
                } else {
                    $this->request->data['Product']['product_view_type'] = "";
                }
                if (empty($this->request->data['Product']['best_seller'])) {
                    $this->request->data['Product']['best_seller'] = 0;
                }
                if (empty($this->request->data['Product']['popular'])) {
                    $this->request->data['Product']['popular'] = 0;
                }

                $this->request->data['Product']['product_name'] = trim($this->request->data['Product']['product_name']);


                //added by prakash
                $this->request->data['Product']['metal_fineness'] = !empty($this->data['Product']['metal_fineness']) ? implode(",", $this->data['Product']['metal_fineness']) : 0;
                $this->request->data['Product']['submenu_ids'] = !empty($this->data['Product']['submenu_ids']) ? implode(",", $this->data['Product']['submenu_ids']) : '';
                $this->request->data['Product']['offer_ids'] = !empty($this->data['Product']['offer_ids']) ? implode(",", $this->data['Product']['offer_ids']) : '';
                //
				
				if(isset($this->data['Product']['sub_menu_image'])){
					$this->Product->updateAll(array('sub_menu_image'=>0), array('category_id'=>$this->data['Product']['category_id'],'subcategory_id' => $this->data['Product']['subcategory_id']));
				}
				
				// echo "<pre>";
				// print_r($this->request->data);
				// exit;
                $this->Product->save($this->request->data);
                if (!empty($this->request->data['Productmetal'])) {
                    if (!empty($this->request->data['Productmetal']['size'])) {
                        $this->Productmetal->deleteAll(array('product_id' => $this->params['pass']['0'], 'type' => 'Size'));
                        foreach ($this->request->data['Productmetal']['size'] as $size) {
                            $this->request->data['Productmetal']['product_id'] = $product_id;
                            $this->request->data['Productmetal']['type'] = 'Size';
                            $this->request->data['Productmetal']['value'] = $size;
                            $this->request->data['Productmetal']['category_id'] = $this->request->data['Product']['category_id'];
                            $this->Productmetal->saveAll($this->request->data);
                        }
                    }
                    if (!empty($this->request->data['Productmetal']['purity'])) {
                        $this->Productmetal->deleteAll(array('product_id' => $this->params['pass']['0'], 'type' => 'Purity'));
                        foreach ($this->request->data['Productmetal']['purity'] as $purity) {
                            $this->request->data['Productmetal']['product_id'] = $product_id;
                            $this->request->data['Productmetal']['type'] = 'Purity';
                            $this->request->data['Productmetal']['value'] = $purity;
                            $this->request->data['Productmetal']['category_id'] = $this->request->data['Product']['category_id'];
                            $this->Productmetal->saveAll($this->request->data);
                        }
                    }
                }
                $this->Productgemstone->deleteAll(array('product_id' => $this->params['pass']['0']));
                if ($this->request->data['Product']['gemstone'] == 'Yes') {
                    if (!empty($this->request->data['Productgemstone'])) {
                        foreach ($this->request->data['Productgemstone'] as $product_stone) {
                            /* saran */
                            $gemstone_1 = $product_stone['gemstone'];
                            $shape_1 = $product_stone['shape'];

                            $shape_id = $this->Shape->find('first', array('conditions' => array('shape' => $shape_1), 'fields' => array('shape_id')));
                            $gemstone_id = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstone_1), 'fields' => array('gemstone_id')));

                            $price_value_id = $this->Price->find('first', array('conditions' => array('gemstoneshape' => $shape_id['Shape']['shape_id'], 'gemstone_id' => $gemstone_id['Gemstone']['gemstone_id']), 'fields' => array('price')));


                            $product_stone['stone_price'] = $price_value_id['Price']['price'];

                            $product_stone['product_id'] = $product_id;
                            $product_stone['vendor_id'] = $this->request->data['Product']['vendor_id'];
                            $this->Productgemstone->saveAll($product_stone);
                        }
                    }
                }
                if (!empty($this->request->data['Productimage']['image'])) {
                    foreach ($this->request->data['Productimage']['image'] as $image) {
                        if (!empty($image['name'])) {
                            $this->request->data['Productimage']['status'] = 'Active';
                            $this->request->data['Productimage']['product_id'] = $product_id;
                            // $this->request->data['Productimage']['imagename'] = $this->Image->upload_image_and_thumbnail($image, 800, 800, 215, 133, "product", '1');
                            $this->request->data['Productimage']['imagename'] = $this->Image->upload_image_and_thumbnail($image, 800, 800, 215, 133, "product");

                            $this->Productimage->saveAll($this->request->data);
                        }
                    }
                }$this->Productdiamond->deleteAll(array('product_id' => $this->params['pass']['0']));
                if ($this->request->data['Product']['stone'] == 'Yes') {


                    /* saran */
                    $loop_1 = 0;
                    $value_1 = 0;
                    foreach ($this->request->data['Productdiamond'] as $product_stone) {

                        /* if($loop_1==0)
                          {
                          $clarity_1=$product_stone['clarity'];
                          $color_1=$product_stone['color'];
                          }
                          if($product_stone['clarity']==$clarity_1 && $product_stone['color']==$color_1)
                          {
                          $value_1+=$product_stone['stone_weight'];
                          }
                          $loop_1++; */
                        $product_stone['product_id'] = $product_id;

                        $product_stone['vendor_id'] = $this->request->data['Product']['vendor_id'];
                        $this->Productdiamond->saveAll($product_stone);
                    }
                }

                if ($this->request->data['Product']['stone'] == 'Yes') {
                    //pr($diamonddiv);exit;
                    $diamonddiv = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $product_id), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));
                    $stoneweight = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $product_id, 'color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => 'SUM(stone_weight) AS sweight'));

                    $color_id = $this->Color->find('first', array('conditions' => array('color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('color_id')));
                    $clarity_id = $this->Clarity->find('first', array('conditions' => array('clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('clarity_id')));

                    $this->request->data['Product']['product_id'] = $product_id;
                    $this->request->data['Product']['stoneweight'] = $stoneweight[0]['sweight'];
                    $this->request->data['Product']['stone_clarity_id'] = $clarity_id['Clarity']['clarity_id'];
                    $this->request->data['Product']['stone_color_id'] = $color_id['Color']['color_id'];
                    $this->Product->save($this->request->data);
                } else {
                    $this->request->data['Product']['product_id'] = $product_id;
                    $this->request->data['Product']['stoneweight'] = 0;
                    $this->request->data['Product']['stone_clarity_id'] = 0;
                    $this->request->data['Product']['stone_color_id'] = 0;
                    $this->Product->save($this->request->data);
                }

                $this->Session->setFlash('<div class="success msg">Product save successfully.</div>', 'default');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Vendor product code  already exits.</div>', '');
            }
        }
    }
	
	
	
	public function admin_productimport() {
        $this->layout = 'admin';
        $this->checkadmin();
        if (isset($this->request->data['submit'])) {
            if (!empty($this->request->params['form']['importfile']['name'])) {
                $filename = $this->request->params['form']['importfile'];
                $filetype = $this->Image->getFileExtension($this->request->params['form']['importfile']['name']);
                if ($filetype == 'xls') {
                    $tmp_name = $filename["tmp_name"];
                    App::import('Vendor', 'php-excel-reader/excel_reader2');
                    $data = new Spreadsheet_Excel_Reader($tmp_name, true);
                    $datas = $data->dumpdata(true, true);
                } else {
                    $this->Session->setFlash("<div class='success msg'>" . __('Please upload CSV or XLS file.') . "</div>", '');
                    $this->redirect(array('action' => 'productimport'));
                }
				
				//print_r($datas);
				//exit;

				
				$errorMsgHeader = '<ol  style="color: rgb(204, 67, 60);">';
				$error = "";
				$errorMsgFooter = '</ol>'; 
				
				//print_r($datas);
				//exit;
				
				$array_data = array();
				
				for($i = 1; $i < sizeof($datas);$i++){
					
					$product = $this->Product->find('first', array('conditions' => array('vendor_product_code' => $datas[$i]['Vendor_Product_Code'], 'status !=' => 'Trash')));
					
					if (empty($product)) {
					//echo "in cod";
						
						$exdata = array();
						
						$vendor_id = $this->Vendor->find('first', array('conditions' => array('Company_name' => $datas[$i]['Vendor'], 'status !=' => 'Trash')));
						//print_r($vendor_id);
						//exit;
						
						$exdata['status'] = 'Inactive';
												
						if(!empty($vendor_id)){
							$exdata['vendor_id'] = $vendor_id['Vendor']['vendor_id'];
							//echo "ind";
						}else{
							$error .= '<li>Vendor not found of row '.$i.' .</li>';
						}
						
						$category_id = $this->Category->find('first', array('conditions' => array('category' => $datas[$i]['Category'], 'status !=' => 'Trash')));
						
						if(!empty($category_id)){
							$exdata['category_id'] = $category_id['Category']['category_id'];
						}else{
							$error .= '<li>Category not found of row '.$i.' .</li>';
						}
						
						$subcategory_id = $this->Subcategory->find('first', array('conditions' => array('subcategory' => $datas[$i]['Sub_Category'], 'status !=' => 'Trash')));
						//print_r($subcategory_id);
						//exit;
						if(!empty($subcategory_id)){
							$exdata['subcategory_id'] = $subcategory_id['Subcategory']['subcategory_id'];
						}else{
							$error .= '<li>Subcategory not found of row '.$i.' .</li>';
						}
						
						$exdata['product_name'] = $datas[$i]['Product_Name'];
						$exdata['vendor_product_code'] = $datas[$i]['Vendor_Product_Code'];
						
						//Product type
						if(!empty($datas[$i]['Product_Type'])){
							$product_types = explode(",", $datas[$i]['Product_Type']);
							//print_r($product_types);
							//exit;
							$prod_type_data = array();
							for($prod_type = 0; $prod_type < sizeof($product_types);$prod_type++){
								//echo "type: ".$product_types[$prod_type];
								if($product_types[$prod_type] == "Plain Gold" || $product_types[$prod_type] == "Diamond" || $product_types[$prod_type] == "Gemstone" ){
							
									if($product_types[$prod_type] == "Plain Gold"){
										$prod_type_data[] = '1';
									}elseif($product_types[$prod_type] == "Diamond"){
										$prod_type_data[] = '2';
									}elseif($product_types[$prod_type] == "Gemstone"){
										$prod_type_data[] = '3';
									}
								
								}else{
									$error .= '<li>Product Type not found of row '.$i.' .</li>';
								}
								
							}
							
							//print_r($prod_type_data);
							//exit;
							$exdata['product_type'] = implode(",",$prod_type_data);
							
						}
						
						
						
						//Collection type
						if(!empty($datas[$i]['Collection_Type'])){
							$collection_types = explode(",", $datas[$i]['Collection_Type']);
							$collection_types_data = array();
							for($collection_type = 0; $collection_type < sizeof($collection_types);$collection_type++){
								//echo $collection_types[$collection_type];
								$collectiontype = $this->Collectiontype->find('first', array('conditions' => array('collection_name' => $collection_types[$collection_type])));
								//echo "<pre>";
								//print_r($collectiontype);
								//echo $collectiontype['Collectiontype']['collectiontype_id'];
								$collection_types_data[] = $collectiontype['Collectiontype']['collectiontype_id'];
							}
							//print_r($collection_types_data);
							$exdata['collection_type'] = implode(",",$collection_types_data);
							
						}
						
						
						//Product view type
						if(!empty($datas[$i]['Product_View_type'])){
							$Product_View_type = explode(",", $datas[$i]['Product_View_type']);
							//print_r($product_types);
							//exit;
							$prod_view_type_data = array();
							for($prod_view_type = 0; $prod_view_type < sizeof($Product_View_type);$prod_view_type++){
								//echo "type: ".$Product_View_type[$prod_view_type];
								if($Product_View_type[$prod_view_type] == "New" || $Product_View_type[$prod_view_type] == "Sale" ){
							
									if($Product_View_type[$prod_view_type] == "New"){
										$prod_view_type_data[] = '1';
									}elseif($Product_View_type[$prod_view_type] == "Sale"){
										$prod_view_type_data[] = '2';
									}
								
								}else{
									$error .= '<li>Product View Type not found of row '.$i.' .</li>';
								}
								
							}
							
							//print_r($prod_view_type_data);
							//exit;
							$exdata['product_view_type'] = implode(",",$prod_view_type_data);
							
						}
						
						//Best Seller
						if(!empty($datas[$i]['Best_Seller'])){
							if($datas[$i]['Best_Seller'] == 'Yes'){
								$exdata['best_seller'] = '1';
							}else{
								$exdata['best_seller'] = '0';
							}
						}
						
						//product description
						if(!empty($datas[$i]['Short_Description'])){
							$exdata['short_description'] = $datas[$i]['Short_Description'];
						}
						
						
						
						$messages = $this->Product->find('first', array('conditions' => array('category_id' => $category_id['Category']['category_id'], 'status !=' => 'Trash'), 'fields' => array('MAX(Product.pid) AS maxid', '*')));
						if (!empty($messages[0]['maxid'])) {
							$tiid = $messages[0]['maxid'] + 1;
						} else {
							$tiid = 1;
						}
						
						$exdata['pid'] = $tiid;
						$projectcode = sprintf("%06d", $tiid);
						$exdata['product_code'] = $projectcode;
						
						
						//Metal
						if(!empty($datas[$i]['Metal'])){
							$metal_id = $this->Metal->find('all', array('conditions' => array('metal_name' => $datas[$i]['Metal'])));
							//print_r($metal_id);
							//echo $metal_id['0']['Metal']['metal_name'];
							
							if(!empty($metal_id)){
								$exdata['metal'] = $metal_id['0']['Metal']['metal_name'];
							}else{
								$error .= '<li>Metal not found of row '.$i.' .</li>';
							}
							
						
						}
						
						//Metal Colour
						if(!empty($datas[$i]['Metal_Color'])){
							$Metal_Color = explode(",", $datas[$i]['Metal_Color']);
							$Metal_Color_data = array();
							for($metal_col = 0; $metal_col < sizeof($Metal_Color);$metal_col++){
								//echo $Metal_Color[$metal_col];
								$metalcolor = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $Metal_Color[$metal_col])));
								//echo "<pre>";
								//print_r($metalcolor);
								//echo $metalcolor['Metalcolor']['metalcolor'];
								$Metal_Color_data[] = $metalcolor['Metalcolor']['metalcolor'];
							}
							//print_r($collection_types_data);
							$exdata['metal_color'] = implode(",",$Metal_Color_data);
							
						}
						
						if(!empty($datas[$i]['Gold_Weight'])){
							$exdata['metal_weight'] = $datas[$i]['Gold_Weight'];
						}
						
						if(!empty($datas[$i]['Metal_Fineness'])){
							$exdata['metal_fineness'] = $datas[$i]['Metal_Fineness'];
						}
						
						if(!empty($datas[$i]['Making_Charges_Calculation'])){
							$exdata['making_charge_calc'] = $datas[$i]['Making_Charges_Calculation'];
						}
						
						if(!empty($datas[$i]['Making_Charge'])){
							$exdata['making_charge'] = $datas[$i]['Making_Charge'];
						}
						
						if(!empty($datas[$i]['Width'])){
							$exdata['width'] = $datas[$i]['Width'];
						}
						
						if(!empty($datas[$i]['Height'])){
							$exdata['height'] = $datas[$i]['Height'];
						}
						
						if(!empty($datas[$i]['Stock'])){
							$exdata['stock_quantity'] = $datas[$i]['Stock'];
						}
						
						
						//Another TBL
						if(!empty($datas[$i]['Product_Size'])){
							$Product_Size = explode(",", $datas[$i]['Product_Size']);
							$data_size = array();
							for($prod_size = 0; $prod_size < sizeof($Product_Size);$prod_size++){
							
								$data_size[] = array(
												'category_id' => $category_id['Category']['category_id'],
												'type' => 'Size',
												'value' => $Product_Size[$prod_size]
												);
								
							}
							
							$exdata['product_size'] = $data_size;
							
						}
						
						//Another TBL
						if(!empty($datas[$i]['Gold_Purity'])){
							$Gold_Purity = explode(",", $datas[$i]['Gold_Purity']);
							$data_purity = array();
							for($gold_purity = 0; $gold_purity < sizeof($Gold_Purity);$gold_purity++){
							
								$data_purity[] = array(
												'category_id' => $category_id['Category']['category_id'],
												'type' => 'Purity',
												'value' => $Gold_Purity[$gold_purity]
												);
								
							}
							
							$exdata['gold_purity'] = $data_purity;
							
						}
						
						//Another TBL
						if(!empty($datas[$i]['Is_this_Diamond']) && $datas[$i]['Is_this_Diamond'] == "Yes"){
							$exdata['stone'] = $datas[$i]['Is_this_Diamond'];
							
							$arr_diamond = explode(",", $datas[$i]['Diamond']);
							
							$arr_clarity = explode(",", $datas[$i]['Stone_Clarity']);
							$arr_color = explode(",", $datas[$i]['Stone_Color']);
							$arr_shape = explode(",", $datas[$i]['Stone_Shape']);
							$arr_settingtype = explode(",", $datas[$i]['Setting_Type']);
							$arr_noofdiamonds = explode(",", $datas[$i]['No_of_Diamonds']);
							$arr_stone_weight = explode(",", $datas[$i]['Stone_Weight']);
							
							$data_diamond = array();
							
							for($pro_diamond = 0; $pro_diamond < sizeof($arr_diamond);$pro_diamond++){
								
								$data_diamond[] = array(
												'diamond' => $arr_diamond[$pro_diamond],
												'clarity' => $arr_clarity[$pro_diamond],
												'color' => $arr_color[$pro_diamond],
												'shape' => $arr_shape[$pro_diamond],
												'settingtype' => $arr_settingtype[$pro_diamond],
												'noofdiamonds' => $arr_noofdiamonds[$pro_diamond],
												'stone_weight' => $arr_stone_weight[$pro_diamond]
												);
							}
							
							$exdata['diamond'] = $data_diamond;
							
							
						}else{
							$exdata['stone'] = 'No';
						}
						
						
						//Another TBL
						if(!empty($datas[$i]['Is_this_Gemstone']) && $datas[$i]['Is_this_Gemstone'] == "Yes"){
							$exdata['gemstone'] = $datas[$i]['Is_this_Gemstone'];
							
							$arr_gemstone = explode(",", $datas[$i]['Gemstone']);
							
							$arr_gemsize = explode(",", $datas[$i]['Gemstone_Size']);
							$arr_gemshape = explode(",", $datas[$i]['Gemstone_Stone_Shape']);
							
							$arr_gemsettingtype = explode(",", $datas[$i]['Gemstone_Setting_Type']);
							$arr_gemnoofgemstone = explode(",", $datas[$i]['No_of_Gemstone']);
							$arr_gemstone_weight = explode(",", $datas[$i]['Gemstone_Stone_Weight']);
							
							$data_gemstone = array();
							$stone_price = '';
							
							for($pro_gemstone = 0; $pro_gemstone < sizeof($arr_gemstone);$pro_gemstone++){
							
							
								$shape_id = $this->Shape->find('first', array('conditions' => array('shape' => $arr_gemshape[$pro_gemstone]), 'fields' => array('shape_id')));
								
								//print_r($shape_id);
								
								$gemstone_id = $this->Gemstone->find('first', array('conditions' => array('stone' => $arr_gemstone[$pro_gemstone]), 'fields' => array('gemstone_id')));
								//print_r($gemstone_id);

								$price_value_id = $this->Price->find('first', array('conditions' => array('gemstoneshape' => $shape_id['Shape']['shape_id'], 'gemstone_id' => $gemstone_id['Gemstone']['gemstone_id']), 'fields' => array('price')));
								
								//print_r($price_value_id);
								
								$stone_price = $price_value_id['Price']['price'];
								
								$data_gemstone[] = array(
												'vendor_id' => $exdata['vendor_id'],
												'gemstone' => $arr_gemstone[$pro_gemstone],
												'size' => $arr_gemsize[$pro_gemstone],
												'shape' => $arr_gemshape[$pro_gemstone],
												'settingtype' => $arr_gemsettingtype[$pro_gemstone],
												'no_of_stone' => $arr_gemnoofgemstone[$pro_gemstone],
												'stone_weight' => $arr_gemstone_weight[$pro_gemstone],
												'stone_price' => $stone_price
												);
							}
							
							$exdata['gemstone_data'] = $data_gemstone;
							
							
						}else{
							$exdata['gemstone'] = 'No';
						}
						
						
						if(!empty($datas[$i]['Special_vendor_charges']) && $datas[$i]['Special_vendor_charges'] == "Yes"){
							$exdata['special_work'] = 'Yes';
							
							$exdata['special_work_description'] = $datas[$i]['Special_Work_Description'];
							$exdata['special_work_charge'] = $datas[$i]['Special_Work_Charges'];
							$exdata['vendor_making_charge_calc'] = $datas[$i]['Special_Making_Charges_Calculation'];
							$exdata['vendor_making_charge'] = $datas[$i]['Special_Making_Charges'];
							
						}else{
							$exdata['special_work'] = 'No';
						}
						
						$exdata['vat_cst'] = $datas[$i]['VAT_CST'];
						$exdata['vendor_delivery_tat'] = $datas[$i]['Vendor_delivery_TAT'];
						$exdata['product_delivery_tat'] = $datas[$i]['Product_delivery_TAT'];
						
						
						/*if(!empty($datas[$i]['certificat_image'])){
							$exdata['certificate_image'] = $datas[$i]['certificat_image'];
						}else{
							$exdata['certificate_image'] = '';
						}
						
						
						if(!empty($datas[$i]['Product_images'])){
							$Product_images = explode(",", $datas[$i]['Product_images']);
							//print_r($Product_images);
							$data_images = array();
							for($img = 0; $img < sizeof($Product_images);$img++){
							
								$data_images[] = array(
												'imagename' => $Product_images[$img]
												);
								
							}
							
							$exdata['product_images'] = $data_images;
						}*/
						
						
						
						
						//echo "<pre>";
						//print_r($exdata);
						//echo "End <br/>";
						//exit;
						
						
					}else{
						$error .= '<li>Vendor Product Code already exits in row '.$i.' .</li>';
						//echo "else";
						//exit;
					}
					
				
				}
				
				
				
				if(!empty($error)){
					$errorMsgHeader = '<ul  style="color: red;">';
					$errorMsgFooter = '</ul>';
					
					$this->Session->setFlash("<div class='error msg'>" . __($errorMsgHeader.$error.$errorMsgFooter) . "</div>");
					$this->redirect(array('action' => 'productimport', 'controller' => 'products'));
					
				}else{
				
					$this->Product->save($exdata);
					$product_id = $this->Product->getLastInsertID();
					//$product_id = '12345687879';
					
					//For product_size
					//$exdata['product_size']
					for($prod_size = 0; $prod_size < sizeof($exdata['product_size']);$prod_size++){
						//echo $exdata['product_size'][$prod_size]['category_id'];
						$exdata['product_size'][$prod_size]['product_id'] = $product_id;
						$this->Productmetal->saveAll($exdata['product_size'][$prod_size]);
					}
					
					//print_r($exdata['product_size']);
					
					//For gold_purity
					for($p_purity = 0; $p_purity < sizeof($exdata['gold_purity']);$p_purity++){
						//echo $exdata['gold_purity'][$p_purity]['category_id'];
						$exdata['gold_purity'][$p_purity]['product_id'] = $product_id;
						$this->Productmetal->saveAll($exdata['gold_purity'][$p_purity]);
					}
					
					
					//gemstone_data
					for($i_gemstone = 0; $i_gemstone < sizeof($exdata['gemstone_data']);$i_gemstone++){
						//echo $exdata['gemstone_data'][$i_gemstone]['vendor_id'];
						$exdata['gemstone_data'][$i_gemstone]['product_id'] = $product_id;
						$this->Productgemstone->saveAll($exdata['gemstone_data'][$i_gemstone]);
					}
					
					
					//diamond
					for($i_diamond = 0; $i_diamond < sizeof($exdata['diamond']);$i_diamond++){
						//echo $exdata['diamond'][$i_diamond]['clarity'];
						$exdata['diamond'][$i_diamond]['product_id'] = $product_id;
						$this->Productdiamond->saveAll($exdata['diamond'][$i_diamond]);
					}
					
					$diamonddiv = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $product_id), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));

					$stoneweight = $this->Productdiamond->find('first', array('conditions' => array('product_id' => $product_id, 'color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => 'SUM(stone_weight) AS sweight'));

					$color_id = $this->Color->find('first', array('conditions' => array('color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('color_id')));
					
					$clarity_id = $this->Clarity->find('first', array('conditions' => array('clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('clarity_id')));
					
					$exdata['product_id'] = $product_id;
					$exdata['stoneweight'] = $stoneweight[0]['sweight'];
					$exdata['stone_clarity_id'] = $clarity_id['Clarity']['clarity_id'];
					$exdata['stone_color_id'] = $color_id['Color']['color_id'];
					
					$this->Product->save($exdata);
					
					//product_images
					/*for($i_images = 0; $i_images < sizeof($exdata['product_images']);$i_images++){
						$exdata['product_images'][$i_images]['product_id'] = $product_id;
						$this->Productimage->saveAll($exdata['product_images'][$i_images]);
					}*/
					
					
					//exit;
				
				}
				
                $this->Session->setFlash("<div class='success msg'>" . __('Products Imported successfully.') . "</div>", '');
                $this->redirect(array('action' => 'productimport', 'controller' => 'products'));
            }
        }
    }
	
	
	
	
	
	

    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Product']['product_id'] = $id;
        $this->request->data['Product']['status'] = $status;
        $this->Product->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Product Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

    public function vendor_code() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $this->request->data;
            $vendorcode = $this->Vendor->find('first', array('conditions' => array('vendor_id' => $id)));
            echo $vendorcode['Vendor']['vendor_code'];
        }
    }

    public function category() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $this->request->data;
            $subcategory = $this->Subcategory->find('all', array('conditions' => array('category_id' => $id, 'status' => 'Active')));

            if (!empty($subcategory)) {
                echo json_encode($subcategory);
            } else {
                echo '[]';
            }
        }
    }

    public function stone() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $stone = $this->Diamond->find('all', array('conditions' => array('status' => 'Active')));

            if (!empty($stone)) {
                echo json_encode($stone);
            } else {
                echo '[]';
            }
        }
    }

    public function stone_clarity() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $stone_clarity = $this->Clarity->find('all', array('conditions' => array('status' => 'Active')));
            if (!empty($stone_clarity)) {
                echo json_encode($stone_clarity);
            } else {
                echo '[]';
            }
        }
    }

    public function stone_color() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $_REQUEST['id'];
            $stone_color = $this->Color->find('all', array('conditions' => array('clarity' => $id, 'status' => 'Active')));
            if (!empty($stone_color)) {
                echo json_encode($stone_color);
            } else {
                echo '[]';
            }
        }
    }

    public function diamonds() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $stone_color = $this->Jeweltype->find('all', array('conditions' => array('type' => 'Stone Color', 'status' => 'Active')));
            if (!empty($stone_color)) {
                echo json_encode($stone_color);
            } else {
                echo '[]';
            }
        }
    }

    public function stone_carat() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $stone_carat = $this->Carat->find('all', array('conditions' => array('status' => 'Active')));
            if (!empty($stone_carat)) {
                echo json_encode($stone_carat);
            } else {
                echo '[]';
            }
        }
    }

    public function gem() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $gemstone = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active')));
            if (!empty($gemstone)) {
                echo json_encode($gemstone);
            } else {
                echo '[]';
            }
        }
    }

    public function stone_shape() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $stone_shape = $this->Shape->find('all', array('conditions' => array('status' => 'Active')));
            if (!empty($stone_shape)) {
                echo json_encode($stone_shape);
            } else {
                echo '[]';
            }
        }
    }

    public function setting_type() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $setting = $this->Settingtype->find('all', array('conditions' => array('status' => 'Active')));
            if (!empty($setting)) {
                echo json_encode($setting);
            } else {
                echo '[]';
            }
        }
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Product->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Product->exists()) {
                throw new NotFoundException(__('Invalid Product'));
            }

            $this->request->data['Product']['product_id'] = $this->params['pass']['0'];
            $this->request->data['Product']['status'] = 'Trash';
            $this->Product->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Product has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $productdelete) {
                    if ($productdelete > 0) {
                        $this->request->data['Product']['product_id'] = $productdelete;
                        $this->request->data['Product']['status'] = 'Trash';
                        $this->Product->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Product has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_addimages() {
        $this->checkadmin();
        $product = $this->Product->find('first', array('conditions' => array('product_id' => $this->params['pass']['0'])));
        $this->set('product', $product);
        $vendor = $this->Vendor->find('all', array('conditions' => array('vendor_id' => $product['Product']['vendor_id'])));
        $this->set('vendor', $vendor);
        if ($this->request->is('post')) {
            $project = $this->Productimage->find('first');
            $count = count($this->request->data['Productimage']['image']);
            $this->request->data['Productimage']['status'] = 'Active';
            $this->request->data['Productimage']['product_id'] = $this->params['pass']['0'];
            for ($i = 0; $i < $count; $i++) {
                if (!empty($this->request->data['Productimage']['image'][$i]['name'])) {
                    $this->request->data['Productimage']['image'][$i] = $this->Image->upload_image_and_thumbnail($this->request->data['Productimage']['image'][$i], 480, 385, 265, 218, "product");
                }
            }foreach ($this->request->data['Productimage']['image'] as $images) {
                $this->request->data['Productimage']['imagename'] = $images;
                $this->Productimage->saveAll($this->request->data);
            }
            $this->Session->setFlash('<div class="success msg">Inserted Successfully</div>');
            $this->redirect(array('action' => 'addimages', $this->params['pass']['0']));
        }
        $images = $this->Productimage->find('all', array('conditions' => array('product_id' => $this->params['pass'][0], 'status' => 'Active')));
        $this->set('images', $images);
    }

    public function admin_deleteimages() {
        $this->checkadmin();
        if (!empty($this->params['pass']['1'])) {
            $this->Productimage->id = $this->params['pass']['1'];
            $id = $this->params['pass']['1'];
            if (!$this->Productimage->exists()) {
                throw new NotFoundException(__('Invalid Image'));
            }$this->request->data['Productimage']['image_id'] = $this->params['pass']['1'];
            $this->request->data['Productimage']['status'] = 'Trash';
            $this->Productimage->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Product Image has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_edit', $this->params['pass']['0']));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $imagedelete) {
                    if ($imagedelete > 0) {
                        $this->request->data['Productimage']['image_id'] = $imagedelete;
                        $this->request->data['Productimage']['status'] = 'Trash';
                        $this->Productimage->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Images has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_edit', $this->params['pass']['0']));
        }
    }
	
	 public function admin_deletecertificate() {
        $this->checkadmin();
        
           
			$this->Product->id = $this->Product->field('product_id', array('product_id' => $this->params['pass']['0']));
			if ($this->Product->id) {
				$this->Product->saveField('certificate_image', "");
			}
           
            $this->Session->setFlash("<div class='success msg'>" . __('Ceritficate has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_edit', $this->params['pass']['0']));
    }

    public function admin_product_export() {
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
//        create a file
        $filename = "product_details.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

		$search = array();
		$search = array('status !=' => 'Trash');
		if ($this->request->query('search') != '') {
            
            if (($this->request->query('cdate') != '') && ($this->request->query('edate') != '')) {
                $search = array_merge($search, array('Product.created_date BETWEEN \'' . $_REQUEST['cdate'] . '\' AND \'' . $_REQUEST['edate'] . '\''));
            } elseif ($this->request->query('cdate') != '') {
                $search['created_date'] = $this->request->query('cdate');
            } elseif ($this->request->query('edate') != '') {
                $search['created_date'] = $this->request->query('edate');
            }
            if ($this->request->query('searchvendorname') != '') {
                $vendor = $this->Vendor->find('first', array('conditions' => array('vendor_id' => $this->request->query('searchvendorname'))));
                $this->set('vendor', $vendor);
                $search['vendor_id'] = $vendor['Vendor']['vendor_id'];
            }if ($this->request->query('productname') != '') {
                $search = array_merge($search, array('Product.product_name Like "%' . $this->request->query('productname') . '%"'));
            }
            if ($this->request->query('productcode') != '') {
                $result = preg_split('/(?<=\d)(?=[a-z])|(?<=[a-z])(?=\d)/i', $this->request->query('productcode'));
                $cat = $result[0];
                $productcode = $result[1];
                $cat = $this->Category->findByCategoryCode($cat);
                if(!empty($cat))
                    $search['category_id'] = $cat['Category']['category_id'];
                $search = array_merge($search, array('Product.product_code Like "%' . $productcode . '%"'));
            }
            if ($this->request->query('searchcategory') != '') {
                //print_r($this->request->query('searchcategory'));exit;
                $search['category_id'] = $this->request->query('searchcategory');
            }
			
			
			/* start for vendor session condition*/
				if ( isset($_SESSION['Adminuser']['vendor_id']) && !empty($_SESSION['User']['login_type'] ) && $_SESSION['User']['login_type'] == "Vendor" ) {
					$search['vendor_id'] = $_SESSION['Adminuser']['vendor_id'];
				}
			/* end for vendor session condition*/
			
			//print_r($search);
			//exit;
		}
		
        $results_head = $this->Product->find('all', array('conditions' => $search));
        $pro_diamond_hd[] = array();
        $pro_gemstone_hd[] = array();
        foreach ($results_head as $results_head) {
            $pro_diamond_hd[] = $this->Productdiamond->find('count', array('conditions' => array('product_id' => $results_head['Product']['product_id'])));
            $pro_gemstone_hd[] = $this->Productgemstone->find('count', array('conditions' => array('product_id' => $results_head['Product']['product_id'])));
        }


        $results = $this->Product->find('all', array('conditions' => $search));
        //added by prakash
        $product_type = array(
            '1' => 'Plain Gold',
            '2' => 'Diamond',
            '3' => 'Gemstone'
        );
        $collection_type = $this->Collectiontype->find('list', array('fields' => array('collectiontype_id', 'collection_name'), 'conditions' => '', 'order' => 'collectiontype_id ASC'));
        $product_view_type = array(
            '1' => 'New',
            '2' => 'Sale',
        );
        $this->Menu->Behaviors->attach('Containable');
        $menus = $this->Menu->find('all', array(
            'contain' => array(
                'Submenu' => array(
                    'Offer' => array(
                        'conditions' => array('Offer.is_active' => '1')
                    ),
                    'conditions' => array(
                        'Submenu.is_active' => '1'
                    )
                )),
            'conditions' => array(
                'Menu.is_active' => '1',
                'Menu.menu_id' => array(3, 4, 5, 6, 7, 8)
        )));

        $header_menus_list = array();
        foreach ($menus as $menu) {
            $header_menus_list[] = $menu['Menu']['menu_name'];
        }
        //
        $header_row = array("S.No", "Product Nmae", "Product Code", "Link", "Category", "Sub Category", "Vendor", "vendor product code",
            "Metal", "Metal Color", "Product weight", "Stone", "Special Work", "Gemstone", "Special Work Description",
            "Special work charge", "Vendor Making Charges Calculation", "vendor_making_charge", "vat_cst", "vendor_delivery_tat", "product_delivery_tat", "status",
            "Diamond", "Stone Clarity & Color", "Stone Carat", "no_of_diamonds", "stone_shape", "stone weight",
            "setting_type", "Gemstone ", "size ", "Shape ", "Stone weight ", "no of Stone ", "Setting type ", "Size ", "Purity",
            "Product Type", "Collection Type", "Product View type", "Best Seller", "Making Charges Calculation", "Making Charge", "Height", "Width", "Stock");

        $header_row = array_merge($header_row, $header_menus_list);
        fputcsv($csv_file, $header_row, ',', '"');

        $i = 1;
        foreach ($results as $results) {

            $product = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $results['Product']['product_id']), array(/* 'limit' => '1' */)));
            $product_count = $this->Productdiamond->find('count', array('conditions' => array('product_id' => $results['Product']['product_id'])));
            $productgem = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $results['Product']['product_id']), array(/* 'limit' => '1' */)));
            $productgem_count = $this->Productgemstone->find('count', array('conditions' => array('product_id' => $results['Product']['product_id'])));
            $productmetal = $this->Productmetal->find('all', array('conditions' => array('product_id' => $results['Product']['product_id'], 'type' => 'Size')));
            $productmetal_count = $this->Productmetal->find('count', array('conditions' => array('product_id' => $results['Product']['product_id'], 'type' => 'Size')));
            $productsize = $this->Productmetal->find('all', array('conditions' => array('product_id' => $results['Product']['product_id'], 'type' => 'Purity')));
            $productsize_count = $this->Productmetal->find('count', array('conditions' => array('product_id' => $results['Product']['product_id'], 'type' => 'Purity')));

            $products = array();

            if ($product_count == 0) {
                $products[] = ' ';
                $products[] = ' ';
//                $products[] = ' ';
                $products[] = ' ';
                $products[] = ' ';
                $products[] = ' ';
                $products[] = ' ';
                $products[] = ' ';
            } else {
                $p_stone = $p_clr = $p_col = $p_car = $p_no_dia = $p_shp = $p_st_wgh = $p_set = '';
                foreach ($product as $key => $p_diamond) {
                    $p_stone_name = $p_diamond['Productdiamond']['diamond'];
                    $p_clr_name = $p_diamond['Productdiamond']['clarity'];
                    $p_col_name = $p_diamond['Productdiamond']['color'];
                    $p_car_name = $p_diamond['Productdiamond']['carat'];
                    $p_no_dia_name = $p_diamond['Productdiamond']['noofdiamonds'];
                    $p_shp_name = $p_diamond['Productdiamond']['shape'];
                    $p_st_wgh_name = $p_diamond['Productdiamond']['stone_weight'];
                    $p_set_name = $p_diamond['Productdiamond']['settingtype'];

                    if ($p_stone_name != '') {
                        $p_stone .= $key == 0 ? $p_stone_name : ', ' . $p_stone_name;
                    }
                    if ($p_clr_name != '' || $p_col_name != '') {
                        $p_clr .= $key == 0 ? "$p_clr_name-$p_col_name" : ', ' . "$p_clr_name-$p_col_name";
                    }
                    if ($p_col_name != '') {
                        $p_col .= $key == 0 ? $p_col_name : ', ' . $p_col_name;
                    }
                    if ($p_car_name != '') {
                        $p_car .= $key == 0 ? $p_car_name : ', ' . $p_car_name;
                    }
                    if ($p_shp_name != '') {
                        $p_shp .= $key == 0 ? $p_shp_name : ', ' . $p_shp_name;
                    }
                    if ($p_st_wgh_name != '') {
                        $p_st_wgh .= $key == 0 ? $p_st_wgh_name : ', ' . $p_st_wgh_name;
                    }
                    if ($p_set_name != '') {
                        $p_set .= $key == 0 ? $p_set_name : ', ' . $p_set_name;
                    }
                }

                $products[] = $p_stone;
                $products[] = $p_clr;
//                $products[] = $p_col;
                $products[] = $p_car;
                $products[] = $p_no_dia;
                $products[] = $p_shp;
                $products[] = $p_st_wgh;
                $products[] = $p_set;
            }
            $productgemstonenew = array();
            if ($productgem_count == 0) {
                $productgemstonenew[] = ' ';
                $productgemstonenew[] = ' ';
                $productgemstonenew[] = ' ';
                $productgemstonenew[] = ' ';
                $productgemstonenew[] = ' ';
                $productgemstonenew[] = ' ';
            } else {
                $p_stone = $p_size = $p_no_dia = $p_shp = $p_st_wgh = $p_set = '';
                foreach ($productgem as $key => $p_gem) {
                    $p_stone_name = $p_gem['Productgemstone']['gemstone'];
                    $p_no_dia_name = $p_gem['Productgemstone']['no_of_stone'];
                    $p_shp_name = $p_gem['Productgemstone']['shape'];
                    $p_st_wgh_name = $p_gem['Productgemstone']['stone_weight'];
                    $p_set_name = $p_gem['Productgemstone']['settingtype'];
                    $p_size_name = $p_gem['Productgemstone']['size'];

                    if ($p_stone_name != '') {
                        $p_stone .= $key == 0 ? $p_stone_name : ', ' . $p_stone_name;
                    }
                    if ($p_car_name != '') {
                        $p_car .= $key == 0 ? $p_car_name : ', ' . $p_car_name;
                    }
                    if ($p_shp_name != '') {
                        $p_shp .= $key == 0 ? $p_shp_name : ', ' . $p_shp_name;
                    }
                    if ($p_st_wgh_name != '') {
                        $p_st_wgh .= $key == 0 ? $p_st_wgh_name : ', ' . $p_st_wgh_name;
                    }
                    if ($p_set_name != '') {
                        $p_set .= $key == 0 ? $p_set_name : ', ' . $p_set_name;
                    }
                    if ($p_size_name != '') {
                        $p_size .= $key == 0 ? $p_size_name : ', ' . $p_size_name;
                    }
                }

                $products[] = $p_stone;
                $products[] = $p_no_dia;
                $products[] = $p_shp;
                $products[] = $p_st_wgh;
                $products[] = $p_set;
                $products[] = $p_size;
            }
            $productmetalnew = array();
            if ($productmetal_count == 0) {
                //  $productmetalnew[]=' ';
                $productmetalnew[] = ' ';
            } else {
                $Productmetal_type = "";
                $Productmetal_value = "";

                foreach ($productmetal as $productmetaldiv) {
                    $Productmetal_type = $productmetaldiv['Productmetal']['type'];
                    if ($productmetaldiv['Productmetal']['category_id'] != '3') {
                        $Productmetal_value.=$productmetaldiv['Productmetal']['value'] . ",";
                    } else {
                        $productbanglesize = $this->Size->find('first', array('conditions' => array('size_value' => $productmetaldiv['Productmetal']['value'])));
                        isset($productbanglesize['Size']['size']) ? $Productmetal_value.=$productbanglesize['Size']['size'] . "," : '';
                    }
                }
                $Productmetal_type = rtrim($Productmetal_type, ",");
                $Productmetal_value = rtrim($Productmetal_value, ",");

                //$productmetalnew[]=$Productmetal_type;
                $productmetalnew[] = $Productmetal_value;
            }

            $productsizenew = array();

            if ($productsize_count == 0) {
                //  $productsizenew[]=' ';
                $productsizenew[] = ' ';
            } else {

                $Productmetal_type = "";
                $Productmetal_value = "";

                foreach ($productsize as $productsizediv) {
                    $Productmetal_type = $productsizediv['Productmetal']['type'];
                    $Productmetal_value.=$productsizediv['Productmetal']['value'] . ",";
                }
                $Productmetal_type = rtrim($Productmetal_type, ",");
                $Productmetal_value = rtrim($Productmetal_value, ",");

                //  $productsizenew[]=$Productmetal_type;
                $productsizenew[] = $Productmetal_value;
            }
            $vendor = $this->Vendor->find('first', array('conditions' => array('vendor_id' => $results['Product']['vendor_id'])));
            $name = $vendor['Vendor']['Company_name'];

            $category = $this->Category->find('first', array('conditions' => array('category_id' => $results['Product']['category_id'])));
            $code = $category['Category']['category_code'];
            $pattern = "/(\d+)/";
            $array = preg_split($pattern, $code, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            $category1 = $category['Category']['category'];
            if (!empty($results['Product']['subcategory_id'])) {
                $sub = $this->Subcategory->find('first', array('conditions' => array('subcategory_id' => $results['Product']['subcategory_id'])));
                $subcategory = $sub['Subcategory']['subcategory'];
            } else {
                $subcategory = '';
            }
            $row = array(
                $i,
                $results['Product']['product_name'],
                $array[0] . $results['Product']['product_code'],
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
                $results['Product']['vendor_making_charge_calc'] == 'PER' ? '%' : 'INR',
                $results['Product']['vendor_making_charge'],
                $results['Product']['vat_cst'],
                $results['Product']['vendor_delivery_tat'],
                $results['Product']['product_delivery_tat'],
                $results['Product']['status']
            );
            $row = array_merge($row, $products);
            $row = array_merge($row, $productgemstonenew);
            $row = array_merge($row, $productmetalnew);
            $row = array_merge($row, $productsizenew);

            //added by prakash
            $p_type = $col_type = $p_v_type = $b_seller = '';
            if ($results['Product']['product_type'] != '') {
                $p_type_exp = explode(',', $results['Product']['product_type']);
                foreach ($p_type_exp as $key => $exp) {
                    $p_type .= $key == 0 ? $product_type[$exp] : ', ' . $product_type[$exp];
                }
            }
            if ($results['Product']['collection_type'] != '') {
                $col_type_exp = explode(',', $results['Product']['collection_type']);
                foreach ($col_type_exp as $key => $exp) {
                    $col_type .= $key == 0 ? $collection_type[$exp] : ', ' . $collection_type[$exp];
                }
            }
            if ($results['Product']['product_view_type'] != '') {
                $p_v_type_exp = explode(',', $results['Product']['product_view_type']);
                foreach ($p_v_type_exp as $key => $exp) {
                    $p_v_type .= $key == 0 ? $product_view_type[$exp] : ', ' . $product_view_type[$exp];
                }
            }
            if ($results['Product']['best_seller'] != 1) {
                $b_seller = 'Yes';
            }


            $row = array_merge($row, array($p_type));
            $row = array_merge($row, array($col_type));
            $row = array_merge($row, array($p_v_type));
            $row = array_merge($row, array($b_seller));
            $row = array_merge($row, array($results['Product']['making_charge_calc'] == 'PER' ? '%' : 'INR'));
            $row = array_merge($row, array($results['Product']['making_charge']));
            $row = array_merge($row, array($results['Product']['height']));
            $row = array_merge($row, array($results['Product']['width']));
            $row = array_merge($row, array($results['Product']['stock_quantity']));

            $p_menu_exp = explode(",", $results['Product']['submenu_ids']);
            $p_offer_exp = explode(",", $results['Product']['offer_ids']);
            foreach ($menus as $menu) {
                $p_menu = $off_name = '';
                if ($results['Product']['submenu_ids'] != '') {
                    foreach ($menu['Submenu'] as $key => $submenu) {
                        if (in_array($submenu['submenu_id'], $p_menu_exp)) {
                            $sb_name = $submenu['submenu_name'];

                            if ($results['Product']['offer_ids'] != '') {
                                if (!empty($submenu['Offer'])) {
                                    $off_name = '(';
                                    foreach ($submenu['Offer'] as $o_key => $offer) {
                                        if (in_array($offer['offer_id'], $p_offer_exp)) {
                                            $off_name .= $o_key == 0 ? $offer['offer_name'] : ', ' . $offer['offer_name'];
                                        }
                                    }
                                    $off_name .= ')';
                                }
                                $sb_name .= $off_name;
                            }
                            $p_menu .= $key == 0 ? $sb_name : ', ' . $sb_name;
                        }
                    }
                }
                $row = array_merge($row, array($p_menu));
            }
            //
            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }

    /* public function admin_product_export() {

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


      } */

    public function productsize() {

        $this->layout = '';
        $this->render(false);
        $id = $_REQUEST['id'];
        $size = $this->Size->find('all', array('conditions' => array('category_id' => $id), 'group' => 'size', 'order' => 'size_id ASC'));
        $category = $this->Category->find('first', array('conditions' => array('category_id' => $id)));
        if (!empty($size)) {
            echo '<input type="checkbox" id="selecctall">&nbsp;Select all&nbsp;<br>';
            foreach ($size as $size) {
                if ($category['Category']['category'] != 'Bangles') {
                    $val = $size['Size']['size_value'];
                } else {
                    $val = $size['Size']['size_value'];
                }

                echo '<input type="checkbox" name="data[Productmetal][size][]"  class="validate[required] checkbox1" value="' . $val . '"/>' . $size['Size']['size'] . '&nbsp;';
            }
        } else {
            echo 'No';
        }
    }

    public function metalcolor() {

        $this->layout = '';
        $this->render(false);
        $id = $_REQUEST['id'];
        if ($id != '0') {
            $metalnew = $this->Metal->find('first', array('conditions' => array('metal_name' => $id)));
            $metal = $this->Metalcolor->find('all', array('conditions' => array('metal_id' => $metalnew['Metal']['metal_id'])));

            if (!empty($metal)) {

                foreach ($metal as $metal) {

                    echo '<input type="checkbox" name="data[Product][metal_color][]" class="validate[required] colosdiv" value="' . $metal['Metalcolor']['metalcolor'] . '"/>' . $metal['Metalcolor']['metalcolor'] . '&nbsp;';
                }
            } else {
                echo 'No';
            }
        } else {
            echo 'No';
        }
    }

    public function gold_purity() {

        $this->layout = '';
        $this->render(false);
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active')));
        if (!empty($purity)) {
            echo json_encode($purity);
        } else {
            echo '[]';
        }
    }

    public function metal_weight() {

        $this->layout = '';
        $this->render(false);
        $jewel = $this->Size->find('all', array('conditions' => array('category_id' => $_REQUEST['id'])));
        //if(!empty($jewel))
        //{
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active')));
        if (!empty($purity)) {
            //echo '<fieldset><legend>Metal Details</legend> <dt><label for="name">Gold Purity <span class="required">*</span></label></dt><dd>';
            echo '<input type="checkbox" id="selecctall_purity">&nbsp;Select all&nbsp;<br>';
            foreach ($purity as $purities) {
                echo' <input type="checkbox" name="data[Productmetal][purity][]" value="' . $purities['Purity']['purity'] . '" class="checkboxp">' . $purities['Purity']['purity'] . 'K';
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
          echo '</select>'; */
        //</dd>';
//					   
//						echo '<dt><label for="name">Weight<span class="required">*</span></label></dt>';
//						echo '<dd><input type="text" name="data[Productmetal][0][weight]" id="weight"  class="validate[required,custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10 value=""/>&nbsp;</dd> '; 
//						echo '  <dt><label for="name">Gold Difference</label></dt>';
//                        echo '<dd><input type="text" name="data[Productmetal][0][gold_diff]" id="gold_diff"  class="validate[custom[number]]" size="50" onkeypress="return floatnumbers(this,event)" maxlength=10  value=""/>&nbsp;';*/
        /* echo '  &nbsp;&nbsp;&nbsp;<button type="button"  class="button add_weight" name="addstone" value="">Add </button></dd></fieldset>';
          echo ' <input type="hidden" name="offical_contacts" id="add_weight_cat" value="0"/>'; */

        //}
    }

    public function gold_purity_check() {

        $this->layout = '';
        $this->render(false);
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active')));
        if (!empty($purity)) {
            foreach ($purity as $purities) {
                echo '<input type="checkbox" name="data[Productsize][goldpurity][]" value="' . $purities['Purity']['purity_id'] . '">' . $purities['Purity']['purity'] . 'K';
            }
        } else {
            echo '';
        }
    }

    public function admin_get_brokerage_amount($productid, $cartid) {
        $product = $this->Product->findByProductId($productid);
        $this->Shoppingcart->bindModel(
                array(
            'belongsTo' => array(
                'Order' => array(
                    'type' => 'Inner',
                    'conditions' => array('Shoppingcart.order_id = Order.order_id'),
                    'foreignKey' => false,
                ),
                'User' => array(
                    'type' => 'Inner',
                    'conditions' => array('Order.user_id = User.user_id'),
                    'foreignKey' => false,
                ),
            )
                ), false
        );
        $cart = $this->Shoppingcart->findByCartId($cartid);
        $brokerage_amount = $making_charge = 0;
        if (!empty($product) && !empty($cart)) {
            $netamt = $cart['Shoppingcart']['total'] * $cart['Shoppingcart']['quantity'];

            //vendor brokerage
            if ($cart['User']['user_type'] == 0) {
                $special_charge = $product['Product']['special_work_charge'];
                if ($product['Product']['vendor_making_charge_calc'] == 'PER') {
                    $making_charge = $netamt * ($product['Product']['vendor_making_charge'] / 100);
                } elseif ($product['Product']['vendor_making_charge_calc'] == 'INR') {
                    $making_charge = $product['Product']['vendor_making_charge'];
                }
                //franchisee brokerage
            } elseif ($cart['User']['user_type'] == 1) {
                $frans_brkge = $this->Franchiseebrokerage->findByFranchiseeBrkgeUserId($cart['User']['user_id']);
                $special_charge = 0;

                if (!empty($frans_brkge)) {
                    if ($cart['User']['pincode'] == $cart['Order']['pincode']) {
                        $frans_brkge_charge = $frans_brkge['Franchiseebrokerage']['pincodewise_brkge_value'];
                    } else {
                        $frans_brkge_charge = $frans_brkge['Franchiseebrokerage']['general_brkge_value'];
                    }

                    if ($frans_brkge['Franchiseebrokerage']['brkge_calc'] == 'PER') {
                        $making_charge = $netamt * ($frans_brkge_charge / 100);
                    } elseif ($frans_brkge['Franchiseebrokerage']['brkge_calc'] == 'INR') {
                        $making_charge = $frans_brkge_charge;
                    }
                } else {
                    $making_charge = 0;
                }
            }
            $brokerage_amount = $special_charge + $making_charge;
        }
        return $brokerage_amount;
    }

    public function metalcolor_dd() {
        $this->layout = '';
        $this->render(false);
        $id = $_REQUEST['id'];
        $dd = "<select name='mcolor' style='width:100px;'>";
        $dd .= "<option value=''>Select</option>";
        if ($id != '0' && $id != '') {
            $metalnew = $this->Metal->find('first', array('conditions' => array('metal_name' => $id)));
            $metals = $this->Metalcolor->find('all', array('conditions' => array('metal_id' => $metalnew['Metal']['metal_id'])));
            if (!empty($metals)) {
                foreach ($metals as $metal) {
                    $dd .= "<option value='{$metal['Metalcolor']['metalcolor']}'>{$metal['Metalcolor']['metalcolor']}</option>";
                }
            }
        }
        $dd .= "</select>";
        echo $dd;
    }

    public function metal_weight_dd() {
        $this->layout = '';
        $this->render(false);
        $jewel = $this->Size->find('all', array('conditions' => array('category_id' => $_REQUEST['id'])));
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active')));
        $dd = "<select name='mpurity' style='width:100px;'>";
        $dd .= "<option value=''>Select</option>";
        if (!empty($purity)) {
            foreach ($purity as $purities) {
                $dd .= "<option value='{$purities['Purity']['purity']}'>{$purities['Purity']['purity']} K</option>";
            }
        }
        $dd .= "</select>";
        echo $dd;
    }

}
