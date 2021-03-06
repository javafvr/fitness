<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
use WyriHaximus\TwigView\Lib\Twig\Extension\Number;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    var $uses = array('Task');

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        // $this->Auth->authorize = array('Controller'); 
        $this->set('loggedIn', $this->Auth->user());
        if(!$this->Auth->isAuthorized()){
            //$this->redirect(array('controller'=>'users','action'=>'login', 'prefix'=>false));
        }
    }
       
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Parameters']
        ];
        $users = $this->paginate($this->Users);
        
        $this->set(compact('users'));
    }
    
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user_id = $this->Auth->user('id');


        if(!is_null($id) ){
            if($user_id===(Int)$id){
                $user = $this->Users->get($id, ['contain' => ['Tasks','Tasks.Articles']]);
                $Article = TableRegistry::getTableLocator()->get('Articles');
                $articles=$Article->find('all',['contain' => ['Tasks','Tasks.Articles']]);
            } else{
                return $this->redirect(['action' => 'view/'.$user_id]);    
            }
        } else{
            $this->Flash->error(__('Доступ запрещен! Войдите в систему!'));
            return $this->redirect(['action' => 'login']);
        }
        
        $this->set(compact('user', 'articles'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view/'.$user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $parameters = $this->Users->Parameters->find('list', ['limit' => 200]);
        $this->set(compact('user', 'parameters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Parameters']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view/'.$user->id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        // $parameters = $this->Users->Parameters->find('list', ['limit' => 200]);
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                // return $this->redirect($this->Auth->redirectUrl());
                return $this->redirect(['action' => 'view/'.$user['id']]);
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function initialize()
    {
        parent::initialize();
        
        //$id = $this->Auth->user('id');
        //$this->Auth->allow(['logout', 'add', 'view/'.$id, 'edit']);
    }

    // function isAuthorized($user) {

    //     // Все зарегистрированные пользователи могут просматривать свой профиль
    //     if ($user['id']) {
    //         return true;
    //     }

    //     return parent::isAuthorized($user);
    // }  



    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
}
