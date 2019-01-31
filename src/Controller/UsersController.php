<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
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
        $id = $this->Auth->user('id');
        // $id = $this->request->getSession()->read('Auth.User.id');
        if(!is_null($id)){
            $user = $this->Users->get($id, ['contain' => ['Tasks','Tasks.Articles']]);
            $Article = TableRegistry::getTableLocator()->get('Articles');
            $articles=$Article->find('all',['contain' => ['Tasks','Tasks.Articles']]);


            // $Task = TableRegistry::getTableLocator()->get('Tasks');
            // $tasks = $this->Task->get($id);
        } else {
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
        // $user = $this->Auth->identify();
        // if(!$user)
            $this->Auth->allow(['logout', 'add', 'view', 'edit']);
            // $this->Auth->deny(['view', 'edit','index']);
    }

    function isAuthorized($user) {
    // Все зарегистрированные пользователи могут добавлять статьи
    // До 3.4.0 $this->request->param('action') делали так.
    if ($this->request->getParam('action') === 'view/'.$user['id']) {
        return true;
    }

    // // Владелец статьи может редактировать и удалять ее
    // // До 3.4.0 $this->request->param('action') делали так.
    // if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
    //     // До 3.4.0 $this->request->params('pass.0') делали так.
    //     $articleId = (int)$this->request->getParam('pass.0');
    //     if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
    //         return true;
    //     }
    // }

    return parent::isAuthorized($user);
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
}
