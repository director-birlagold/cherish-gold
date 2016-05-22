<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AdvertisementsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Image');
    public $uses = array('Advertisement', 'Adminuser', 'Advertisementdetails');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
	 /*List Advertisement*/
    public function admin_index() {
        $this->checkadmin();
        $this->Advertisement->recursive = 0;
        $this->set('advertisement', $this->paginate('Advertisement'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
	  /*Add Advertisement*/
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Advertisement->create();
            $advertisement = $this->Advertisement->find('first', array('conditions' => array('title' => $this->request->data['Advertisement']['title'], 'status !=' => 'Trash')));
            if (empty($advertisement)) {
                if ($this->request->data['Advertisement']['images']['name'] != '') {
                    extract($this->request->data['Advertisement']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/advertisement/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Advertisement']['images'] = $imagename;
                    }
                }
                $this->request->data['Advertisement']['created_date'] = date('Y-m-d H:i:s');
                if ($this->Advertisement->save($this->request->data)) {
                    $this->Session->setFlash('<div class="success msg">' . __('Advertisement Banner added sucessfully') . '</div>', '');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="success msg">' . __(' Advertisement Banner could not be saved. Please try again') . '</div>', '');
                }
            } else {
                $this->Session->setFlash('<div class="error msg"> Advertisement Banner title  already exits.</div>', '');
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
	  /*Edit Advertisement*/
    public function admin_edit($id = null) {
        $this->checkadmin();
        if (!$this->Advertisement->exists($id)) {
            throw new NotFoundException(__('Invalid Advertisement'));
        }
        $options = array('conditions' => array('Advertisement.' . $this->Advertisement->primaryKey => $id));
        $advertisement = $this->Advertisement->find('first', $options);
        $images = $this->Advertisementdetails->find('all', array('conditions' => array('ads_id' => $this->params['pass'][0], 'status' => 'Active')));
        $this->set('images', $images);
        if ($this->request->is(array('post', 'put'))) {

            $check = $this->Advertisement->find('first', array('conditions' => array('title' => $this->request->data['Advertisement']['title'], 'ads_id !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $this->request->data['Advertisement']['ads_id'] = $id;

                if ($this->params['pass']['0'] == 1) {

                    if ($this->request->data['Advertisementdetails']['image'][0]['name'] != '') {
                        //$this->Advertisementdetails->deleteAll(array('ads_id'=>$this->params['pass']['0']));
                        foreach ($this->request->data['Advertisementdetails']['image'] as $image) {
                            $this->request->data['Advertisementdetails']['ads_id'] = $id;
                            $this->request->data['Advertisementdetails']['status'] = 'Active';
                            $this->request->data['Advertisementdetails']['type'] = 'Image';
                            $this->request->data['Advertisementdetails']['values'] = $this->Image->upload_image_and_thumbnail($image, 800, 800, 215, 133, "advertisement", '1');
                            $this->Advertisementdetails->saveAll($this->request->data);
                        }
                    }
                }
                if ($this->params['pass']['0'] == 2) {
                    $this->request->data['Advertisementdetails']['ads_id'] = $id;
                    $this->request->data['Advertisementdetails']['status'] = 'Active';
                    $this->request->data['Advertisementdetails']['type'] = 'Link';
                    //$this->request->data['Advertisementdetails']['video']=$this->Image->upload_image_and_thumbnail($this->request->data['Advertisementdetails']['video'],800,800,215,133,"advertisement",'1');
                    $this->Advertisementdetails->saveAll($this->request->data);
                }
                if ($this->params['pass']['0'] == 3) {


                    if (!empty($this->request->data['Advertisementdetails'])) {

                        $i = 0;
                        foreach ($this->request->data['Advertisementdetails'] as $advertisementdetails) {
                            $advertisementdetails['ads_id'] = $id;
                            if ($advertisementdetails['video'] != '') {
                                if ($advertisementdetails['type'] == "Link") {
                                    $advertisementdetails['values'] = $advertisementdetails['link'];
                                } else {
                                    $image = $advertisementdetails['image'];
                                    //foreach($this->request->data['Advertisementdetails']['image'] as $image){
                                    if (!empty($image['name'])) {
                                        $images = explode('.', $image['name']);
                                        if (end($images) == 'pdf' || end($images) == 'ppt') {
                                            $advertisement_details['type'] = 'Image';
                                            if ($image['name'] != '') {
                                                extract($image);
                                                if ($size && !$error) {
                                                    $extension = $this->getFileExtension($name);
                                                    $extension = strtolower($extension);
                                                    $m = explode(".", $name);
                                                    $imagename = time() . "." . $extension;
                                                    $destination = 'img/advertisement/' . $imagename;
                                                    move_uploaded_file($tmp_name, $destination);
                                                    $advertisementdetails['values'] = $imagename;
                                                }
                                            }
                                        }
                                    }
                                    //}
                                }
                                $this->Advertisementdetails->saveAll($advertisementdetails);
                            }
                            $i++;
                        }
                    }
                }
                if (!empty($this->request->data['Advertisement']['images']['name'])) {
                    //pr($this->request->data['Advertisement']['images']['name']);exit;
                    extract($this->request->data['Advertisement']['images']);
                    if ($size && !$error) {
                        $extension = $this->getFileExtension($name);
                        $extension = strtolower($extension);
                        $m = explode(".", $name);
                        $imagename = time() . "." . $extension;
                        $destination = 'img/advertisement/' . $imagename;
                        move_uploaded_file($tmp_name, $destination);
                        $this->request->data['Advertisement']['images'] = $imagename;
                    }
                } else {
                    $this->request->data['Advertisement']['images'] = $advertisement['Advertisement']['images'];
                }
                if ($this->Advertisement->save($this->request->data)) {
                    $this->Session->setFlash('<div class="success msg">' . __(' Advertisement Banner updated sucessfully') . '</div>', '');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="success msg">' . __('Advertisement Banner could not be saved. Please try again') . '</div>', '');
                }
            } else {
                $this->Session->setFlash('<div class="error msg">The Advertisement Banner title already exists</div>');
            }
        }
        $this->request->data = $advertisement;
    }
	/*Delete Advertisement*/
    public function admin_deletead() {
        $this->checkadmin();
        $id = $this->params['pass']['0'];
        $adid = $this->params['pass']['1'];
        if ($id != '' && $adid != '') {
            $this->Advertisementdetails->deleteAll(array('advertisement_id' => $id), false, false, false);
            $this->Session->setFlash('<div class="success msg">' . __('Advertisement deleted successfully') . '</div>', '');
            $this->redirect(array('action' => 'edit', $adid));
        } else {
            $this->Session->setFlash('<div class="error msg">Parameter missing. Please try again</div>');
            $this->redirect(array('action' => 'index'));
        }
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
        $this->Advertisement->id = $id;
        if (!$this->Advertisement->exists()) {
            throw new NotFoundException(__('Invalid ads_id'));
        }
        //$this->request->onlyAllow('post', 'delete');
        $options = array('conditions' => array('Advertisement.' . $this->Advertisement->primaryKey => $id));
        $advertisement = $this->Advertisement->find('first', $options);
        if (!empty($advertisement['Advertisement']['images']))
            unlink('img/advertisement/' . $advertisement['Advertisement']['images']);

        if ($this->Advertisement->delete()) {
            $this->Session->setFlash('<div class="success msg">' . __('Banner deleted successfully') . '</div>');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('<div class="error msg">' . __('Banner was not deleted') . '</div>');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_changestatus($id = null, $status = null) {
        $this->checkadmin();
        $id = $this->params['pass']['0'];
        $this->Advertisement->id = $id;
        if (!$this->Advertisement->exists()) {
            throw new NotFoundException(__('Invalid Advertisement id'));
        }
        $this->request->data['Advertisement']['ads_id'] = $id;
        $this->request->data['Advertisement']['status'] = $status;
        if ($this->Advertisement->save($this->request->data)) {
            $this->Session->setFlash('<div class="success msg">' . __('Advertisement Banner status updated successfully') . '</div>');
            $this->redirect(array('action' => 'index'));
        }
        //$this->Session->setFlash('<div class="error msg">'.__('Banner was not deleted').'</div>');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_deleteimages() {
        $this->checkadmin();
        if (!empty($this->params['pass']['1'])) {
            $this->Advertisementdetails->id = $this->params['pass']['1'];
            $id = $this->params['pass']['1'];
            if (!$this->Advertisementdetails->exists()) {
                throw new NotFoundException(__('Invalid Image'));
            }$this->request->data['Advertisementdetails']['advertisement_id'] = $this->params['pass']['1'];
            $this->request->data['Advertisementdetails']['status'] = 'Trash';
            $this->Advertisementdetails->save($this->request->data);
            $this->Session->setFlash("<div class='success msg'>" . __('Product Image has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'admin_edit', $this->params['pass']['0']));
        }
    }

}
