<?php

App::uses('AppController', 'Controller');

/**
 * Category Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class SubcategoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Subcategory', 'Category');
    public $layout = 'admin';
	 /*List the Sub Categories*/
    public function admin_index() {
        $this->checkadmin();
        $this->Subcategory->recursive = 0;
		/*search redirect*/
        if (isset($this->request->data['searchfilter'])) {
            $search = array();
            if ($this->request->data['searchcategory'] != '') {
                $search[] = 'searchcategory=' . $this->request->data['searchcategory'];
            }

            if ($this->request->data['searchsubcategory'] != '') {
                $search[] = 'searchsubcategory=' . $this->request->data['searchsubcategory'];
            }
            if (!empty($search)) {
                $this->redirect(array('action' => '?search=1&' . implode('&', $search)));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }
		/*query for search*/
        if ($this->request->query('search') != '') {
            $conditions['status !='] = 'Trash';
            if ($this->request->query('searchcategory') != '') {
                $conditions['category_id'] = $this->request->query('searchcategory');
            }
            if ($this->request->query('searchsubcategory') != '') {
                $conditions['subcategory LIKE'] = '%' . $this->request->query('searchsubcategory') . '%';
            }
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'subcategory_id DESC');
        $this->set('subcategory', $this->Paginator->paginate('Subcategory'));

        $category = $this->Category->find('all', array('conditions' => array('status !=' => 'Trash')));
        $this->set('category', $category);
    }
	/*Add Subcategory */
    public function admin_add() {
        $this->checkadmin();

        if ($this->request->is('post')) {
            $page_link = strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $this->request->data['Subcategory']['subcategory'])));
            if ($page_link == '') {
                $page_link = strtolower(str_replace(array(' ', '\''), array('_', '-'), $this->request->data['Subcategory']['subcategory']));
            }
            $check = $this->Subcategory->find('first', array('conditions' => array('OR' => array('link' => $page_link, 'subcategory_code' => $this->request->data['Subcategory']['subcategory_code'])), 'status !=' => 'Trash'));

            if (empty($check)) {
                $this->request->data['Subcategory']['link'] = $page_link;
								$this->request->data['Subcategory']['subcategory'] =trim($this->request->data['Subcategory']['subcategory']);

                $this->request->data['Subcategory']['status'] = 'Active';
                $this->request->data['Subcategory']['created_date'] = date('Y-m-d H:i:s');
                $this->request->data['Subcategory']['modify_date'] = date('Y-m-d H:i:s');
                $this->Subcategory->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Subcategory added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Subcategory already exits.</div>', '');
            }
        }

        $category = $this->Category->find('all', array('conditions' => array('status !=' => 'Trash')));
        $this->set('category', $category);
    }
	/*Edit Subcategory */
    public function admin_edit() {
        $this->checkadmin();

        if ($this->request->is('post')) {
            $page_link = strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $this->request->data['Subcategory']['subcategory'])));
            if ($page_link == '') {
                $page_link = strtolower(str_replace(array(' ', '\''), array('_', '-'), $this->request->data['Subcategory']['subcategory']));
            }
            $check = $this->Subcategory->find('first', array('conditions' => array(
                    'status !=' => 'Trash',
                    'subcategory_id !=' => $this->params['pass']['0'],
                    'category_id' => $this->request->data['Subcategory']['category_id'],
                    'or' => array(
                        'link' => $page_link,
                        'subcategory_code' => $this->request->data['Subcategory']['subcategory_code']
                    )
                )
            ));
            if (empty($check)) {
                $this->request->data['Subcategory']['subcategory_id'] = $this->params['pass']['0'];
                $this->request->data['Subcategory']['link'] = $page_link;
								$this->request->data['Subcategory']['subcategory'] =trim($this->request->data['Subcategory']['subcategory']);

                $this->request->data['Subcategory']['modify_date'] = date('Y-m-d H:i:s');
                $this->Subcategory->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Subcategory updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Subcategory already exits.</div>', '');
            }
        }
        $category = $this->Category->find('all', array('conditions' => array('status !=' => 'Trash')));
        $this->set('category', $category);

        $subcategory = $this->Subcategory->find('first', array('conditions' => array('subcategory_id' => $this->params['pass']['0'])));
        $this->set('subcategory', $subcategory);
    }
	/*Delete Subcategory */
    public function admin_delete() {
        $this->checkadmin();
		/*Single Subcategory  Delete*/
        if (!empty($this->params['pass']['0'])) {
            $this->request->data['Subcategory']['subcategory_id'] = $this->params['pass']['0'];
            $this->request->data['Subcategory']['status'] = 'Trash';
            $this->Subcategory->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Subcategory has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
			/*Multiple Subcategory  Delete*/
            if (!empty($this->request->data['action'])) {
                $array = array_filter($this->request->data['action']);
                $this->Subcategory->updateAll(array('status' => "'Trash'"), array('subcategory_id' => $array));
                $this->Session->setFlash("<div class='success msg'>" . __('Subcategories has been deleted successfully') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
	/*Change Status Subcategory */
    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Subcategory']['subcategory_id'] = $id;
        $this->request->data['Subcategory']['status'] = $status;
        $this->Subcategory->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Subcategory Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
