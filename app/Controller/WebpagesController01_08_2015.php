<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class WebpagesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Cookie', 'Image');
    public $uses = array('Banner', 'Advertisement', 'Newsletter', 'Jeweltype', 'Testimonial', 'Enquries', 'Question', 'Rating', 'Product', 'Whislist', 'Shippingrate', 'Subcategory', 'Productsize', 'Price', 'Productstone', 'Category', 'Size', 'Metalcolor', 'Metal', 'Diamond', 'Gemstone', 'Clarity', 'Color', 'Carat', 'Shape', 'Settingtype', 'Purity', 'Productmetal', 'Productgemstone', 'Productdiamond', 'Staticpage', 'Category', 'Jewellrequest', 'Jewelldiamond', 'Jewellstone', 'Collectiontype', 'Submenu', 'Offer', 'User', 'Shoppingcart','Locateus');
    public $layout = 'webpage';

    public function index() {

        $banner = $this->Banner->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('banner', $banner);
        $advertisement = $this->Advertisement->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('advertisement', $advertisement);
        $testimonial = $this->Testimonial->find('all', array('conditions' => array('status' => 'Active', 'type' => 'Testimonial'), 'limit' => '2'));
        $this->set('test', $testimonial);
        $title = 'Online Shopping Jewellery Store India | Buy Gold and Diamond Jewellery | shagunn.in';
        $this->set('title', $title);
    }

    public function newsletter() {
        if ($this->request->is('ajax')) {
            $this->layout = '';
            $this->render(false);
            $id = $_REQUEST['id'];
            $newsletter = $this->Newsletter->find('first', array('conditions' => array('email' => $id, 'status' => 'Active')));
            if (empty($newsletter['Newsletter']['email'])) {
                $this->request->data['Newsletter']['email'] = $id;
                $this->request->data['Newsletter']['status'] = 'Active';
                $this->Newsletter->save($this->request->data);
                echo "Your subscription has been sent successfully";
            } else {
                echo "The subscription already exits";
            }
        }
    }

    public function jewellery() {
        $title = 'All Jewellery | shagunn.in';
        $this->set('title', $title);
    }

    public function category_list() {
        
    }

    public function product_details() {
        if ($this->Session->read('browse') == '') {
            $this->Session->write('browse', array());
        }
        $product_name_par = $this->params['pass']['2'];
        $firstpro = $this->Product->find('first', array('conditions' => array('product_id' => $product_name_par)));
        $title = $firstpro['Product']['product_name'] . ' | shagunn.in';
        $this->set('title', $title);
        if (!in_array($firstpro['Product']['product_id'], $this->Session->read('browse'))) {
            $array = array_merge(array($firstpro['Product']['product_id']), $this->Session->read('browse'));
            $this->Session->write('browse', $array);
        }

        $browse_product = array_diff($this->Session->read('browse'), array($firstpro['Product']['product_id']));

        $browse_products = $this->Product->find('all', array('conditions' => array('product_id' => $browse_product, 'status' => 'Active')));
        $this->set('browse_product', $browse_products);

        $colors = $this->Product->find('all', array('conditions' => array('product_id' => $product_name_par)));
        $this->set('colors', $colors);




        $customer = $this->Testimonial->find('all', array('conditions' => array('status' => 'Active', 'type' => 'Customer says'), 'limit' => '2'));
        $this->set('customer', $customer);

        /** Rating and Reviews * */
        if (isset($this->request->data['Rating']['ratingsubmit'])) {
            $this->request->data['Rating']['product_id'] = $firstpro['Product']['product_id'];
            $this->request->data['Rating']['status'] = 'Active';
            $this->request->data['Rating']['created_date'] = date('Y-m-d H:i:s');
            $this->Rating->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Rating & Reviews  saved successfully.') . "</div>");
            $this->redirect(array('action' => 'product_details', $this->params['pass']['0']));
        }


        /** Have a question * */
        if (isset($this->request->data['Question']['questionsubmit'])) {
            $this->request->data['Question']['product_id'] = $firstpro['Product']['product_id'];
            $this->request->data['Question']['created_date'] = date('Y-m-d H:i:s');
            $this->Question->save($this->request->data);
            $name = $this->request->data['Question']['name'];
            $email = $this->request->data['Question']['email'];
            $contact_no = $this->request->data['Question']['contact_no'];
            $question = $this->request->data['Question']['question'];

            $product = $this->Product->find('first', array('conditions' => array('product_id' => $product_name_par)));
            $this->set('product', $product);

            $products = $product['Product']['product_name'];

            $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 6)));
            $message = str_replace(array('{name}', '{product}', '{email}', '{contact_no}', '{question}'), array($name, $products, $email, $contact_no, $question), $activateemail['Emailcontent']['content']);


            $this->mailsend(SITE_NAME, $email, $activateemail['Emailcontent']['fromemail'], $activateemail['Emailcontent']['subject'], $message);
            $this->Session->setFlash("<div class='success msg'>" . __('Question  saved successfully.') . "</div>");
            $this->redirect(array('action' => 'product_details', $this->params['pass']['0']));
        }


        /** count review and rating * */
        $reviewcount = $this->Rating->find('count', array('conditions' => array('product_id' => $firstpro['Product']['product_id'])));
        $this->set('reviewcount', $reviewcount);

        $rating = $this->Rating->find('all', array('fields' => array('SUM(Rating.rate) as total'), 'conditions' => array('product_id' => $firstpro['Product']['product_id']), 'group' => array('Rating.product_id')));
        $this->set('rating', $rating);
    }

    public function product() {

        $metals = $this->Metal->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
        $this->set('metal', $metals);
        $diamond = $this->Diamond->find('first', array('conditions' => array('status' => 'Active'), 'order' => 'diamond_id ASC'));
        $this->set('diamond', $diamond);
        $stone = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
        $this->set('stone', $stone);
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'purity_id ASC'));
        $this->set('purity', $purity);
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
        $this->set('collections', $this->Collectiontype->find('all'));
        //IF(Product.category_id=1,(SELECT SUM() ))
        //modified by prakash for metal fineness calculations
        $field = array('ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight) AS metalprice',
            '(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness) AS price',
            'IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0) AS stoneprice', 'IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0) AS gemstoneprice,Product.making_charge AS mc,Product.vat_cst As vat',
            '(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
		 ROUND((ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) AS totprice',
            'Product.*');

        //Issue query . Takes more time to retrieve. so commented.
//       $field = array('ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))* Product.metal_weight) AS metalprice',
//            '(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness) AS price',
//            'IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0) AS stoneprice',
//            'IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0) AS gemstoneprice,
//		Product.making_charge AS mc,
//		Product.vat_cst As vat',
//            '((ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id   ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',(ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\'))),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100) AS vatprice',
//            'ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100) AS makingprice',
//            '(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
//		 ROUND((ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id   ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',(ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\'))),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) AS totprice',
//            'Product.*');

        $joins = $group = $order = '';
        $joins = array();
        if (!empty($this->params['pass']['0'])) {
            $cat = $this->Category->find('first', array('conditions' => array('LOWER(category)' => str_replace('_', ' ', $this->params['pass']['0']))));
            if (!empty($cat)) {
                $conditions['Product.category_id'] = $cat['Category']['category_id'];
                if (!empty($this->params['pass']['1'])) {
                    $subcategory = str_replace(array('0_5', '_',), array('0.5', ' '), $this->params['pass']['1']);
                    $sub_cat = $this->Subcategory->find('first', array('conditions' => array('LOWER(subcategory)' => $subcategory, 'category_id' => $cat['Category']['category_id'])));
                    if (!empty($sub_cat)) {
                        $conditions['Product.subcategory_id'] = $sub_cat['Subcategory']['subcategory_id'];
                    }
                }
            }
        }
        $conditions['Product.status'] = 'Active';
        if (!empty($_GET)) {
            if (!empty($_GET['category'])) {
                $cat = $this->Category->find('first', array('conditions' => array('LOWER(category)' => str_replace('_', ' ', $_GET['category']))));
                if (!empty($cat)) {
                    $conditions['Product.category_id'] = $cat['Category']['category_id'];
                    if (!empty($_GET['subcategory'])) {
                        $sub_cat = $this->Subcategory->find('first', array('conditions' => array('LOWER(subcategory)' => str_replace('_', ' ', $_GET['subcategory']), 'category_id' => $cat['Category']['category_id'])));
                        if (!empty($sub_cat)) {
                            $conditions['Product.subcategory_id'] = $sub_cat['Subcategory']['subcategory_id'];
                        }
                    }
                }
            }

            if (!empty($_GET['search'])) {
                $category = $this->Category->find('all', array('conditions' => array('category LIKE ' => '%' . $_GET['search'] . '%', 'status' => 'Active')));
                $search_cat = array();
                if (!empty($category)) {
                    foreach ($category as $category) {
                        $search_cat[] = $category['Category']['category_id'];
                    }
                    $conditions['Product.category_id'] = $search_cat;
                } else {
                    $subcategory = $this->Subcategory->find('all', array('conditions' => array('subcategory LIKE ' => '%' . $_GET['search'] . '%', 'status' => 'Active')));
                    if (!empty($subcategory)) {
                        foreach ($subcategory as $subcategory) {
                            $search_cat[] = $subcategory['Subcategory']['subcategory_id'];
                        }
                        $conditions['Product.subcategory_id'] = $search_cat;
                    } else {
                        //added by prakash
//                        $result = preg_split('/(?<=\d)(?=[a-z])|(?<=[a-z])(?=\d)/i', $_GET['search']);
//                        $cat = $result[0];
//                        $productcode = $result[1];
//                        if(!empty($cat)){
//                            $cat = $this->Category->findByCategoryCode($cat);
//                            if(!empty($cat))
//                                $conditions['category_id'] = $cat['Category']['category_id'];
//                        }
                        //end
                        $conditions['product_code LIKE'] = '%' . $productcode . '%';
                        $conditions['product_name LIKE'] = '%' . $_GET['search'] . '%';
                    }
                }
            }

            if (!empty($_GET['jewellery'])) {
                if ($_GET['jewellery'] == 'diamond') {
                    $conditions[] = 'FIND_IN_SET(2,Product.product_type)';
                } elseif ($_GET['jewellery'] == 'plain_gold') {
                    $conditions[] = 'FIND_IN_SET(1,Product.product_type)';
                } elseif ($_GET['jewellery'] == 'gemstone') {
                    $conditions[] = 'FIND_IN_SET(3,Product.product_type)';
                }
            }

            if (!empty($_GET['collection'])) {
                $collection = $this->Collectiontype->find('first', array('conditions' => array('LOWER(collection_name)' => str_replace('_', ' ', $_GET['collection']))));
                if (!empty($collection)) {
                    $conditions[] = 'FIND_IN_SET(' . $collection['Collectiontype']['collectiontype_id'] . ',Product.collection_type)';
                }
                /* if($_GET['collection']=="enchanted"){
                  $conditions[]='FIND_IN_SET(1,Product.collection_type)';
                  }elseif($_GET['collection']=="sapphire"){
                  $conditions[]='FIND_IN_SET(2,Product.collection_type)';
                  }elseif($_GET['collection']=="emerald"){
                  $conditions[]='FIND_IN_SET(3,Product.collection_type)';
                  }elseif($_GET['collection']=="jewellery_below_20k"){
                  $conditions[]='FIND_IN_SET(4,Product.collection_type)';
                  }elseif($_GET['collection']=="ready_to_ship"){
                  $conditions[]='FIND_IN_SET(5,Product.collection_type)';
                  } */
            }

            if (!empty($_GET['metal'])) {
                $conditions['metal'] = $_GET['metal'];
            }
            if (!empty($_GET['goldpurity'])) {
                //$conditions['metal_purity']=$_GET['goldpurity'];
                $joins[] = array(
                    'table' => 'productmetal',
                    'alias' => 'Productmetal',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productmetal.product_id`=`Product.product_id`', 'Productmetal.value' => $_GET['goldpurity'], 'Productmetal.type' => 'Purity')
                );
            }
            if (!empty($_GET['diamond'])) {
                $conditions['stone'] = 'Yes';
            }
            if (!empty($_GET['gemstone'])) {
                $conditions['Product.gemstone'] = 'Yes';
                //$conditions[]='product_id IN (SELECT Productgemstone.product_id FROM sha_productgemstone AS Productgemstone WHERE Productgemstone.product_id=Product.product_id AND Productgemstone.gemstone=\''.$_GET['gemstone'].'\')';
                $joins[] = array(
                    'table' => 'productgemstone',
                    'alias' => 'Productgemstone',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productgemstone.product_id`=`Product.product_id`', 'Productgemstone.gemstone' => $_GET['gemstone'])
                );
            }
            if (!empty($_GET['shape'])) {
                if (!empty($_GET['gemstone'])) {
                    $gdetails = 'Productgemstone.gemstone=\'' . $_GET['gemstone'] . '\'';
                } else {
                    $gdetails = '';
                }
                $joins[] = array(
                    'table' => 'productgemstone',
                    'alias' => 'Productgemstone',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productgemstone.product_id`=`Product.product_id`', 'Productgemstone.shape' => $_GET['shape'], $gdetails)
                );
                $joins[] = array(
                    'table' => 'productdiamond',
                    'alias' => 'Productdiamond',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productdiamond.product_id`=`Product.product_id`', 'Productdiamond.shape' => $_GET['shape'])
                );
                //$conditions[]='product_id IN (SELECT Productgemstone.product_id FROM sha_productgemstone AS Productgemstone WHERE Productgemstone.product_id=Product.product_id AND Productgemstone.gemstone=\''.$_GET['gemstone'].'\')';
            }
            if (!empty($_GET['price'])) {
                if ($_GET['price'] == 1) {
                    $cod = '< 10000';
                    $this->set('n_filter', "Under Rs. 10,000 /-");
                } elseif ($_GET['price'] == 2) {
                    $cod = 'between 10000 AND 20000';
                } elseif ($_GET['price'] == 3) {
                    $cod = 'between 20000 AND 30000';
                } elseif ($_GET['price'] == 4) {
                    $cod = 'between 30000 AND 40000';
                } elseif ($_GET['price'] == 5) {
                    $cod = 'between 40000 AND 50000';
                } else {
                    $cod = '> 50000';
                }
                //$conditions[]='status =\'Active\' HAVING metalprice+stoneprice+gemstoneprice+ROUND(metalprice*mc/100)+ ROUND((metalprice+stoneprice+gemstoneprice+ROUND(metalprice* mc/100))* vat/100) '.$cod;
                //modified by prakash for metal fineness calculations
                $conditions[] = '(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
		 ROUND((ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) ' . $cod;
                //Issue query . Takes more time to retrieve. so commented.
//                $conditions[] = '(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\'  AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
//		 ROUND((ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) ' . $cod;
            }

            if (!empty($_GET['filter'])) {
                if ($_GET['filter'] == "popular") {
                    $shoppingcarts = $this->Shoppingcart->find('all', array('group' => 'product_id', 'order' => 'COUNT(product_id) DESC'));
                    $scart = array();
                    foreach ($shoppingcarts as $shoppingcart) {
                        $scart[] = $shoppingcart['Shoppingcart']['product_id'];
                    }
                    $ordercart = implode(',', $scart);
                    $conditions['Product.product_id'] = $scart;
                    $order = array("FIELD(Product.product_id,$ordercart)" => ' ');
                    //$order="FIELD(`product_id`,(SELECT Shoppingcart.product_id FROM sha_shoppingcarts AS Shoppingcart WHERE Shoppingcart.product_id=Product.product_id GROUP BY Shoppingcart.product_id ORDER BY COUNT(Shoppingcart.product_id) DESC))";
                    //$order="FIELD(`product_id`,(SELECT Shoppingcart.product_id FROM sha_shoppingcarts AS Shoppingcart WHERE Shoppingcart.product_id=Product.product_id GROUP BY Shoppingcart.product_id ORDER BY COUNT(Shoppingcart.product_id) DESC))";
                } elseif ($_GET['filter'] == "whats_new") {
                    $order = 'product_id DESC';
                } elseif ($_GET['filter'] == "price") {
                    $order = 'totprice ' . (isset($_GET['order']) ? $_GET['order'] : 'ASC');
                }
            }
        }

        if (empty($joins)) {
            $joins = '';
        }

        $product = $this->Product->find('all', array('conditions' => $conditions, 'fields' => $field, 'limit' => '6', 'group' => $group, 'joins' => $joins, 'order' => $order));


        //added by prakash
        if (isset($_GET['submenu'])) {
            $conditions[] = "FIND_IN_SET({$_GET['submenu']},Product.submenu_ids)";
            $submenu = $this->Submenu->findBySubmenuId($_GET['submenu']);
            $this->set('n_filter', $submenu['Menu']['menu_name'] . ' (' . $submenu['Submenu']['submenu_name'] . ')');
        }

        if (isset($_GET['goldfineness'])) {
            $conditions[] = "FIND_IN_SET({$_GET['goldfineness']},Product.metal_fineness)";
            $this->set('n_filter', "24K {$_GET['goldfineness']}");
        }

        if (isset($_GET['offers'])) {
            $conditions[] = "FIND_IN_SET({$_GET['offers']},Product.offer_ids)";
            $offer = $this->Offer->findByOfferId($_GET['offers']);
            $this->set('n_filter', $offer['Submenu']['submenu_name'] . ' (' . $offer['Offer']['offer_name'] . ')');
        }

        if (!empty($_GET['pricefilter'])) {
            if ($_GET['pricefilter'] == 2) {
                $cod = 'between 10001 AND 25000';
                $this->set('n_filter', "Rs. 10,001 /- to Rs. 25,000/-");
            } elseif ($_GET['pricefilter'] == 3) {
                $cod = 'between 25001 AND 50000';
                $this->set('n_filter', "Rs. 25,001 /- to Rs. 50,000/-");
            } elseif ($_GET['pricefilter'] == 4) {
                $cod = 'between 50001 AND 75000';
                $this->set('n_filter', "Rs. 50,001 /- to Rs. 75,000/-");
            } elseif ($_GET['pricefilter'] == 5) {
                $cod = '> 75001';
                $this->set('n_filter', "Rs. 75,001 /- and above");
            }
            $conditions[] = '(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
		 ROUND((ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) ' . $cod;
//                $conditions[] = '(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\'  AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
//		 ROUND((ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) ' . $cod;
        }

        $product = $this->Product->find('all', array('conditions' => $conditions, 'fields' => $field, 'limit' => '6', 'group' => $group, 'joins' => $joins, 'order' => $order));
        $productcount = $this->Product->find('all', array('conditions' => $conditions, 'fields' => $field, 'group' => $group, 'joins' => $joins, 'order' => $order));
        $type_cat = $this->Product->find('all', array('conditions' => $conditions, 'fields' => array_merge($field, array('COUNT(*) AS catcount')), 'group' => 'Product.category_id', 'joins' => $joins, 'order' => $order));
        $this->set('product', $product);
        $this->set('type_cat', $type_cat);
        $this->set('productcount', count($productcount));
    }

   /* public function enquries() {
        $this->layout = '';
        $this->render(false);
        if ($this->request->data) {
            /*  $lastCreated = $this->User->find('count', array(
              'conditions' => array('user_type' => '1')
              ));
              print_r($lastCreated); *
            $check_pin = $this->User->find('first', array('conditions' => array('user_type' => 1, 'pincode' => $this->request->data['Enquries']['pincode'], 'status !=' => 'Trash')));

            //$paymentcount = $this->Payment->find("count", array('conditions' => array('user_id' => $results['User']['user_id'])));
            if ($check_pin) {
                if (!empty($this->request->data['Enquries']['name'])) {
                    $check = $this->Enquries->create();
                    if (empty($check)) {
                        $this->request->data['Enquries']['created_date'] = date('Y-m-d H:i:s');
                        $this->Enquries->save($this->request->data);
                        $this->Session->setFlash("<div class='success msg'>" . __('Details saved successfully.') . "</div>");
                        $this->redirect(array('action' => 'index'));
                    }
                }
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __("Sorry, We don't have a Jewellery Outlet nearest to your Location.") . "</div>");
                $this->redirect(array('action' => 'index'));
            }
        }
    }*/
 public function enquries() {
        $this->layout = '';
        $this->render(false);
        if ($this->request->data) {
			/*  $lastCreated = $this->User->find('count', array(
        'conditions' => array('user_type' => '1')
    ));
	print_r($lastCreated); */
	$search=array('user_type' => '1', 'status !=' => 'Trash','AND' => array(
        array(
            'OR' => array(
                // topic
                 array('pincode LIKE' => '%,'.$this->request->data['Enquries']['pincode']),
                array('pincode LIKE' => '%'.$this->request->data['Enquries']['pincode'].',%'),
                array('pincode LIKE' => $this->request->data['Enquries']['pincode'])
            )
        )));
	 $check_pin = $this->User->find('first', array('conditions' => $search)); 
	 
	 //$paymentcount = $this->Payment->find("count", array('conditions' => array('user_id' => $results['User']['user_id'])));
	if($check_pin){
            if (!empty($this->request->data['Enquries']['name'])) {
                $check = $this->Enquries->create();
                if (empty($check)) {
                    $this->request->data['Enquries']['created_date'] = date('Y-m-d H:i:s');
                    $this->Enquries->save($this->request->data);
                    $this->Session->setFlash("<div class='success msg'>" . __('Details saved successfully.') . "</div>");
                    //$this->redirect(array('action' => 'index'));
					$this->redirect(
						array('controller' => 'Locateus', 'action' => 'locate_us','search'=>1,'zipcode' => $this->request->data['Enquries']['pincode'])
					);
                }
            }
        }else{
			$this->Session->setFlash("<div class='error msg'>" . __("Sorry, We don't have a Jewellery Outlet nearest to your Location.") . "</div>");
			$this->redirect(array('action' => 'index'));
		}
	}
    }
    public function admin_home_enquiries() {
        /* $this->layout="admin";
          $this->checkadmin();
          $this->Enquries->recursive = 0;
          $this->paginate = array('conditions' => array('status !='=>'Trash'),'order'=>'try_id DESC');
          $this->set('enquiry',$this->Paginator->paginate('Enquries')); */



        $this->layout = 'admin';
        $this->checkadmin();
        $this->Enquries->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['cdate'] != '') {
                $search[] = 'cdate=' . $this->request->data['cdate'];
            }

            if ($this->request->data['edate'] != '') {
                $search[] = 'edate=' . $this->request->data['edate'];
            }
            if ($this->request->data['searchterm'] != '') {
                $search[] = 'searchterm=' . $this->request->data['searchterm'];
            }
            if ($this->request->data['searchphone'] != '') {
                $search[] = 'searchphone=' . $this->request->data['searchphone'];
            }
            if ($this->request->data['searchpincode'] != '') {
                $search[] = 'searchpincode=' . $this->request->data['searchpincode'];
            }

            if (!empty($search)) {
                $this->redirect(array('action' => 'admin_home_enquiries?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'admin_home_enquiries'));
            }
        }
        if ($this->request->query('search') != '') {
            $search = array();
            $search = array('Enquries.status !=' => 'Trash');
            if (($this->request->query('cdate') != '') && ($this->request->query('edate'))) {
                $search = array_merge($search, array('Enquries.created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\''));
            } elseif ($this->request->query('edate') != '') {
                $search = array_merge($search, array('Enquries.created_date >=' => $this->request->query('edate')));
            } elseif ($this->request->query('cdate')) {
                $search = array_merge($search, array('Enquries.created_date <=' => $this->request->query('cdate')));
            }
            if ($this->request->query('searchterm')) {

                $search = array_merge($search, array('Enquries.city LIKE ' => '%' . $this->request->query('searchterm') . '%'));
                //print_r($search);exit;
            }
            if ($this->request->query('searchphone')) {

                $search = array_merge($search, array('Enquries.phone LIKE ' => '%' . $this->request->query('searchphone') . '%'));
                //print_r($search);exit;
            }
            if ($this->request->query('searchpincode')) {

                $search = array_merge($search, array('Enquries.pincode LIKE ' => '%' . $this->request->query('searchpincode') . '%'));
                //print_r($search);exit;
            }

            $search = array_merge($search);
            $this->paginate = array('conditions' => $search, 'order' => 'Enquries.try_id DESC');
            $this->set('enquiry', $this->paginate('Enquries'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'Enquries.try_id DESC');
            $this->set('enquiry', $this->Paginator->paginate('Enquries'));
        }
    }

    public function admin_homeenquries_export() {

        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $filename = "homeenquries_details.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $results = $this->Enquries->find('all', array('conditions' => array('status !=' => 'Trash')));
        $header_row = array("S.No", "Name", "Phone", "City", "Pincode", "Created Date");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {

            $row = array(
                $i,
                $results['Enquries']['name'],
                $results['Enquries']['phone'],
                $results['Enquries']['city'],
                $results['Enquries']['pincode'],
                $results['Enquries']['created_date'],
            );

            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }

    public function admin_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Enquries->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Enquries->exists()) {
                throw new NotFoundException(__('Invalid Enquries'));
            }

            $this->request->data['Enquries']['try_id'] = $this->params['pass']['0'];
            $this->request->data['Enquries']['status'] = 'Trash';
            $this->Enquries->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Enquries deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_home_enquiries'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $enquiry) {
                    if ($enquiry > 0) {
                        $this->request->data['Enquries']['try_id'] = $enquiry;
                        $this->request->data['Enquries']['status'] = 'Trash';
                        $this->Enquries->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Enquries has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_home_enquiries'));
        }
    }

    public function admin_question() {
        $this->layout = "admin";
        $this->checkadmin();
        $this->Question->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['searchproduct'] != '') {
                $search[] = 'searchproduct=' . $this->request->data['searchproduct'];
            }

            if ($this->request->data['searchcontat'] != '') {
                $search[] = 'searchcontat=' . $this->request->data['searchcontat'];
            }

            if (!empty($search)) {
                $this->redirect(array('action' => 'admin_question?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'admin_question'));
            }
        }

        if ($this->request->query('search') != '') {
            $search = array();
            if ($this->request->query('searchproduct') != '') {
                $product = $this->Product->find('first', array('conditions' => array('product_name' => $this->request->query['searchproduct'])));
                if (!empty($product)) {
                    $search['product_id'] = $product['Product']['product_id'];
                } else {
                    $search['product_id'] = '';
                }
            } elseif ($this->request->query('searchcontat') != '') {
                $search['contact_no'] = $this->request->query('searchcontat');
            }


            $this->paginate = array('conditions' => $search, 'order' => 'question_id DESC');
            $this->set('question', $this->Paginator->paginate('Question'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'question_id DESC');
            $this->set('question', $this->Paginator->paginate('Question'));
        }
        $product = $this->Product->find('all', array('order' => 'product_id DESC'));
        $this->set('product', $product);
    }

    public function admin_question_export() {

        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $filename = "question_details.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $results = $this->Question->find('all', array('conditions' => array('status !=' => 'Trash')));
        $header_row = array("S.No", "Name", "Product Name", "Email", "Phone", "Message", "Created Date");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {

            $productdetails = $this->Product->find('first', array('conditions' => array('product_id' => $results['Question']['product_id'])));
            $productname = $productdetails['Product']['product_name'];
            $row = array(
                $i,
                $results['Question']['name'],
                $productname,
                $results['Question']['email'],
                $results['Question']['contact_no'],
                $results['Question']['question'],
                $results['Question']['created_date'],
            );

            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }

    public function admin_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $question = $this->Question->find('first', array('conditions' => array('question_id' => $this->params['pass']['0'])));
        $this->set('question', $question);
        $product = $this->Product->find('first', array('conditions' => array('product_id' => $question['Question']['product_id'])));
        $this->set('product', $product);
    }

    public function admin_que_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Question->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Question->exists()) {
                throw new NotFoundException(__('Invalid Question'));
            }

            $this->request->data['Question']['question_id'] = $this->params['pass']['0'];
            $this->request->data['Question']['status'] = 'Trash';
            $this->Question->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Question deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_question'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $question) {
                    if ($question > 0) {
                        $this->request->data['Question']['question_id'] = $question;
                        $this->request->data['Question']['status'] = 'Trash';
                        $this->Question->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Question has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_question'));
        }
    }

    public function admin_rating_list() {
        $this->layout = "admin";
        $this->checkadmin();
        $this->Rating->recursive = 0;


        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['cdate'] != '') {
                $search[] = 'cdate=' . $this->request->data['cdate'];
            }

            if ($this->request->data['edate'] != '') {
                $search[] = 'edate=' . $this->request->data['edate'];
            }
            if ($this->request->data['searchterm'] != '') {
                $search[] = 'searchterm=' . $this->request->data['searchterm'];
            }

            if (!empty($search)) {
                $this->redirect(array('action' => 'admin_rating_list?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'admin_rating_list'));
            }
        }

        if ($this->request->query('search') != '') {
            $search = array();
            $search = array('Rating.status !=' => 'Trash');
            if (($this->request->query('cdate') != '') && ($this->request->query('edate') != '')) {
                $search = array_merge($search, array('Rating.created_date BETWEEN \'' . $this->request->query('cdate') . '\' AND \'' . $this->request->query('edate') . '\''));
            } elseif ($this->request->query('cdate') != '') {
                $search = array_merge($search, array('Rating.created_date >=' => $this->request->query('cdate')));
            } elseif ($this->request->query('edate') != '') {
                $search = array_merge($search, array('Rating.created_date <=' => $this->request->query('edate')));
            }
            if ($this->request->query('searchterm') != '') {

                $product = $this->Product->find('first', array('conditions' => array('product_id' => $this->request->query['searchterm'])));
                if (!empty($product)) {
                    $product_id = $product['Product']['product_id'];
                } else {
                    $product_id = '';
                }

                $search = array_merge($search, array('Rating.product_id' => $product_id));
            }

            $search = array_merge($search);
            $this->paginate = array('conditions' => $search, 'order' => 'Rating.rating_id DESC');
            $this->set('rating', $this->paginate('Rating'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'rating_id DESC');
            $this->set('rating', $this->Paginator->paginate('Rating'));
        }



        $product = $this->Product->find('all', array('order' => 'product_id DESC'));
        $this->set('product', $product);
    }

    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Rating']['rating_id'] = $id;
        $this->request->data['Rating']['status'] = $status;
        $this->Rating->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Rating Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'rating_list'));
    }

    public function admin_rating_view() {
        $this->layout = "admin";
        $this->checkadmin();
        $rating = $this->Rating->find('first', array('conditions' => array('rating_id' => $this->params['pass']['0'])));
        $this->set('rating', $rating);
        $product = $this->Product->find('first', array('conditions' => array('product_id' => $rating['Rating']['product_id'])));
        $this->set('product', $product);
    }

    public function admin_rating_delete() {
        $this->checkadmin();
        if (!empty($this->params['pass']['0'])) {
            $this->Rating->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Rating->exists()) {
                throw new NotFoundException(__('Invalid Rating'));
            }

            $this->request->data['Rating']['rating_id'] = $this->params['pass']['0'];
            $this->request->data['Rating']['status'] = 'Trash';
            $this->Rating->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Rating deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_rating_list'));
        } else {
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $rating_id) {
                    if ($rating_id > 0) {
                        $this->request->data['Rating']['rating_id'] = $rating_id;
                        $this->request->data['Rating']['status'] = 'Trash';
                        $this->Rating->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Rating has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_rating_list'));
        }
    }

    public function whislist() {

        $this->layout = '';
        $this->render(false);
        if ($this->Session->read('loginid')) {
            //$whish = $this->Whislist->find('first', array('conditions' => array('user_id' => $this->Session->read('loginid'), 'image_id' => $this->params['pass']['2'])));
            $whish = $this->Whislist->find("all", array('conditions' => array('Whislist.user_id' => $this->Session->read('User.user_id'), 'Whislist.status' => 'Active', 'Whislist.product_id' => $this->params['pass']['1'], 'Whislist.product_id NOT IN (SELECT Shoppingcart.product_id FROM sha_shoppingcarts AS Shoppingcart WHERE Shoppingcart.order_id IN (SELECT Orders.order_id FROM `sha_orders` AS `Orders` WHERE Orders.user_id=' . $this->Session->read('User.user_id') . ' AND (Orders.status=\'Paid\' OR Orders.status=\'Partialpaid\') AND Orders.created_date >= Whislist.created_date))'), 'joins' => array(array(
                        'table' => 'products',
                        'alias' => 'Product',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('`Product.product_id`=`Whislist.product_id`', 'Product.status' => 'Active')
                    )), 'group' => 'Whislist.whislist_id'));
            if (empty($whish)) {
                $this->request->data['Whislist']['user_id'] = $this->Session->read('loginid');
                $this->request->data['Whislist']['product_id'] = $this->params['pass']['1'];
                $this->request->data['Whislist']['image_id'] = $this->params['pass']['2'];
                $this->request->data['Whislist']['status'] = 'Active';
                $this->request->data['Whislist']['created_date'] = date('Y-m-d H:i:s');
                $this->Whislist->save($this->request->data);
                $this->Session->setFlash("<div class='success msg'>" . __('Whis list has been added successfully') . "</div>", '');
                $this->redirect(array('action' => 'product', $this->params['pass']['0']));
            } else {
                $this->Session->setFlash("<div class='error msg'>" . __('Whis list already exist') . "</div>", '');
                $this->redirect(array('action' => 'product', $this->params['pass']['0']));
            }
        } else {
            $this->Session->setFlash("<div class='error msg'>" . __('Please login') . "</div>", '');
            $this->redirect(array('action' => 'index', 'controller' => 'signin'));
        }
    }

    public function delivery_date() {


        //  if ($this->request->is('ajax')) {          
        $this->layout = '';
        $this->render(false);
        $id = $_REQUEST['id'];
        $product_id = $_REQUEST['product_id'];
        $products = $this->Product->find('first', array('conditions' => array('product_id' => $product_id, 'status' => 'Active')));

        $product_del = $products['Product']['product_delivery_tat'];
        $delivery = $products['Product']['vendor_delivery_tat'];
        $current_date = date("Y-m-d");
        $time = strtotime($current_date);
        $final = date("Y-m-d", strtotime("+" . $delivery . 'day', $time));
        $final_days = strtotime($final);
        $final_news = date("Y-m-d", strtotime("+" . $product_del . 'day', $final_days));

        $shipping = $this->Shippingrate->find('first', array('conditions' => array('pincode' => $id, 'status' => 'Active')));
        if (!empty($shipping)) {
            $shippingrate = $shipping['Shippingrate']['delivery_date'];
            $city = $shipping['Shippingrate']['city'];
            $new = strtotime($final_news);
            $tmstamp = date("Y-m-d", strtotime('+' . $shippingrate . 'day', $new));
            $days = strtotime($tmstamp);
            //$invalid='We are sorry, we do not deliver to this pincode ('.$id .'). Please try another pincode';


            $days_name = date('l', $days);
            $pincode = $city . ' - ' . date('d-m-Y', strtotime($tmstamp)) . ', ' . $days_name;

            $array = array('status' => '200', 'data' => 'Shipping available', 'date' => $pincode);
            echo json_encode($array);
        } else {
            $array = array('status' => '400', 'data' => 'We are sorry, we do not deliver to this pincode (' . $id . '). Please try another pincode');
            echo json_encode($array);
        }

        // }
    }

    public function calculate_price() {
        $this->layout = '';

        $customid = $_REQUEST['customid'];
        $size = $_REQUEST['size'];
        $productid = $_REQUEST['product_id'];
        $gcolor = $_REQUEST['gcolor'];
        $product = $this->Product->find('first', array('conditions' => array('product_id' => $productid)));
        $category = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
        if ($product['Product']['stone'] == 'Yes') {
            $diamond = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $productid)));
            $this->set('diamonddetails', $diamond);
        }
        if ($product['Product']['gemstone'] == 'Yes') {
            $gemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $productid)));
            $this->set('sgemstone', $gemstone);
        }

        //gold
        $propurity = $this->Productmetal->find('first', array('conditions' => array('product_id' => $productid, 'type' => 'Purity')));
        $material = explode("K", $customid);
        //pr($material);exit;
        if (!empty($size)) {
            $product_wt = $product['Product']['metal_weight'];
            if ($category['Category']['category'] != "Bangles") {
                $t = '1';
            } else {
                $t = '0.125';
            }

            $minsize = $this->Productmetal->find('first', array('fields' => array('MIN(value) as minsizes'), 'conditions' => array('product_id' => $productid, 'type' => 'Size')));
            $minsizenew = $minsize[0]['minsizes'];
            if ($size == $minsizenew) {
                $add_wt = 0;
            } else {
                $nsize = $this->Size->find('first', array('conditions' => array('size_value BETWEEN ' . ($minsizenew + $t) . ' AND ' . $size, 'goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active'), 'fields' => array('SUM(gold_diff) AS tot_wt')));

                $add_wt = $nsize[0]['tot_wt'];
            }
            $tot_weight = $product_wt + $add_wt;
        } else {
            $tot_weight = $product['Product']['metal_weight'];
        }

        if (!empty($gcolor)) {
            $mcolor = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $gcolor, 'status' => 'Active')));
            //modified by prakash
            $goldprice = $this->Price->find('first', array('conditions' => array('metalcolor_id' => $mcolor['Metalcolor']['metalcolor_id'], 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
            $gprice = !empty($goldprice['Price']['price']) ? $goldprice['Price']['price'] : 0;

            $gold_price = round(round($gprice * ($material[0] / 24)) * $tot_weight);
//            $gold_price = round(round($goldprice['Price']['price'] * ($material[0] / 24)) * $tot_weight);
            $purity = $material[0];
            $making_charge = $product['Product']['making_charge'];
        } else {
            $gold_price = '0';
            $making_charge = '0';
            $purity = '';
        }

        //diamond
        if (!empty($material[1])) {
            list($clarity, $color) = explode("-", $material[1]);
            $stone_price = '0';
            $diamond_wt = '0';
            $stone_details = $this->Productdiamond->find('first', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid), 'fields' => array('SUM(stone_weight) AS sweight', 'SUM(noofdiamonds) AS stone_nos')));
            $clarities = $this->Clarity->find('first', array('conditions' => array('clarity' => $clarity)));
            $colors = $this->Color->find('first', array('conditions' => array('color' => $color, 'clarity' => $clarity)));
            $stoneprice = $this->Price->find('first', array('conditions' => array('clarity_id' => $clarities['Clarity']['clarity_id'], 'color_id' => $colors['Color']['color_id'])));
            $stone_price = round($stoneprice['Price']['price'] * $stone_details['0']['sweight'], 0, PHP_ROUND_HALF_DOWN);
            $diamond_wt = $stone_details['0']['sweight'] / 5;
            $all_stone_details = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid)));

            $this->set('stone_details', $all_stone_details);
            $this->set('stoneweight', $stone_details['0']['sweight']);
            $this->set('noofstones', $stone_details['0']['stone_nos']);
            $this->set('stoneprice', $stoneprice);
        } else {
            $clarity = $color = '';
            $stone_price = '0';
            $diamond_wt = '0';
        }

        //gemstone
        if (!empty($gemstone)) {
            $gemprice = 0;
            $gemstone_wt = 0;
            foreach ($gemstone as $gemstones) {
                $stone = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstones['Productgemstone']['gemstone'])));
                $stone_shape = $this->Shape->find('first', array('conditions' => array('shape' => $gemstones['Productgemstone']['shape'])));
                $prices = $this->Price->find('first', array('conditions' => array('gemstone_id' => $stone['Gemstone']['gemstone_id'], 'gemstoneshape' => $stone_shape['Shape']['shape_id'])));
                $gemprice+=round($prices['Price']['price'] * $gemstones['Productgemstone']['stone_weight']);
                $gemstone_wt+=$gemstones['Productgemstone']['stone_weight'] / 5;
            }
        } else {
            $gemprice = '0';
            $gemstone_wt = '';
        }


        $sub_total = $gold_price + $stone_price + $gemprice;
        $making = 0;
        //addded by prakash
        if ($product['Product']['making_charge_calc'] == 'PER') {
            $making = round($gold_price * ($making_charge / 100), 0, PHP_ROUND_HALF_DOWN);
        } elseif ($product['Product']['making_charge_calc'] == 'INR') {
            $making = $making_charge;
        }
        $making = floatval($making);
        $vat = round(($sub_total + $making) * ($product['Product']['vat_cst'] / 100), 0, PHP_ROUND_HALF_DOWN);
        $total = $sub_total + $making + $vat;

        $total_weight = $tot_weight + $diamond_wt + $gemstone_wt;

        $jsonarray = array('size' => $size, 'purity' => $purity, 'clarity' => $clarity, 'color' => $color, 'gold_price' => indian_number_format($gold_price), 'gold_color' => $gcolor, 'stone_price' => indian_number_format($stone_price), 'making_charge' => indian_number_format($making), 'vat' => indian_number_format($vat), 'total' => indian_number_format($total), 'gemstone' => indian_number_format($gemprice), 'weight' => $total_weight, 'goldweight' => $tot_weight);

        $this->set('json', $jsonarray);
        $this->set('goldprice', $goldprice);

        $this->set('product', $product);
        $this->set('total_weight', $total_weight);
    }

    public function load_more() {
        $this->layout = '';
        //modified by prakash
        $field = array('ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight) AS metalprice',
            '(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness) AS price',
            'IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0) AS stoneprice', 'IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0) AS gemstoneprice,Product.making_charge AS mc,Product.vat_cst As vat',
            'ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
		 ROUND((ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100) AS totprice',
            'Product.*');
        //Issue query . Takes more time to retrieve. so commented.
//        $field = array('ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))* Product.metal_weight) AS metalprice',
//            '(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness) AS price',
//            'IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0) AS stoneprice',
//            'IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0) AS gemstoneprice,
//		Product.making_charge AS mc,
//		Product.vat_cst As vat',
//            'ROUND((ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id   ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',(ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\'))),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100) AS vatprice',
//            '(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
//		 ROUND((ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\'  AND Productmetal.product_id=Product.product_id   ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',(ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\'))),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) AS totprice',
//            'Product.*');

        $joins = $group = $order = '';
        $joins = array();
        if (!empty($this->params['pass']['0'])) {
            $cat = $this->Category->find('first', array('conditions' => array('LOWER(category)' => str_replace('_', ' ', $this->params['pass']['0']))));
            if (!empty($cat)) {
                $conditions['Product.category_id'] = $cat['Category']['category_id'];
                if (!empty($this->params['pass']['1'])) {
                    $sub_cat = $this->Subcategory->find('first', array('conditions' => array('LOWER(subcategory)' => str_replace('_', ' ', $this->params['pass']['1']), 'category_id' => $cat['Category']['category_id'])));
                    if (!empty($sub_cat)) {
                        $conditions['Product.subcategory_id'] = $sub_cat['Subcategory']['subcategory_id'];
                    }
                }
            }
        }
        $conditions['Product.status'] = 'Active';
        if (!empty($_GET)) {
            if (!empty($_GET['category'])) {
                $cat = $this->Category->find('first', array('conditions' => array('LOWER(category)' => str_replace('_', ' ', $_GET['category']))));
                if (!empty($cat)) {
                    $conditions['Product.category_id'] = $cat['Category']['category_id'];
                    if (!empty($_GET['subcategory'])) {
                        $sub_cat = $this->Subcategory->find('first', array('conditions' => array('LOWER(subcategory)' => str_replace('_', ' ', $_GET['subcategory']), 'category_id' => $cat['Category']['category_id'])));
                        if (!empty($sub_cat)) {
                            $conditions['Product.subcategory_id'] = $sub_cat['Subcategory']['subcategory_id'];
                        }
                    }
                }
            }

            if (!empty($_GET['search'])) {
                $category = $this->Category->find('all', array('conditions' => array('category LIKE ' => '%' . $_GET['search'] . '%', 'status' => 'Active')));
                $search_cat = array();
                if (!empty($category)) {
                    foreach ($category as $category) {
                        $search_cat[] = $category['Category']['category_id'];
                    }
                    $conditions['Product.category_id'] = $search_cat;
                } else {
                    $subcategory = $this->Subcategory->find('all', array('conditions' => array('subcategory LIKE ' => '%' . $_GET['search'] . '%', 'status' => 'Active')));
                    if (!empty($subcategory)) {
                        foreach ($subcategory as $subcategory) {
                            $search_cat[] = $subcategory['Subcategory']['subcategory_id'];
                        }
                        $conditions['Product.subcategory_id'] = $search_cat;
                    } else {
                        $conditions['product_name LIKE'] = '%' . $_GET['search'] . '%';
                    }
                }
            }

            if (!empty($_GET['jewellery'])) {
                if ($_GET['jewellery'] == 'diamond') {
                    $conditions[] = 'FIND_IN_SET(2,Product.product_type)';
                } elseif ($_GET['jewellery'] == 'plain_gold') {
                    $conditions[] = 'FIND_IN_SET(1,Product.product_type)';
                } elseif ($_GET['jewellery'] == 'gemstone') {
                    $conditions[] = 'FIND_IN_SET(3,Product.product_type)';
                }
            }

            if (!empty($_GET['collection'])) {
                $collection = $this->Collectiontype->find('first', array('conditions' => array('LOWER(collection_name)' => str_replace('_', ' ', $_GET['collection']))));
                if (!empty($collection)) {
                    $conditions[] = 'FIND_IN_SET(' . $collection['Collectiontype']['collectiontype_id'] . ',Product.collection_type)';
                }
                /* if($_GET['collection']=="enchanted"){
                  $conditions[]='FIND_IN_SET(1,Product.collection_type)';
                  }elseif($_GET['collection']=="sapphire"){
                  $conditions[]='FIND_IN_SET(2,Product.collection_type)';
                  }elseif($_GET['collection']=="emerald"){
                  $conditions[]='FIND_IN_SET(3,Product.collection_type)';
                  }elseif($_GET['collection']=="jewellery_below_20k"){
                  $conditions[]='FIND_IN_SET(4,Product.collection_type)';
                  }elseif($_GET['collection']=="ready_to_ship"){
                  $conditions[]='FIND_IN_SET(5,Product.collection_type)';
                  } */
            }

            if (!empty($_GET['metal'])) {
                $conditions['metal'] = $_GET['metal'];
            }
            if (!empty($_GET['goldpurity'])) {
                //$conditions['metal_purity']=$_GET['goldpurity'];
                $joins[] = array(
                    'table' => 'productmetal',
                    'alias' => 'Productmetal',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productmetal.product_id`=`Product.product_id`', 'Productmetal.value' => $_GET['goldpurity'], 'Productmetal.type' => 'Purity')
                );
            }
            if (!empty($_GET['diamond'])) {
                $conditions['stone'] = 'Yes';
            }
            if (!empty($_GET['gemstone'])) {
                $conditions['Product.gemstone'] = 'Yes';
                //$conditions[]='product_id IN (SELECT Productgemstone.product_id FROM sha_productgemstone AS Productgemstone WHERE Productgemstone.product_id=Product.product_id AND Productgemstone.gemstone=\''.$_GET['gemstone'].'\')';
                $joins[] = array(
                    'table' => 'productgemstone',
                    'alias' => 'Productgemstone',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productgemstone.product_id`=`Product.product_id`', 'Productgemstone.gemstone' => $_GET['gemstone'])
                );
            }
            if (!empty($_GET['shape'])) {
                if (!empty($_GET['gemstone'])) {
                    $gdetails = 'Productgemstone.gemstone=\'' . $_GET['gemstone'] . '\'';
                } else {
                    $gdetails = '';
                }
                $joins[] = array(
                    'table' => 'productgemstone',
                    'alias' => 'Productgemstone',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productgemstone.product_id`=`Product.product_id`', 'Productgemstone.shape' => $_GET['shape'], $gdetails)
                );
                $joins[] = array(
                    'table' => 'productdiamond',
                    'alias' => 'Productdiamond',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('`Productdiamond.product_id`=`Product.product_id`', 'Productdiamond.shape' => $_GET['shape'])
                );
                //$conditions[]='product_id IN (SELECT Productgemstone.product_id FROM sha_productgemstone AS Productgemstone WHERE Productgemstone.product_id=Product.product_id AND Productgemstone.gemstone=\''.$_GET['gemstone'].'\')';
            }
            if (!empty($_GET['price'])) {
                if ($_GET['price'] == 1) {
                    $cod = '< 10000';
                } elseif ($_GET['price'] == 2) {
                    $cod = 'between 10000 AND 20000';
                } elseif ($_GET['price'] == 3) {
                    $cod = 'between 20000 AND 30000';
                } elseif ($_GET['price'] == 4) {
                    $cod = 'between 30000 AND 40000';
                } elseif ($_GET['price'] == 5) {
                    $cod = 'between 40000 AND 50000';
                } else {
                    $cod = '> 50000';
                }
                //$conditions[]='status =\'Active\' HAVING metalprice+stoneprice+gemstoneprice+ROUND(metalprice*mc/100)+ ROUND((metalprice+stoneprice+gemstoneprice+ROUND(metalprice* mc/100))* vat/100) '.$cod;
                $conditions[] = '(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
		 ROUND((ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) ' . $cod;
                //Issue query . Takes more time to retrieve. so commented.
//                $conditions[] = '(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\'  AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
//		 ROUND((ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal  WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)+
//		 ROUND(ROUND(ROUND((' . (isset($_REQUEST['goldpurity']) ? $_REQUEST['goldpurity'] : '(SELECT value FROM sha_productmetal AS Productmetal WHERE type=\'Purity\' AND Productmetal.product_id=Product.product_id  ORDER BY value ASC LIMIT 0,1)') . '/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id))*Product.metal_weight)*making_charge/100)+
//		 IF(stone=\'Yes\',ROUND((SELECT SUM(Productdiamond.stone_weight) FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)*(SELECT price FROM sha_price WHERE clarity_id=(SELECT clarity_id FROM sha_clarity WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND color_id=(SELECT color_id FROM sha_color WHERE clarity=(SELECT clarity FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1) AND color=(SELECT color FROM sha_productdiamond AS Productdiamond WHERE Productdiamond.product_id=Product.product_id GROUP BY clarity, color ORDER BY FIELD(`clarity`,\'SI\',\'VS\',\'VVS\'),FIELD(`color`,\'IJ\',\'GH\',\'EF\') LIMIT 0,1)) AND status=\'Active\')),0)+
//		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*(SELECT Price.price FROM sha_price AS Price WHERE Price.gemstone_id=(SELECT Gemstone.gemstone_id FROM sha_gemstone AS Gemstone WHERE Gemstone.stone=Productgemstone.gemstone) AND Price.gemstoneshape=(SELECT Shape.shape_id FROM sha_shape AS Shape WHERE Shape.shape = Productgemstone.shape ))) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) ' . $cod;
            }

            if (!empty($_GET['filter'])) {
                if ($_GET['filter'] == "popular") {
                    $shoppingcarts = $this->Shoppingcart->find('all', array('group' => 'product_id', 'order' => 'COUNT(product_id) DESC'));
                    $scart = array();
                    foreach ($shoppingcarts as $shoppingcart) {
                        $scart[] = $shoppingcart['Shoppingcart']['product_id'];
                    }
                    $ordercart = implode(',', $scart);
                    $conditions['Product.product_id'] = $scart;
                    $order = array("FIELD(Product.product_id,$ordercart)" => ' ');
                    //$order="FIELD(`product_id`,(SELECT Shoppingcart.product_id FROM sha_shoppingcarts AS Shoppingcart WHERE Shoppingcart.product_id=Product.product_id GROUP BY Shoppingcart.product_id ORDER BY COUNT(Shoppingcart.product_id) DESC))";
                    //$order="FIELD(`product_id`,(SELECT Shoppingcart.product_id FROM sha_shoppingcarts AS Shoppingcart WHERE Shoppingcart.product_id=Product.product_id GROUP BY Shoppingcart.product_id ORDER BY COUNT(Shoppingcart.product_id) DESC))";
                } elseif ($_GET['filter'] == "whats_new") {
                    $order = 'product_id DESC';
                } elseif ($_GET['filter'] == "price") {
                    $order = 'totprice ' . (isset($_GET['order']) ? $_GET['order'] : 'ASC');
                }
            }
        }

        if (empty($joins)) {
            $joins = '';
        }

        //added by prakash
        if (isset($_GET['submenu'])) {
            $conditions[] = "FIND_IN_SET({$_GET['submenu']},Product.submenu_ids)";
        }

        if (isset($_GET['goldfineness'])) {
            $conditions[] = "FIND_IN_SET({$_GET['goldfineness']},Product.metal_fineness)";
        }

        if (isset($_GET['offers'])) {
            $conditions[] = "FIND_IN_SET({$_GET['offers']},Product.offer_ids)";
        }

        if (!empty($_GET['pricefilter'])) {
            if ($_GET['pricefilter'] == 2) {
                $cod = 'between 10001 AND 25000';
            } elseif ($_GET['pricefilter'] == 3) {
                $cod = 'between 25001 AND 50000';
            } elseif ($_GET['pricefilter'] == 4) {
                $cod = 'between 50001 AND 75000';
            } elseif ($_GET['pricefilter'] == 5) {
                $cod = '> 75001';
            }
            //$conditions[]='status =\'Active\' HAVING metalprice+stoneprice+gemstoneprice+ROUND(metalprice*mc/100)+ ROUND((metalprice+stoneprice+gemstoneprice+ROUND(metalprice* mc/100))* vat/100) '.$cod;
            $conditions[] = '(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0)+
		 ROUND((ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)+
		 ROUND(ROUND(ROUND((metal_purity/24)*(SELECT price FROM sha_price WHERE metal_id=1 AND metalcolor_id=Product.metal_color_id AND metal_fineness=Product.metal_fineness))*metal_weight)*making_charge/100)+
		 IF(stone=\'Yes\',ROUND(stoneweight*(SELECT price FROM sha_price WHERE clarity_id=Product.stone_clarity_id AND color_id=Product.stone_color_id AND status=\'Active\' AND metal_fineness=Product.metal_fineness)),0)+
		 IF(Product.gemstone=\'Yes\',ROUND((SELECT SUM(Productgemstone.stone_weight*Productgemstone.stone_price) FROM sha_productgemstone AS Productgemstone WHERE product_id=Product.product_id)),0))*vat_cst/100)) ' . $cod;
        }
        if (!empty($_GET['page'])) {
            $offset = ($_GET['page'] - 1) * 6;
        } else {
            $offset = 0;
        }

        $product = $this->Product->find('all', array('conditions' => $conditions, 'fields' => $field, 'limit' => '6', 'offset' => $offset, 'group' => $group, 'joins' => $joins, 'order' => $order));
        $productcount = $this->Product->find('all', array('conditions' => $conditions, 'fields' => $field, 'group' => $group, 'joins' => $joins, 'order' => $order));
        $this->set('product', $product);
    }

    public function search() {
        if (!empty($_REQUEST['search'])) {
            $product = $this->Product->find('all', array('conditions' => array('product_name LIKE' => '%' . $_REQUEST['search'] . '%', 'status' => 'Active'), 'limit' => '6'));
            $this->set('product', $product);
        }



        $metals = $this->Metal->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
        $this->set('metal', $metals);

        $diamond = $this->Diamond->find('first', array('conditions' => array('status' => 'Active'), 'order' => 'diamond_id ASC'));
        $this->set('diamond', $diamond);
        $stone = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
        $this->set('stone', $stone);
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'purity_id ASC'));
        $this->set('purity', $purity);
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
    }

    public function explorenow() {

        if (isset($this->request->data['searchitems'])) {
            //pr($this->request->data);exit;
            $category_explode = $this->request->data['category'];
            $jeweltype_explode = $this->request->data['jeweltype'];
            $price_explode = $this->request->data['price'];
            $stone_explode = $this->request->data['stone'];
            $this->redirect(array('action' => 'explorenow', 'controller' => 'webpages', '?' =>
                array('category' => $category_explode, 'price' => $price_explode, 'jeweltype' => $jeweltype_explode, 'stone' => $stone_explode, 'check' => 'check')));
        }

        if ($this->request->query['check'] == 'check') {
            $searchtype = array();

            if ($this->request->query['category'] != "") {
                $searchtype = array('category_id' => $this->request->query['category'], 'status' => 'Active');
            }


            $product_search = $this->Product->find('all', array('conditions' => $searchtype, 'order' => 'product_id DESC'));
            $this->set('product', $product_search);
        }


        $metals = $this->Metal->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'metal_id ASC'));
        $this->set('metal', $metals);

        $diamond = $this->Diamond->find('first', array('conditions' => array('status' => 'Active'), 'order' => 'diamond_id ASC'));
        $this->set('diamond', $diamond);
        $stone = $this->Gemstone->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'gemstone_id ASC'));
        $this->set('stone', $stone);
        $purity = $this->Purity->find('all', array('conditions' => array('status' => 'Active'), 'order' => 'purity_id ASC'));
        $this->set('purity', $purity);
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
    }

    public function load_more_search() {
        $this->layout = '';
        $type = $_REQUEST['type'];
        $name = $_REQUEST['name'];
        $value = $_REQUEST['value'];
        $page = $_REQUEST['page'];
        $countpro = $_REQUEST['count'];
        $checker = $_REQUEST['checker'];
        $conditions = array();
        if ($type == '') {
            $conditions = array('product_name LIKE' => '%' . $name . '%', 'status' => 'Active');
        } else {

            if ($type == 'gemstone' || $type == 'shape') {
                $productstone = $this->Productgemstone->find('all', array('conditions' => array($type => $value), 'group' => 'product_id'));
                if (!empty($productstone)) {

                    foreach ($productstone as $productstone) {
                        $id[] = $productstone['Productgemstone']['product_id'];
                    }

                    $conditions = array_merge($conditions, array('product_id IN (' . implode(",", $id) . ')', 'product_name LIKE' => '%' . $name . '%', 'status' => 'Active'));
                }
            }

            if ($type == 'dia') {
                $productdiamond = $this->Productdiamond->find('all', array('conditions' => array('diamond' => $value)));
                if (!empty($productdiamond)) {

                    foreach ($productdiamond as $productdiamond) {
                        $id[] = $productdiamond['Productdiamond']['product_id'];
                    }

                    $conditions = array_merge($conditions, array('product_id IN (' . implode(",", $id) . ')', 'product_name LIKE' => '%' . $name . '%', 'status' => 'Active'));
                }
            }
            if ($type == 'goldpurity') {

                $productpurity = $this->Productmetal->find('all', array('conditions' => array('value' => $value, 'type' => 'Purity'), 'group' => 'product_id'));
                $conditionschk = array();
                foreach ($productpurity as $purity) {
                    $conditionschk[] = $purity['Productmetal']['product_id'];
                }

                $ids = implode(',', $conditionschk);
                $conditions = array_merge($conditions, array('product_id IN(' . $ids . ')', 'product_name LIKE' => '%' . $name . '%', 'status' => 'Active'));
            }

            if ($type == 'metal') {
                $conditions = array_merge($conditions, array('metal' => $val, 'product_name LIKE' => '%' . $name . '%', 'status' => 'Active'));
            }
        }


        $this->paginate = array('conditions' => $conditions, 'order' => 'product_id DESC', 'limit' => 6, 'page' => $page);
        $this->set('product', $this->Paginator->paginate('Product'));
        $count = count($this->Paginator->paginate('Product'));
        $pagecount = $count + $countpro;
        $jsonarray = array('pagecount' => $pagecount, 'checker' => $checker);
        $this->set('json', $jsonarray);
    }

    public function update_database_product() {
        $prodcuts = $this->Product->find('all');
        foreach ($prodcuts as $prodcut) {
            $metal_color_explode = explode(",", $prodcut['Product']['metal_color']);

            $metal_color_id = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $metal_color_explode[0]), 'fields' => array('metalcolor_id')));
            $purity = $this->Productmetal->find('first', array('conditions' => array('product_id' => $prodcut['Product']['product_id'], 'type' => "Purity"), 'order' => 'value ASC'));
            $diamonddiv = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' => $prodcut['Product']['product_id']), 'group' => array('clarity', 'color'), 'order' => "FIELD(`clarity`,'SI','VS','VVS'),FIELD(`color`,'IJ','GH','EF')"));
            $stoneweight = ClassRegistry::init('Productdiamond')->find('first', array('conditions' => array('product_id' => $prodcut['Product']['product_id'], 'color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => 'SUM(stone_weight) AS sweight'));
            $color_id = $this->Color->find('first', array('conditions' => array('color' => $diamonddiv['Productdiamond']['color'], 'clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('color_id')));
            $clarity_id = $this->Clarity->find('first', array('conditions' => array('clarity' => $diamonddiv['Productdiamond']['clarity']), 'fields' => array('clarity_id')));
            //echo $prodcut['Product']['product_id']."<br/>";
            //echo $stoneweight[0]['sweight']."<br/>";
            //echo $metal_color_id['Metalcolor']['metalcolor_id'][0]."<br/>";
            //echo $clarity_id['Clarity']['clarity_id'][0]."<br/>";
            //echo $color_id['Color']['color_id'][0]."<br/>";
            //echo $purity['Productmetal']['value'][0]."<br/>";
            $this->request->data['Product']['product_id'] = $prodcut['Product']['product_id'];
            $this->request->data['Product']['stoneweight'] = $stoneweight[0]['sweight'];
            $this->request->data['Product']['metal_color_id'] = $metal_color_id['Metalcolor']['metalcolor_id'][0];
            $this->request->data['Product']['stone_clarity_id'] = $clarity_id['Clarity']['clarity_id'][0];
            $this->request->data['Product']['stone_color_id'] = $color_id['Color']['color_id'][0];
            $this->request->data['Product']['metal_purity'] = $purity['Productmetal']['value'][0];
            $this->Product->save($this->request->data);


            /* if(!empty($gemstones))
              {
              foreach($gemstones as $gemstone){
              $gemstone_1=$gemstone['Productgemstone']['gemstone'];
              $shape_1= $gemstone['Productgemstone']['shape'];

              $shape_id = $this->Shape->find('first',array('conditions'=>array('shape'=>$shape_1), 'fields' => array('shape_id')));
              $gemstone_id = $this->Gemstone->find('first',array('conditions'=>array('stone'=>$gemstone_1), 'fields' => array('gemstone_id')));

              $price_value_id = $this->Price->find('first',array('conditions'=>array('gemstoneshape'=>$shape_id['Shape']['shape_id'],'gemstone_id'=>$gemstone_id['Gemstone']['gemstone_id']), 'fields' => array('price')));


              $product_stone['stone_price']=$price_value_id['Price']['price'];
              $product_stone['productgemstone_id']=$gemstone['Productgemstone']['productgemstone_id'];


              $this->Productgemstone->saveAll($product_stone); */
        }
        $gemstones = $this->Productgemstone->find('all');
        foreach ($gemstones as $gemstone) {

            $gemstone1 = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstone['Productgemstone']['gemstone'])));

            $gemstoneshape = $this->Shape->find('first', array('conditions' => array('shape' => $gemstone['Productgemstone']['shape'])));

            $price = $this->Price->find('first', array('conditions' => array('gemstone_id' => $gemstone1['Gemstone']['gemstone_id'], 'gemstoneshape' => $gemstoneshape['Shape']['shape_id'])));

            $this->Productgemstone->updateAll(array('stone_price' => $price['Price']['price']), array('gemstone' => $gemstone1['Gemstone']['stone'], 'shape' => $gemstoneshape['Shape']['shape']));
        }
    }

    public function jewellery_requestform() {
        $categories = $this->Category->find('all', array('conditions' => array('status' => 'Active')));
        $this->set('categories', $categories);
        $this->layout = "webpage";

        if ($this->request->is('post')) {
            $image = '';
            if ($_FILES["image"]["name"] != '') {
                $image = $destination = 'img/request/' . $_FILES["image"]["name"];
                move_uploaded_file($_FILES["image"]['tmp_name'], $destination);
                $this->request->data['Jewellrequest']['image'] = $_FILES["image"]["name"];
            }

            $email_template = '
<h3>Order Details</h3>
<br/><table border="1" cellspacing="2" cellpadding="2">
<thead>
<th>Name</th>
<th>Address</th>
<th>Mobile</th>
<th>Email</th>
<th>Category</th>
</thead>
<tbody>
<tr>
<td>' . $this->request->data['name'] . '</td>
<td>' . $this->request->data['address'] . '</td>
<td>' . $this->request->data['mobile'] . '</td>
<td>' . $this->request->data['email'] . '</td>
<td>' . $this->request->data['category'] . '</td>
</tr>
</tbody>
</table>
<br/>
<h3>Product Details</h3>
<br/>
<table border="1" cellspacing="2" cellpadding="2">
<thead>
<th>Size</th>
<th>Height</th>
<th>Width</th>
<th>Length</th>
<th>Total Weight</th>
<th>Image</th>
</thead>
<tbody>
<tr>
<td>' . $this->request->data['size'] . '</td>
<td>' . $this->request->data['height'] . '</td>
<td>' . $this->request->data['width'] . '</td>
<td>' . $this->request->data['length'] . '</td>
<td>' . $this->request->data['tweight'] . '</td>
 <td><img src="' . BASE_URL . $image . '" alt="Not uploaded"></td>
</tr>
</tbody>
</table>
<br/>
<h3>Metals Details</h3>
<br/>
<table border="1" cellspacing="2" cellpadding="2">
<thead>
<th>Metals Weight</th>
<th>Purity</th>
<th>Width</th>
<th>Color</th>
<th>Metals</th>
</thead>
<tbody>
<tr>
<td>' . $this->request->data['mweight'] . '</td>
<td>' . $this->request->data['mpurity'] . '</td>
<td>' . $this->request->data['width'] . '</td>
<td>' . $this->request->data['mcolor'] . '</td>
<td>' . $this->request->data['mmetal'] . '</td>
    </tr>
</tbody>
</table>
';

            $this->request->data['Jewellrequest']['name'] = $this->request->data['name'];
            $this->request->data['Jewellrequest']['address'] = $this->request->data['address'];
            $this->request->data['Jewellrequest']['mobile'] = $this->request->data['mobile'];
            $this->request->data['Jewellrequest']['email'] = $this->request->data['email'];
            $this->request->data['Jewellrequest']['product_cat'] = $this->request->data['category'];
            $this->request->data['Jewellrequest']['size'] = $this->request->data['size'];
            $this->request->data['Jewellrequest']['height'] = $this->request->data['height'];
            $this->request->data['Jewellrequest']['weight'] = $this->request->data['width'];
            $this->request->data['Jewellrequest']['length'] = $this->request->data['length'];
            $this->request->data['Jewellrequest']['total_weight'] = $this->request->data['tweight'];
            $this->request->data['Jewellrequest']['metal_weight'] = $this->request->data['mweight'];
            $this->request->data['Jewellrequest']['purity'] = $this->request->data['mpurity'];
            $this->request->data['Jewellrequest']['width'] = $this->request->data['width'];
            $this->request->data['Jewellrequest']['color'] = $this->request->data['mcolor'];
            $this->request->data['Jewellrequest']['metals'] = $this->request->data['mmetal'];
            $this->Jewellrequest->save($this->request->data);
            $id = $this->Jewellrequest->getLastInsertId();
            $email_template.='
<br/><h3>Diamond Details</h3>
<br/><table border="1" cellspacing="2" cellpadding="2">
<thead>
<th>SI-IJ</th>
<th>SI-GH</th>
<th>VS-GH</th>
<th>VVS-EF</th>
<th>Setting</th>
<th>Shape</th>
<th>No.of Stone </th>
<th>Weight/Carat </th>
</thead> <tbody>  ';

            for ($i = 0; $i < count($this->request->data['dsiij']); $i++) {

                $this->request->data['Jewelldiamond']['si_ij'] = $this->request->data['dsiij'][$i];
                $this->request->data['Jewelldiamond']['si_gh'] = $this->request->data['dsigh'][$i];
                $this->request->data['Jewelldiamond']['vs_gh'] = $this->request->data['dvsgh'][$i];
                $this->request->data['Jewelldiamond']['vvs_ef'] = $this->request->data['dvvsef'][$i];
                $this->request->data['Jewelldiamond']['setting'] = $this->request->data['dsettings'][$i];
                $this->request->data['Jewelldiamond']['shape'] = $this->request->data['dshape'][$i];
                $this->request->data['Jewelldiamond']['no_of_stone'] = $this->request->data['dstonecount'][$i];
                $this->request->data['Jewelldiamond']['weight'] = $this->request->data['dweight'][$i];
                $this->request->data['Jewelldiamond']['request_id'] = $id;
                $this->Jewelldiamond->saveAll($this->request->data);

                $email_template.='<tr>
                                                                    <td>' . $this->request->data['dsiij'][$i] . '</td>
                                                                    <td>' . $this->request->data['dsigh'][$i] . '</td>
                                                                    <td>' . $this->request->data['dvsgh'][$i] . '</td>
                                                                    <td>' . $this->request->data['dvvsef'][$i] . '</td>
                                                                    <td>' . $this->request->data['dsettings'][$i] . '</td>
                                                                    <td>' . $this->request->data['dshape'][$i] . '</td>
                                                                    <td>' . $this->request->data['dstonecount'][$i] . '</td>
                                                                    <td>' . $this->request->data['dweight'][$i] . '</td>
                                                                  </tr>';
            }

            $email_template.='</tbody></table>
<br/><h3>Stone Details</h3>
<br/><table border="1" cellspacing="2" cellpadding="2">
<thead>
<th>Stone Name</th>
<th>Shape</th>
<th>Weight/Carat</th>
<th>Setting</th>
<th>No.of Stone</th>
</thead> <tbody>  ';
            for ($i = 0; $i < count($this->request->data['sname']); $i++) {

                $this->request->data['Jewellstone']['name'] = $this->request->data['sname'][$i];
                $this->request->data['Jewellstone']['shape'] = $this->request->data['sshape'][$i];
                $this->request->data['Jewellstone']['weight'] = $this->request->data['sweight'][$i];
                $this->request->data['Jewellstone']['setting'] = $this->request->data['ssetting'][$i];
                $this->request->data['Jewellstone']['no_of_stone'] = $this->request->data['sstonecount'][$i];
                $this->request->data['Jewellstone']['req_id'] = $id;
                $this->Jewellstone->saveAll($this->request->data);

                $email_template.='<tr>
                                                                    <td>' . $this->request->data['sname'][$i] . '</td>
                                                                    <td>' . $this->request->data['sshape'][$i] . '</td>
                                                                    <td>' . $this->request->data['sweight'][$i] . '</td>
                                                                    <td>' . $this->request->data['ssetting'][$i] . '</td>
                                                                    <td>' . $this->request->data['sstonecount'][$i] . '</td>                                                                   
                                                                  </tr>';
            }

            $email_template.='</tbody></table>';

            $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 15)));
            $message = str_replace(array('{name}', '{details}'), array($this->request->data['name'], $email_template), $activateemail['Emailcontent']['content']);
            $this->mailsend(SITE_NAME, $activateemail['Emailcontent']['fromemail'], $this->request->data['email'], $activateemail['Emailcontent']['subject'], $message);

            $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => 16)));
            $message = str_replace(array('{name}', '{details}'), array($this->request->data['name'], $email_template), $activateemail['Emailcontent']['content']);
            $this->mailsend(SITE_NAME, $this->request->data['email'], $activateemail['Emailcontent']['fromemail'], $activateemail['Emailcontent']['subject'], $message);



            $this->Session->setFlash("<div class='success msg'>" . __('Request added successfully') . "</div>");
            $this->redirect(array('action' => 'jewellery_requestform', 'controller' => 'webpages'));
        }
    }

    public function admin_customizedrequest() {
        $this->checkadmin();
        $this->layout = "admin";
        $this->Jewellrequest->recursive = 0;
        $this->paginate = array('conditions' => '');
        $this->set('Jewellrequest', $this->Paginator->paginate('Jewellrequest'));
    }

    public function admin_deletecrequest() {

        $this->checkadmin();
        $this->layout = "admin";
        $cart = $this->Jewellrequest->find('first', array('conditions' => array('req_id' => $_GET['id'])));
        $this->Jewellrequest->delete(array('req_id' => $_GET['id']));
        $this->Jewellstone->delete(array('req_id' => $_GET['id']));
        $this->Jewelldiamond->delete(array('request_id' => $_GET['id']));
        $this->Session->setFlash("<div class='success msg'>" . __('Request deleted successfully') . "</div>");
        $this->redirect(array('action' => 'customizedrequest', 'controller' => 'webpages'));
    }

    public function admin_viewrequest() {
        $this->checkadmin();
        $this->layout = "admin";
        $requests = $this->Jewellrequest->find('first', array('conditions' => array('req_id' => $_GET['id'])));
        $this->set('requests', $requests);
        $stones = $this->Jewellstone->find('all', array('conditions' => array('req_id' => $_GET['id'])));
        $this->set('stones', $stones);
        $dimonds = $this->Jewelldiamond->find('all', array('conditions' => array('request_id' => $_GET['id'])));
        $this->set('dimonds', $dimonds);
    }

    public function productsize() {

        $this->layout = '';
        $this->render(false);
        $id = $_REQUEST['id'];
        $category = $this->Category->find('first', array('conditions' => array('category' => $id)));
        $size = $this->Size->find('all', array('conditions' => array('category_id' => $category['Category']['category_id']), 'group' => 'size', 'order' => 'size_id ASC'));
        if (!empty($size)) {
            foreach ($size as $size) {
                if ($category['Category']['category'] != 'Bangles') {
                    $val = $size['Size']['size'];
                } else {
                    $val = $size['Size']['size'];
                }
                echo '<option value=' . $val . '>' . $val . '</option>';
            }
        } else {
            echo '<option value="">No size available</option>';
        }

        exit;
    }

    public function admin_product_custom_request() {

        $this->layout = '';
        $this->render(false);
        $this->checkadmin();
        ini_set('max_execution_time', 600);
        $filename = "customized_jwellery_form.csv";
        $csv_file = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $header_row = array("S.No", "Name", "Address", "Mobile", "Email", "Product Category", "Size", "Height", "Weight", "Length", "Total Weight", "Metal Weight", "Purity", "Color", "Metal", "Width", "SI IJ", "SI GH", "VS GH", "VVS EF", "Diamond Settings", "Shape", "Diamond No of stone", "Weight", "Name", "shape", "Weight", "Settings", "No of stone");
        fputcsv($csv_file, $header_row, ',', '"');
        $jwellrequest = $this->Jewellrequest->find('all');
        $i = 1;
        foreach ($jwellrequest as $jwellreques) {

            $row = array(
                $i,
                $jwellreques['Jewellrequest']['name'],
                $jwellreques['Jewellrequest']['address'],
                $jwellreques['Jewellrequest']['mobile'],
                $jwellreques['Jewellrequest']['email'],
                $jwellreques['Jewellrequest']['product_cat'],
                $jwellreques['Jewellrequest']['size'],
                $jwellreques['Jewellrequest']['height'],
                $jwellreques['Jewellrequest']['weight'],
                $jwellreques['Jewellrequest']['length'],
                $jwellreques['Jewellrequest']['total_weight'],
                $jwellreques['Jewellrequest']['metal_weight'],
                $jwellreques['Jewellrequest']['purity'],
                $jwellreques['Jewellrequest']['color'],
                $jwellreques['Jewellrequest']['metals'],
                $jwellreques['Jewellrequest']['width']
            );

            $Diamond = $this->Jewelldiamond->find('first', array("conditions" => array('request_id' => $jwellreques['Jewellrequest']['req_id'])));

            if (!empty($Diamond)) {

                $diamond_vari = array($Diamond['Jewelldiamond']['si_ij'],
                    $Diamond['Jewelldiamond']['si_gh'],
                    $Diamond['Jewelldiamond']['vs_gh'],
                    $Diamond['Jewelldiamond']['vvs_ef'],
                    $Diamond['Jewelldiamond']['setting'],
                    $Diamond['Jewelldiamond']['shape'],
                    $Diamond['Jewelldiamond']['no_of_stone'],
                    $Diamond['Jewelldiamond']['weight'],
                );
            } else {
                $diamond_vari = array("", "", "", "", "", "", "", "");
            }
// print_r($diamond_vari);


            $stone = $this->Jewellstone->find('first', array("conditions" => array('req_id' => $jwellreques['Jewellrequest']['req_id'])));
            if (!empty($stone)) {
                $Stone_vari = array($stone['Jewellstone']['name'],
                    $stone['Jewellstone']['shape'],
                    $stone['Jewellstone']['weight'],
                    $stone['Jewellstone']['setting'],
                    $stone['Jewellstone']['no_of_stone'],
                );
            } else {
                $Stone_vari = array("", "", "", "", "");
            }
            $row = array_merge($row, $diamond_vari);
            $row = array_merge($row, $Stone_vari);
            fputcsv($csv_file, $row, ',', '"');
            $i++;
        }


        fclose($csv_file);
    }

    function admin_delete_custom_request() {
        if (!empty($this->request->data['action'])) {
            $array = array_filter($this->request->data['action']);
            $this->Jewellrequest->deleteAll(array('req_id' => $array));
            $this->Jewellstone->deleteAll(array('req_id' => $array));
            $this->Jewelldiamond->deleteAll(array('request_id' => $array));
            $this->Session->setFlash("<div class='success msg'>" . __('Customized Request  has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'customizedrequest'));
        }
    }

    public function calc_price_ret($customid = NULL, $size = NULL, $productid = NULL, $gcolor = NULL) {
        $size = $size == 0 ? '' : $size;

        $product = $this->Product->find('first', array('conditions' => array('product_id' => $productid)));
        $category = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
        if ($product['Product']['stone'] == 'Yes') {
            $diamond = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $productid)));
            $diamonddetails = $diamond;
        }
        if ($product['Product']['gemstone'] == 'Yes') {
            $gemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $productid)));
            $sgemstone = $gemstone;
        }

        //gold
        $propurity = $this->Productmetal->find('first', array('conditions' => array('product_id' => $productid, 'type' => 'Purity')));
        $material = explode("K", $customid);

        //pr($material);exit;
        if (!empty($size)) {
            $product_wt = $product['Product']['metal_weight'];
            if ($category['Category']['category'] != "Bangles") {
                $t = '1';
            } else {
                $t = '0.125';
            }

            $minsize = $this->Productmetal->find('first', array('fields' => array('MIN(value) as minsizes'), 'conditions' => array('product_id' => $productid, 'type' => 'Size')));
            $minsizenew = $minsize[0]['minsizes'];
            if ($size == $minsizenew) {
                $add_wt = 0;
            } else {
                $nsize = $this->Size->find('first', array('conditions' => array('size_value BETWEEN ' . ($minsizenew + $t) . ' AND ' . $size, 'goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active'), 'fields' => array('SUM(gold_diff) AS tot_wt')));

                $add_wt = $nsize[0]['tot_wt'];
            }
            $tot_weight = $product_wt + $add_wt;
        } else {
            $tot_weight = $product['Product']['metal_weight'];
        }

        if (!empty($gcolor)) {
            $mcolor = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $gcolor, 'status' => 'Active')));
            $goldprice = $this->Price->find('first', array('conditions' => array('metalcolor_id' => $mcolor['Metalcolor']['metalcolor_id'], 'metal_id' => '1')));
            $gold_price = round(round($goldprice['Price']['price'] * ($material[0] / 24)) * $tot_weight);
            $purity = $material[0];
            $making_charge = $product['Product']['making_charge'];
        } else {
            $gold_price = '0';
            $making_charge = '0';
            $purity = '';
        }

        //diamond
        if (!empty($material[1])) {
            list($clarity, $color) = explode("-", $material[1]);
            $stone_price = '0';
            $diamond_wt = '0';
            $stone_details = $this->Productdiamond->find('first', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid), 'fields' => array('SUM(stone_weight) AS sweight', 'SUM(noofdiamonds) AS stone_nos')));
            $clarities = $this->Clarity->find('first', array('conditions' => array('clarity' => $clarity)));
            $colors = $this->Color->find('first', array('conditions' => array('color' => $color, 'clarity' => $clarity)));
            $stoneprice = $this->Price->find('first', array('conditions' => array('clarity_id' => $clarities['Clarity']['clarity_id'], 'color_id' => $colors['Color']['color_id'])));
            $stone_price = round($stoneprice['Price']['price'] * $stone_details['0']['sweight']);
            $diamond_wt = $stone_details['0']['sweight'] / 5;
            $all_stone_details = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid)));

            $stoneweight = $stone_details['0']['sweight'];
            $noofstones = $stone_details['0']['stone_nos'];
            $stone_details = $all_stone_details;
        } else {
            $clarity = $color = '';
            $stone_price = '0';
            $diamond_wt = '0';
        }

        //gemstone
        if (!empty($gemstone)) {
            $gemprice = 0;
            $gemstone_wt = 0;
            foreach ($gemstone as $gemstones) {
                $stone = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstones['Productgemstone']['gemstone'])));
                $stone_shape = $this->Shape->find('first', array('conditions' => array('shape' => $gemstones['Productgemstone']['shape'])));
                $prices = $this->Price->find('first', array('conditions' => array('gemstone_id' => $stone['Gemstone']['gemstone_id'], 'gemstoneshape' => $stone_shape['Shape']['shape_id'])));
                $gemprice+=round($prices['Price']['price']) * $gemstones['Productgemstone']['stone_weight'];
                $gemstone_wt+=$gemstones['Productgemstone']['stone_weight'] / 5;
            }
        } else {
            $gemprice = '0';
            $gemstone_wt = '';
        }

        $sub_total = $gold_price + $stone_price + $gemprice;
        $making = round($gold_price * ($making_charge / 100));
        $vat = round(($sub_total + $making) * ($product['Product']['vat_cst'] / 100));
        $total = $sub_total + $making + $vat;

        $total_weight = $tot_weight + $diamond_wt + $gemstone_wt;

        $jsonarray = array('size' => $size, 'purity' => $purity, 'clarity' => $clarity, 'color' => $color, 'gold_price' => indian_number_format($gold_price), 'gold_color' => $gcolor, 'stone_price' => indian_number_format($stone_price), 'making_charge' => indian_number_format($making), 'vat' => indian_number_format($vat), 'total' => indian_number_format($total), 'gemstone' => indian_number_format($gemprice), 'weight' => $total_weight, 'goldweight' => $tot_weight);
//        return $jsonarray;
        $json = $jsonarray;

        $ret_diamond_count = $ret_diamond_weight = $ret_gemstone_count = $ret_gemstone_weight = '';
        if (!empty($stone_details)) {
            //added by prakash
            $ret_diamond_count = $stone_details[0]['Productdiamond']['noofdiamonds'];
            $ret_diamond_weight = $stone_details[0]['Productdiamond']['stone_weight'];
            //

            $sd_clarity = '<tr><td width="170">Clarity</td>';
            $sd_color = '<tr><td>Color</td>';
            $sd_nostones = '<tr><td>No.of Stone</td>';
            $sd_weight = '<tr><td>Weight</td>';
            $sd_shape = '<tr><td>Shape</td>';
            $sd_setting_type = '<tr><td>Setting Type</td>';
            $i = 1;
            foreach ($stone_details as $stone_detail) {
                $sd_clarity.='<td class="widthtd">' . $json['clarity'] . '</td>';
                $sd_color.='<td class="widthtd">' . $json['color'] . '</td>';
                if (isset($stone_detail['Productdiamond'])) {
                    $sd_nostones.='<td class="widthtd">' . $stone_detail['Productdiamond']['noofdiamonds'] . '</td>';
                    $sd_weight.='<td class="widthtd">' . $stone_detail['Productdiamond']['stone_weight'] . '</td>';
                    $sd_shape.='<td class="widthtd">' . $stone_detail['Productdiamond']['shape'] . '</td>';
                    $sd_setting_type.='<td class="widthtd">' . $stone_detail['Productdiamond']['settingtype'] . '</td>';
                }
                $i++;
            }
            $sd_clarity.='</tr>';
            $sd_color.='</tr>';
            $sd_shape.='</tr>';
            $sd_setting_type.='</tr>';
            $sd_nostones.='</tr>';
            $sd_weight.='</tr>';


            $stonehtml = '<h1>Diamonds Details</h1>';
            $stonehtml.=(($i > 3) ? ('<div style="overflow-x:scroll;overflow:y:hidden; width:490px;">') : '');
            $stonehtml.='<table cellpadding="0" cellspacing="0" border="0" width="' . (($i > 3) ? ($i * 100) : '100%') . '">
     ' . $sd_clarity . $sd_color . $sd_nostones . $sd_weight . $sd_shape . $sd_setting_type . '	 
     </table>';
            $stonehtml.=(($i > 3) ? ('</div>') : '');
            $stonehtml.='<table width="100%"><tr><td colspan="' . $i . '">&nbsp;</td></tr></table>';
        } else {
            $stonehtml = '';
        }

        $product_details = '';
        $category = ClassRegistry::init('Category')->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
        $product_details.='<table cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr>
                    	<td width="170">Product Code</td>
                    	<td>' . $category['Category']['category_code'] . $product['Product']['product_code'] . '-' . $json['purity'] . 'K' . $json['clarity'] . $json['color'] . '</td>
                    </tr>
                	<tr>
                    	<td>Metal</td>
                    	<td> ' . $json['purity'] . 'K ' . $json['gold_color'] . ' Gold</td>
                    </tr>
					<tr>
                    	<td>Approximate Metal weight</td>
                    	<td>' . $json['goldweight'] . ' gm</td>
                    </tr>
					<tr class="show_non_gold">
                    	<td>Approximate Product weight</td>
                    	<td>' . $json['weight'] . ' gm</td>
                    </tr>
					<tr>
                    	<td>Width</td>
                    	<td>' . $product['Product']['width'] . ' mm</td>
                    </tr>
					<tr>
                    	<td>Height</td>
                    	<td>' . $product['Product']['height'] . ' mm</td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                </table>';
        if (!empty($sgemstone)) {
            //added by prakash
            $ret_gemstone_count = $sgemstone[0]['Productgemstone']['no_of_stone'];
            $ret_gemstone_weight = $sgemstone[0]['Productgemstone']['stone_weight'];
            //

            $gemstone = '';

            foreach ($sgemstone as $sgemstones) {
                $gemstone.='<h1>' . $sgemstones['Productgemstone']['gemstone'] . ' Details</h1>
					<div class="price_div"><table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td width="170">No. of Stone</td>
							<td>' . $sgemstones['Productgemstone']['no_of_stone'] . '</td>
						</tr>
						<tr>
							<td>Shape</td>
							<td> ' . $sgemstones['Productgemstone']['shape'] . '</td>
						</tr>
						<tr>
							<td>Size</td>
							<td>' . $sgemstones['Productgemstone']['size'] . ' mm</td>
						</tr>
						<tr>
							<td>Setting Type</td>
							<td>' . $sgemstones['Productgemstone']['settingtype'] . '</td>
						</tr>						
						<tr>
							<td>Gemstone Weight</td>
							<td>' . $sgemstones['Productgemstone']['stone_weight'] . ' Carat</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
					</table>';
            }
        } else {
            $gemstone = '';
        }


        $price = '';
        $price.='<table cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr>
                    	<td colspan="2" style="border-bottom:none;">
                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td><strong>Component</strong></td>
                                	<td><strong>Rate</strong></td>
                                	<td><strong>Weight</strong></td>
                                	<td><strong>Value</strong></td>
                                </tr>
                            	<tr>
                                	<td>' . $json['purity'] . 'K  ' . $json['gold_color'] . ' Gold</td>
                                	<td>Rs. ' . indian_number_format(round($goldprice['Price']['price'] * ($json['purity'] / 24))) . '/gm</td>
                                	<td>' . $json['goldweight'] . ' gm</td>
                                	<td><span  style="float:left;">Rs.</span><span style="float:right;"> ' . ($json['gold_price']) . '</span></td>
                                </tr>';
        if (!empty($stone_details)) {
            $price.='<tr>
                                	<td colspan="4"><strong>Diamonds</strong></td>
                                </tr>
                            	<tr>
                                	<td>' . $json['clarity'] . '-' . $json['color'] . ' - ' . $noofstones . ' Nos.</td>
                                	<td>Rs. ' . indian_number_format($stoneprice['Price']['price']) . '/ct</td>
                                	<td>' . $stoneweight . ' ct</td>
                                	<td><span style="float:left;">Rs.</span><span style="float:right;"> ' . ($json['stone_price']) . '</span></td>
                                </tr>';
        }
        if (!empty($sgemstone)) {
            foreach ($sgemstone as $sgemstones) {
                $stone = ClassRegistry::init('Gemstone')->find('first', array('conditions' => array('stone' => $sgemstones['Productgemstone']['gemstone'])));
                $stone_shape = ClassRegistry::init('Shape')->find('first', array('conditions' => array('shape' => $sgemstones['Productgemstone']['shape'])));
                $prices = ClassRegistry::init('Price')->find('first', array('conditions' => array('gemstone_id' => $stone['Gemstone']['gemstone_id'], 'gemstoneshape' => $stone_shape['Shape']['shape_id'])));
                $price.='<tr>
													<td colspan="4"><strong>' . $sgemstones['Productgemstone']['gemstone'] . '</strong></td>
												</tr>
												<tr>
													<td>' . $sgemstones['Productgemstone']['shape'] . ' - ' . $sgemstones['Productgemstone']['no_of_stone'] . ' Nos.</td>
													<td>Rs. ' . indian_number_format(round($prices['Price']['price'])) . '/ct</td>
													<td>' . $sgemstones['Productgemstone']['stone_weight'] . ' ct</td>
													<td><span style="float:left;">Rs.</span><span style="float:right;"> ' . round($prices['Price']['price']) * $sgemstones['Productgemstone']['stone_weight'] . '</span></td>
												</tr>';
            }
        }


        $price.='<tr>
                                	<td><strong>Making Charges</strong></td>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                	<td ><span  style="float:left;">Rs.</span><span style="float:right;"> ' . ($json['making_charge'] > 1000 ? indian_number_format($json['making_charge']) : $json['making_charge']) . '</span></td>
                                </tr>
                            	<tr>
                                	<td><strong>VAT</strong></td>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                	<td><span  style="float:left;">Rs.</span><span style="float:right;"> ' . ($json['vat'] > 1000 ? indian_number_format($json['vat']) : $json['vat']) . '</span></td>
                                </tr>
								<tr>
                                	<td><strong>Total</strong></td>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                	<td ><strong><span style="float:left;">Rs.</span><span style="float:right;">' . $json['total'] . '</span></strong></td>
                                </tr>						
                          </table>
                        ';

        $cart = '';
        $cart.='<input type="hidden" name="data[Shoppingcart][product_id]" value="' . $product['Product']['product_id'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][metal]" value="Gold">';
        $cart.='<input type="hidden" name="data[Shoppingcart][size]" value="' . $json['size'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][color]" value="' . $json['color'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][clarity]" value="' . $json['clarity'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][purity]" value="' . $json['purity'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][metalcolor]" value="' . $json['gold_color'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][weight]" value="' . $json['goldweight'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][stoneamount]" value="' . $json['stone_price'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][goldamount]" value="' . $json['gold_price'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][vat]" value="' . $json['vat'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][vat_per]" value="' . $product['Product']['vat_cst'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][making_charge]" value="' . $json['making_charge'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][making_per]" value="' . $product['Product']['making_charge'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][total]" value="' . $json['total'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][goldprice]" value="' . $goldprice['Price']['price'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][stoneprice]" value="' . (!empty($stoneprice) ? $stoneprice['Price']['price'] : '0') . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][gemstoneamount]" value="' . $json['gemstone'] . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][no_of_diamond]" value="' . (!empty($stone_details) ? $noofstones : '') . '">';
        $cart.='<input type="hidden" name="data[Shoppingcart][quantity]" value="1">';

        $array = array_merge(
                array(
            'diamond_count' => $ret_diamond_count,
            'diamond_weight' => $ret_diamond_weight,
            'gemstone_count' => $ret_gemstone_count,
            'gemstone_weight' => $ret_gemstone_weight
                ), $json);

        return $array;
//        $array = array_merge(array('pricediv' => $price, 'product_details' => $product_details, 'stonedetails' => $stonehtml, 'gemstonediv' => $gemstone, 'cartdiv' => $cart), $json);
//        return $array;
    }

    public function calculate_price_request($customid, $size, $productid, $gcolor) {
        echo $customid . '<br />';
        echo $size . '<br />';
        echo $productid . '<br />';
        echo $gcolor . '<br />';
        exit;
        $product = $this->Product->find('first', array('conditions' => array('product_id' => $productid)));
        $category = $this->Category->find('first', array('conditions' => array('category_id' => $product['Product']['category_id'])));
        if ($product['Product']['stone'] == 'Yes') {
            $diamond = $this->Productdiamond->find('all', array('conditions' => array('product_id' => $productid)));
            $this->set('diamonddetails', $diamond);
        }
        if ($product['Product']['gemstone'] == 'Yes') {
            $gemstone = $this->Productgemstone->find('all', array('conditions' => array('product_id' => $productid)));
            $this->set('sgemstone', $gemstone);
        }

        //gold
        $propurity = $this->Productmetal->find('first', array('conditions' => array('product_id' => $productid, 'type' => 'Purity')));
        $material = explode("K", $customid);
        //pr($material);exit;
        if (!empty($size)) {
            $product_wt = $product['Product']['metal_weight'];
            if ($category['Category']['category'] != "Bangles") {
                $t = '1';
            } else {
                $t = '0.125';
            }

            $minsize = $this->Productmetal->find('first', array('fields' => array('MIN(value) as minsizes'), 'conditions' => array('product_id' => $productid, 'type' => 'Size')));
            $minsizenew = $minsize[0]['minsizes'];
            if ($size == $minsizenew) {
                $add_wt = 0;
            } else {
                $nsize = $this->Size->find('first', array('conditions' => array('size_value BETWEEN ' . ($minsizenew + $t) . ' AND ' . $size, 'goldpurity' => $material[0], 'category_id' => $category['Category']['category_id'], 'status' => 'Active'), 'fields' => array('SUM(gold_diff) AS tot_wt')));

                $add_wt = $nsize[0]['tot_wt'];
            }
            $tot_weight = $product_wt + $add_wt;
        } else {
            $tot_weight = $product['Product']['metal_weight'];
        }

        if (!empty($gcolor)) {
            $mcolor = $this->Metalcolor->find('first', array('conditions' => array('metalcolor' => $gcolor, 'status' => 'Active')));
            //modified by prakash
            $goldprice = $this->Price->find('first', array('conditions' => array('metalcolor_id' => $mcolor['Metalcolor']['metalcolor_id'], 'metal_id' => '1', 'metal_fineness' => $product['Product']['metal_fineness'])));
            $gprice = !empty($goldprice['Price']['price']) ? $goldprice['Price']['price'] : 0;

            $gold_price = round(round($gprice * ($material[0] / 24)) * $tot_weight);
//            $gold_price = round(round($goldprice['Price']['price'] * ($material[0] / 24)) * $tot_weight);
            $purity = $material[0];
            $making_charge = $product['Product']['making_charge'];
        } else {
            $gold_price = '0';
            $making_charge = '0';
            $purity = '';
        }

        //diamond
        if (!empty($material[1])) {
            list($clarity, $color) = explode("-", $material[1]);
            $stone_price = '0';
            $diamond_wt = '0';
            $stone_details = $this->Productdiamond->find('first', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid), 'fields' => array('SUM(stone_weight) AS sweight', 'SUM(noofdiamonds) AS stone_nos')));
            $clarities = $this->Clarity->find('first', array('conditions' => array('clarity' => $clarity)));
            $colors = $this->Color->find('first', array('conditions' => array('color' => $color, 'clarity' => $clarity)));
            $stoneprice = $this->Price->find('first', array('conditions' => array('clarity_id' => $clarities['Clarity']['clarity_id'], 'color_id' => $colors['Color']['color_id'])));
            $stone_price = round($stoneprice['Price']['price'] * $stone_details['0']['sweight'], 0, PHP_ROUND_HALF_DOWN);
            $diamond_wt = $stone_details['0']['sweight'] / 5;
            $all_stone_details = $this->Productdiamond->find('all', array('conditions' => array('clarity' => $clarity, 'color' => $color, 'product_id' => $productid)));

            $this->set('stone_details', $all_stone_details);
            $this->set('stoneweight', $stone_details['0']['sweight']);
            $this->set('noofstones', $stone_details['0']['stone_nos']);
            $this->set('stoneprice', $stoneprice);
        } else {
            $clarity = $color = '';
            $stone_price = '0';
            $diamond_wt = '0';
        }

        //gemstone
        if (!empty($gemstone)) {
            $gemprice = 0;
            $gemstone_wt = 0;
            foreach ($gemstone as $gemstones) {
                $stone = $this->Gemstone->find('first', array('conditions' => array('stone' => $gemstones['Productgemstone']['gemstone'])));
                $stone_shape = $this->Shape->find('first', array('conditions' => array('shape' => $gemstones['Productgemstone']['shape'])));
                $prices = $this->Price->find('first', array('conditions' => array('gemstone_id' => $stone['Gemstone']['gemstone_id'], 'gemstoneshape' => $stone_shape['Shape']['shape_id'])));
                $gemprice+=round($prices['Price']['price'] * $gemstones['Productgemstone']['stone_weight']);
                $gemstone_wt+=$gemstones['Productgemstone']['stone_weight'] / 5;
            }
        } else {
            $gemprice = '0';
            $gemstone_wt = '';
        }


        $sub_total = $gold_price + $stone_price + $gemprice;
        $making = 0;
        //addded by prakash
        if ($product['Product']['making_charge_calc'] == 'PER') {
            $making = round($gold_price * ($making_charge / 100), 0, PHP_ROUND_HALF_DOWN);
        } elseif ($product['Product']['making_charge_calc'] == 'INR') {
            $making = $making_charge;
        }
        $vat = round(($sub_total + $making) * ($product['Product']['vat_cst'] / 100), 0, PHP_ROUND_HALF_DOWN);
        $total = $sub_total + $making + $vat;

        $total_weight = $tot_weight + $diamond_wt + $gemstone_wt;

        $jsonarray = array('size' => $size, 'purity' => $purity, 'clarity' => $clarity, 'color' => $color, 'gold_price' => indian_number_format($gold_price), 'gold_color' => $gcolor, 'stone_price' => indian_number_format($stone_price), 'making_charge' => indian_number_format($making), 'vat' => indian_number_format($vat), 'total' => indian_number_format($total), 'gemstone' => indian_number_format($gemprice), 'weight' => $total_weight, 'goldweight' => $tot_weight);

        $this->set('json', $jsonarray);
        $this->set('goldprice', $goldprice);

        $this->set('product', $product);
        $this->set('total_weight', $total_weight);
    }

    public function cart_reminder($user_id = NULL, $order_id = NULL, $template_id = 18) {
        if ($user_id != NULL) {
            $users = $this->User->find('all', array('conditions' => array('User.user_id' => $user_id)));
        } else {
            $users = $this->User->find('all', array('conditions' => array('User.cart_session !=' => '', 'User.reminder_sent' => 'N')));
        }
        foreach ($users as $key => $user) {
            if ($order_id != NULL) {
                $carts = $this->Shoppingcart->find('all', array('conditions' => array('order_id' => $order_id)));
            } else {
                $carts = $this->Shoppingcart->find('all', array('conditions' => array('Shoppingcart.cart_session' => $user['User']['cart_session'], 'Shoppingcart.order_id' => '')));
            }
            if (!empty($carts)) {
                $name = $user['User']['fullname'];
                $product_name_code = '';
                $days_left = 0;
                $product_details = "<table width='100%' style='border: 1px solid black;'>";
                $product_details .= "<thead>";
                $product_details .= "<th colspan='2' style='border-right: 1px solid black;'>Product Name</th>";
                $product_details .= "<th>Product Code</th>";
                $product_details .= "</thead><tbody>";
                foreach ($carts as $key => $cart) {
                    $product = $this->Product->findByProductId($cart['Shoppingcart']['product_id']);
                    $category = $this->Category->findByCategoryId($product['Product']['category_id']);
                    $product_name = $product['Product']['product_name'];
                    $product_code = "{$category['Category']['category_code']}{$product['Product']['product_code']}-{$cart['Shoppingcart']['purity']}K{$cart['Shoppingcart']['clarity']}{$cart['Shoppingcart']['color']}";
                    $product_name_code .= $key == 0 ? "{$product_name} ({$product_code})" : ", {$product_name} ({$product_code})";
                    if ($key == 0) {
                        $dStart = new DateTime(date('Y-m-d', strtotime($cart['Shoppingcart']['created_date'])));
                        $dEnd = new DateTime(date('Y-m-d'));
                        $dDiff = $dStart->diff($dEnd);
                        //                    echo $dDiff->format('%R'); // use for point out relation: smaller/greater
                        $days_left = $dDiff->days;
                    }
                    $images = ClassRegistry::init('Productimage')->find('first', array('conditions' => array('product_id' => $product['Product']['product_id'], 'status' => 'Active')));
                    $src = BASE_URL . "img/product/small/" . $images['Productimage']['imagename'];
                    $product_image = "<img src='{$src}' alt='Image' width='120' height='90'/>";
                    //                $product_image = $this->Html->image('product/small/' . $images['Productimage']['imagename'], array("alt" => "Image", 'width' => '120', 'height' => '90'));
                    $product_details .= "<tr>";
                    $product_details .= "<td style='border-top: 1px solid black; border-right: 1px solid black; text-align: center;'>{$product_name}</td>";
                    $product_details .= "<td style='border-top: 1px solid black; border-right: 1px solid black; text-align: center;'>{$product_image}</td>";
                    $product_details .= "<td style='border-top: 1px solid black; text-align: center;'>{$product_code}</td>";
                    $product_details .= "</tr>";
                }
                $link = $template_id == 18 ? BASE_URL . 'shoppingcarts/shopping_cart' : BASE_URL . 'orders/order';
                $process = $template_id == 18 ? 'Proceed To Checkout' : 'Go to Cart';
                $product_details .= "<tr style='margin: 6px; padding: 6px;'><td colspan='3' style='border-top: 1px solid black; text-align: right; margin: 6px; padding: 6px;'><a href='{$link}' target='_blank' style='text-decoration: none'> >> {$process}</a></td></tr>";
                $product_details .= "</tbody></table>";
                $activateemail = $this->Emailcontent->find('first', array('conditions' => array('eid' => $template_id)));
                $gotocart = "<a href='$link' target='_blank'>go to cart</a>";
                $message = str_replace(array('{product_name_code}', '{days_left}', '{product_details}', '{name}', '{gotocart}'), array($product_name_code, $days_left, $product_details, $name, $gotocart), $activateemail['Emailcontent']['content']);
                $this->mailsend(SITE_NAME, $activateemail['Emailcontent']['fromemail'], $user['User']['email'], $activateemail['Emailcontent']['subject'], $message);
                $this->User->id = $user['User']['user_id'];
                $this->User->saveField('reminder_sent', 'Y');
            }
        }
        return true;
    }

    public function testmail($from, $to) {
        $subject = 'Application Form ';
        $message = 'testing';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: admin <$from>" . "\r\n";
        if (mail($to, $subject, $message, $headers)) {
            echo "Mail Successfully Sent..";
            exit;
        }
//        mail($to, 'test', 'test test');
//        App::uses('CakeEmail', 'Network/Email');
//        $Email = new CakeEmail();
//        $Email->from($from);
////        $Email->from('customer.service@shagunn.in');
////        $Email->to('arulmani090@gmail.com');
//        $Email->to($to);
//        $Email->subject('About');
//        $Email->send('My message');
        exit;
    }

}
