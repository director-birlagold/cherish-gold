<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class BannersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Banner', 'Adminuser');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->checkadmin();
        $this->Banner->recursive = 0;
        $this->set('banners', $this->paginate('Banner'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Banner->create();
            $banner = $this->Banner->find('first', array('conditions' => array('title' => $this->request->data['Banner']['title'], 'status !=' => 'Trash')));
            if (empty($banner)) {
                if ($this->request->data['Banner']['images']['name'] != '') {
                    extract($this->request->data['Banner']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/banner/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Banner']['image'] = $imagename;
                    }
                }
                if ($this->Banner->save($this->request->data)) {
                    $this->Session->setFlash('<div class="success msg">' . __('Banner added sucessfully') . '</div>', '');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="success msg">' . __('Banner could not be saved. Please try again') . '</div>', '');
                }
            } else {
                $this->Session->setFlash('<div class="error msg">Banner title  already exits.</div>', '');
            }
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->checkadmin();
        if (!$this->Banner->exists($id)) {
            throw new NotFoundException(__('Invalid Banner'));
        }
        $options = array('conditions' => array('Banner.' . $this->Banner->primaryKey => $id));
        $banner = $this->Banner->find('first', $options);
        if ($this->request->is(array('post', 'put'))) {
            $check = $this->Banner->find('first', array('conditions' => array('title' => $this->request->data['Banner']['title'], 'bid !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $this->request->data['Banner']['bid'] = $id;
                if ($this->request->data['Banner']['images']['name'] != '') {

                    extract($this->request->data['Banner']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/banner/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Banner']['image'] = $imagename;
                    }
                }
                if ($this->Banner->save($this->request->data)) {
                    $this->Session->setFlash('<div class="success msg">' . __('Banner updated sucessfully') . '</div>', '');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="success msg">' . __('Banner could not be saved. Please try again') . '</div>', '');
                }
            } else {
                $this->Session->setFlash('<div class="error msg">The Banner title already exists</div>');
            }
        }

        $this->request->data = $banner;
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->checkadmin();
        $id = $this->params['pass']['0'];
        $this->Banner->id = $id;
        if (!$this->Banner->exists()) {
            throw new NotFoundException(__('Invalid Banner id'));
        }
        //$this->request->onlyAllow('post', 'delete');
        $options = array('conditions' => array('Banner.' . $this->Banner->primaryKey => $id));
        $banner = $this->Banner->find('first', $options);
        if (!empty($banner['Banner']['image']))
            unlink('img/banner/' . $banner['Banner']['image']);

        if ($this->Banner->delete()) {
            $this->Session->setFlash('<div class="success msg">' . __('Banner deleted successfully') . '</div>');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('<div class="error msg">' . __('Banner was not deleted') . '</div>');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_changestatus($id = null, $status = null) {
        $this->checkadmin();
        $id = $this->params['pass']['0'];
        $this->Banner->id = $id;
        if (!$this->Banner->exists()) {
            throw new NotFoundException(__('Invalid Banner id'));
        }
        $this->request->data['Banner']['bid'] = $id;
        $this->request->data['Banner']['status'] = $status;
        if ($this->Banner->save($this->request->data)) {
            $this->Session->setFlash('<div class="success msg">' . __('Banner status updated successfully') . '</div>');
            $this->redirect(array('action' => 'index'));
        }
        //$this->Session->setFlash('<div class="error msg">'.__('Banner was not deleted').'</div>');
        $this->redirect(array('action' => 'index'));
    }

}
