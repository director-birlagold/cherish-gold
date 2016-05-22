<?php

App::uses('AppController', 'Controller');

/**
 * Category Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Category', 'Subcategory');
    public $layout = 'admin';

    public function admin_index() {
        $this->checkadmin();
        $this->Category->recursive = 0;
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => '?search=1&searchcategory=' . $this->request->data['searchcategory']));
        }

        if ($this->request->query('search') != '') {
            $conditions = array('category LIKE' => '%' . $this->request->query('searchcategory') . '%');
        } else {
            $conditions = array('status !=' => 'Trash');
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'category_id DESC');
        $this->set('category', $this->Paginator->paginate('Category'));
    }

    public function admin_add() {
        $this->checkadmin();

        if ($this->request->is('post')) {
            $page_link = strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $this->request->data['Category']['category'])));
            if ($page_link == '') {
                $page_link = strtolower(str_replace(array(' ', '\''), array('_', '-'), $this->request->data['Category']['category']));
            }
            $check = $this->Category->find('first', array('conditions' => array('OR' => array('link' => $page_link, 'category_code' => $this->request->data['Category']['category_code'])), 'status !=' => 'Trash'));

            if (empty($check)) {
							 $this->request->data['Category']['category']=trim($this->request->data['Category']['category']);

                $this->request->data['Category']['link'] = $page_link;
                $this->request->data['Category']['status'] = 'Active';
                $this->request->data['Category']['created_date'] = date('Y-m-d H:i:s');
                $this->request->data['Category']['modify_date'] = date('Y-m-d H:i:s');
                $this->Category->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Category added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Category  already exits.</div>', '');
            }
        }
    }

    public function admin_edit() {
        $this->checkadmin();

        if ($this->request->is('post')) {
            $page_link = strtolower(str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9_ -]/s', ' ', $this->request->data['Category']['category'])));
            if ($page_link == '') {
                $page_link = strtolower(str_replace(array(' ', '\''), array('_', '-'), $this->request->data['Category']['category']));
            }
            $check = $this->Category->find('first', array('conditions' => array(
                    'status !=' => 'Trash',
                    'category_id !=' => $this->params['pass']['0'],
                    'or' => array(
                        'category' => $this->request->data['Category']['category'],
                        'category_code' => $this->request->data['Category']['category_code']
                    )
                )
            ));
            if (empty($check)) {
                $this->request->data['Category']['category_id'] = $this->params['pass']['0'];
                $this->request->data['Category']['link'] = $page_link;
								 $this->request->data['Category']['category']=trim( $this->request->data['Category']['category']);

                $this->request->data['Category']['modify_date'] = date('Y-m-d H:i:s');
                $this->Category->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Category updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Category code already exits.</div>', '');
            }
        }
        $category = $this->Category->find('first', array('conditions' => array('category_id' => $this->params['pass']['0'])));
        $this->set('category', $category);
    }

    public function admin_delete() {
        $this->checkadmin();

        if (!empty($this->params['pass']['0'])) {
            $this->request->data['Category']['category_id'] = $this->params['pass']['0'];
            $this->request->data['Category']['status'] = 'Trash';
            $this->Category->save($this->request->data);
            $this->Subcategory->updateAll(array('status' => "'Trash'"), array('category_id' => $this->params['pass']['0']));
            $this->Session->setFlash("<div class='success msg'>" . __('Category has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            if (!empty($this->request->data['action'])) {
                $array = array_filter($this->request->data['action']);
                $this->Category->updateAll(array('status' => "'Trash'"), array('category_id' => $array));
                $this->Subcategory->updateAll(array('status' => "'Trash'"), array('category_id' => $array));
                $this->Session->setFlash("<div class='success msg'>" . __('Categories has been deleted successfully') . "</div>", '');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function admin_changestatus($id, $status) {
        $this->checkadmin();
        $this->request->data['Category']['category_id'] = $id;
        $this->request->data['Category']['status'] = $status;
        $this->Category->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . __('Category Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index'));
    }

}
