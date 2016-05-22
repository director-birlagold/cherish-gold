<?php

App::uses('AppController', 'Controller');

/**
 * Vendorplants Controller
 *
 * @property Vendorplant $Vendorplant
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TestimonialsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Image');
    public $uses = array('Testimonial', '');
    public $layout = 'admin';
	 /*List  Testimonial */
    public function admin_index() {
        $this->checkadmin();
        $this->Testimonial->recursive = 0;
		/*search redirect*/
        $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if (isset($this->request->data['searchfilter'])) {
            $this->redirect(array('action' => 'index/' . $this->params['pass']['0'] . '?search=1&searchterm=' . $this->request->data['searchterm']));
        }
		/*query for search*/

        if ($this->request->query('search') != '') {
            $conditions = array('name LIKE' => '%' . $this->request->query('searchterm') . '%', 'status !=' => 'Trash', 'type' => $cms);
        } else {
            $conditions = array('status !=' => 'Trash', 'type' => $cms);
        }

        $this->paginate = array('conditions' => $conditions, 'order' => 'test_id DESC');
        $this->set('testimonial', $this->Paginator->paginate('Testimonial'));
        $this->set('cms', $cms);
    }
	/*Add Testimonial */
    public function admin_add() {
        $this->checkadmin();
        $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if ($this->request->is('post')) {
            $test = $this->Testimonial->find('first', array('conditions' => array('name' => $this->request->data['Testimonial']['name'], 'type' => $cms, 'status !=' => 'Trash')));
            if (empty($test)) {
                if (!empty($this->request->data['Testimonial']['images']['name'])) {
					/*$this->request->data['Testimonial']['image'] = $this->Image->upload_image_and_thumbnail($this->request->data['Testimonial']['images'], 800, 800, 112, 126, "testimonial");*/
                    extract($this->request->data['Testimonial']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/testimonial/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Testimonial']['image'] = $imagename;
                    }
                }
                $this->request->data['Testimonial']['status'] = 'Active';
                $this->request->data['Testimonial']['type'] = $cms;
                $this->request->data['Testimonial']['created_date'] = date('Y-m-d H:i:s');
                $this->Testimonial->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">' . $cms . ' added successfully.</div>', '');
                $this->redirect(array('action' => 'index', $this->params['pass']['0']));
            } else {
                $this->Session->setFlash('<div class="error msg">' . $cms . ' name already exits.</div>', '');
            }
        }
        $this->set('cms', $cms);
    }
	/*Edit  Testimonial */
    public function admin_edit($cms, $id = null) {
        $this->checkadmin();
        $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));

        $test = $this->Testimonial->find('first', array('conditions' => array('test_id' => $id)));
        $this->set('test', $test);
        $this->set('cms', $cms);
        if ($this->request->is('post')) {
			          $check = $this->Testimonial->find('first', array('conditions' => array('name' => $this->request->data['Testimonial']['name'], 'status !=' => 'Trash', 'type' => $cms, 'test_id !=' => $id)));
            if (empty($check)) {
                $this->request->data['Testimonial']['test_id'] = $id;
			/*File Upload*/
                if (!empty($this->request->data['Testimonial']['images']['name'])) {
                    extract($this->request->data['Testimonial']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/testimonial/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Testimonial']['image'] = $imagename;
                    }
					//$this->request->data['Testimonial']['image'] = $this->Image->upload_image_and_thumbnail($this->request->data['Testimonial']['images'], 800, 800, 112, 126, "testimonial");
                }else{
					$this->request->data['Testimonial']['image']=$test['Testimonial']['image'];
				}
                $this->request->data['Testimonial']['type'] = $cms;
                $this->Testimonial->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">' . $cms . ' updated successfully.</div>', '');
                $this->redirect(array('action' => 'index', $this->params['pass']['0']));
            } else {
                $this->Session->setFlash('<div class="error msg">' . $cms . ' name already exits.</div>', '');
            }
        }
    }
	/*Delete  Testimonial */
    public function admin_delete() {
        $this->checkadmin();
		/*Single Testimonial  Delete*/
        $cms = ucwords(str_replace('_', ' ', $this->params['pass']['0']));
        if (!empty($this->params['pass']['1'])) {
            $this->request->data['Testimonial']['test_id'] = $this->params['pass']['1'];
            $this->request->data['Testimonial']['status'] = 'Trash';
            $this->Testimonial->updateAll(array('status' => "'Trash'"), array('test_id' => $this->params['pass']['1']));
            $this->Session->setFlash('<div class="success msg">' . $cms . ' has been deleted successfully.</div>', '');
            $this->redirect(array('action' => 'index', $this->params['pass']['0']));
        } else {
			/*Multiple Testimonial  Delete*/
            if (!empty($this->request->data['action'])) {
                $array = array_filter($this->request->data['action']);
                $this->Testimonial->updateAll(array('status' => "'Trash'"), array('test_id' => $array));
                $this->Session->setFlash('<div class="success msg">' . $cms . ' has been deleted successfully.</div>', '');
                $this->redirect(array('action' => 'index', $this->params['pass']['0']));
            }
        }
        $this->redirect(array('action' => 'index', $this->params['pass']['0']));
    }
	/*Change Status  Testimonial */
    public function admin_changestatus() {
        $this->checkadmin();
        $this->request->data['Testimonial']['test_id'] = $this->params['pass']['1'];
        $this->request->data['Testimonial']['status'] = $this->params['pass']['2'];
        $this->Testimonial->save($this->request->data);
        $this->Session->setFlash('<div class="success msg">' . ucwords(str_replace('_', ' ', $this->params['pass']['0'])) . ' ' . __('Status updated successfully') . '.</div>', '');
        $this->redirect(array('action' => 'index', $this->params['pass']['0']));
    }

}
