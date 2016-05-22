<?php

App::uses('AppController', 'Controller');

/**
 * Vendorcontacts Controller
 *
 * @property Vendorcontact $Vendorcontact
 * @property PaginatorComponent $Paginator
 * @property nComponent $n
 * @property SessionComponent $Session
 */
class VendorcontactsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'N', 'Session');

}
