<?php

App::uses('AppController', 'Controller');

/**
 * Ads Controller
 *
 * @property Ad $Ad
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NewslettersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');
    public $uses = array('Newsletter', 'Adminuser');
    public $layout = 'admin';

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->checkadmin();
        $this->Newsletter->recursive = 0;
        $this->paginate = array('order' => 'newsletter_id DESC');
        $this->set('newsletters', $this->Paginator->paginate('Newsletter'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->checkadmin();
        if ($this->request->is('post')) {
            $this->Newsletter->create();
            $newsletter = $this->Newsletter->find('first', array('conditions' => array('email' => $this->request->data['Newsletter']['email'], 'status !=' => 'Trash')));
            if (empty($newsletter)) {
                $this->request->data['Newsletter']['created_date'] = date('Y-m-d H:i:s');
                $this->Newsletter->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Email added successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">Email id already exits.</div>', '');
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
        if (!$this->Newsletter->exists($id)) {
            throw new NotFoundException(__('Invalid Newsletter'));
        }
        $newsletter = $this->Newsletter->find('first', array('conditions' => array('newsletter_id ' => $this->params['pass']['0'])));
        if ($this->request->is('post') || $this->request->is('put')) {
            $check = $this->Newsletter->find('first', array('conditions' => array('email' => $this->request->data['Newsletter']['email'], 'newsletter_id !=' => $this->params['pass']['0'])));
            if (empty($check)) {
                $this->request->data['Newsletter']['newsletter_id'] = $this->params['pass'][0];
                $this->Newsletter->save($this->request->data);
                $this->Session->setFlash('<div class="success msg">Newsletter updated successfully.</div>', '');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="error msg">The Newsletter already exists</div>');
            }
        }
        $this->request->data = $newsletter;
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
        if (!empty($this->params['pass']['0'])) {
            $this->Newsletter->id = $this->params['pass']['0'];
            $id = $this->params['pass']['0'];
            if (!$this->Newsletter->exists()) {
                throw new NotFoundException(__('Invalid Newsletter'));
            }
            $this->Newsletter->delete(array('newsletter_id' => $this->params['pass']['0']));
            $this->Session->setFlash("<div class='success msg'>" . __('Newsletter has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Newsletter->deleteAll(array('newsletter_id IN (' . implode(",", $this->request->data['action']) . ')'), false, false);
            $this->Session->setFlash("<div class='success msg'>" . __('Newsletter has been deleted successfully') . "</div>", '');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function admin_changestatus($id = null, $status = null) {
        $this->checkadmin();
        $id = $this->params['pass']['0'];
        $this->Newsletter->id = $id;
        if (!$this->Newsletter->exists()) {
            throw new NotFoundException(__('Invalid Newsletter id'));
        }
        $this->request->data['Newsletter']['newsletter_id'] = $id;
        $this->request->data['Newsletter']['status'] = $status;
        if ($this->Newsletter->save($this->request->data)) {
            $this->Session->setFlash('<div class="success msg">' . __('Newsletter status updated successfully') . '</div>');
            $this->redirect(array('action' => 'index'));
        }

        $this->redirect(array('action' => 'index'));
    }

    public function admin_newsletter_export() {
        $this->layout = '';
        $this->render(false);
        ini_set('max_execution_time', 600);
        //create a file
        $filename = "newsletter.csv";
        $csv_file = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $results = $this->Newsletter->find('all', array('conditions' => array('status !=' => 'Trash')));
        $header_row = array("S.No", "Email", "Status", "Created date");
        fputcsv($csv_file, $header_row, ',', '"');
        $i = 1;
        foreach ($results as $results) {

            $row = array(
                $i,
                $results['Newsletter']['email'],
                $results['Newsletter']['status'],
                $results['Newsletter']['created_date']);
            $i++;
            fputcsv($csv_file, $row, ',', '"');
        }
        fclose($csv_file);
    }

}
