<?php

App::uses('AppController', 'Controller');

/**
 * Vendorclients Controller
 *
 * @property Vendorclient $Vendorclient
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class VendorclientsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

}
