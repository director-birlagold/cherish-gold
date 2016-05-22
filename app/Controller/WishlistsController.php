<?php

App::uses('AppController', 'Controller');

/**
 * Vendors Controller
 *
 * @property Vendor $Vendor
 * @property PaginatorComponent $Paginator
 */
class WishlistsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Whislist', 'User', 'Product');
    public $layout = 'admin';
	/*List Whislist*/
    public function admin_index() {
        $this->checkadmin();
        $this->Whislist->recursive = 0;
	/*search redirect*/	
        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['username'] != '') {
                $search[] = 'username=' . $this->request->data['username'];
            }

            if ($this->request->data['productname'] != '') {
                $search[] = 'productname=' . $this->request->data['productname'];
            }

            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }
	/*query for search*/
        if ($this->request->query('search') != '') {

            $search = array();
            $search = array('Whislist.status !=' => 'Trash');
            if (($this->request->query('username') != '') && ($this->request->query('productname') != '')) {

                $user = $this->User->find('first', array('conditions' => array('first_name' => $this->request->query('username'))));
                $product = $this->Product->find('first', array('conditions' => array('product_name' => $this->request->query('productname'))));
                $search = array_merge($search, array('Whislist.product_id' => $product['Product']['product_id'], 'Whislist.user_id' => $user['User']['user_id']));
            } elseif ($this->request->query('username') != '') {
                $user = $this->User->find('first', array('conditions' => array('first_name' => $this->request->query['username'])));
                $search = array_merge($search, array('Whislist.user_id' => $user['User']['user_id']));
            } elseif ($this->request->query('productname') != '') {

                $product = $this->Product->find('first', array('conditions' => array('product_name' => $this->request->query['productname'])));
                $search = array_merge($search, array('Whislist.product_id' => $product['Product']['product_id']));
            }
            $this->paginate = array('conditions' => $search, 'order' => 'whislist_id DESC');
            $this->set('wishlist', $this->Paginator->paginate('Whislist'));
        } else {
            $this->paginate = array('conditions' => array('status !=' => 'Trash'), 'order' => 'whislist_id DESC');
            $this->set('wishlist', $this->Paginator->paginate('Whislist'));
        }
    }
	/*Change Status Whislist*/
    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Whislist']['whislist_id'] = $id;
        $this->request->data['Whislist']['status'] = $status;
        $this->Whislist->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Wish List Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }
		/*Delete Whislist*/
    public function admin_delete() {
        $this->checkadmin();
		/*Single Whislist Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->Whislist->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Whislist->exists()) {
                throw new NotFoundException(__('Invalid Whislist'));
            }

            $this->request->data['Whislist']['whislist_id'] = $this->params['pass']['0'];
            $this->request->data['Whislist']['status'] = 'Trash';
            $this->Whislist->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Wish list has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
				/*Multiple Whislist Delete*/
            if (!empty($this->request->data['action'])) {
                foreach ($this->request->data['action'] as $price) {
                    if ($price > 0) {
                        $this->request->data['Whislist']['whislist_id'] = $price;
                        $this->request->data['Whislist']['status'] = 'Trash';
                        $this->Whislist->saveAll($this->request->data);
                    }
                }
            }
            $this->Session->setFlash("<div class='success msg'>" . __('Wish list has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

}
