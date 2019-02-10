<?php

namespace App\Controller\Admin;
use App\Controller\AppController;

use Cake\Event\Event;

class AdminController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        $this->Auth->authorize = array('Controller'); 

        if(!$this->Auth->isAuthorized()){
            $this->redirect(array('controller'=>'/','action'=>'index', 'prefix'=>false));
        } 
    }

    public function index()
    {
        $this->set('title', 'Welcome to Admin Panel');
    }
}