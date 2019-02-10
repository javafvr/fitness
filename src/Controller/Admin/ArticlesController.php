<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Hashids\Hashids;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class ArticlesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if(!$this->Auth->isAuthorized()){
            $this->redirect(array('controller'=>'/','action'=>'index', 'prefix'=>false));
        } 
    }

    public function index()
    {
        $articles = $this->paginate($this->Articles);
        $this->set('title', 'Статьи - Администратор');
        $this->set(compact('articles'));
        $this->set('_serialize', ['article']);
    }

    /**
     *  Add New Article
     */
    public function add()
    {
        $this->set('title', 'Add Article');

        /** 
         *  Insert Articles
         */
        $article = $this->Article->newEntity();

        // check post request and data
         if($this->request->is('post') AND !empty($this->request->getData()) )
        {
            
            $article = $this->Article->patchEntity($article, $this->request->getData(), [
                'validate' => true
            ]);

            // insert user id in article id
            $article->user_id = $this->Auth->user('id'); // $this->request->session()->read('Auth.User.id')
                
            if($article->errors())
            {
                // Form Validation TRUE
                $this->Flash->error('Please Fill required fields');
            }else
            {
                // Form Validation FALSE
                if($this->Article->save($article))
                {
                    $this->redirect('/admin/article/add');
                    $this->Flash->success('Article Add Successfully');
                }else{
                    $this->Flash->error(__('Unable to add your article!'));
                }
            }
        }
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    /**
     *  Manage User Articles
     */
    public function manage()
    {
        $this->set('title', 'Manage Article');
        // Fetch Articles
        $articles = $this->Article->find('all');
        // $articles->hydrate(false);
        $articles->select(['article.id','article.title','article.body','article.created','article.modified']);
        $articles->select(['user.id','user.name','user.email','user.role']);
        $articles->join([
            'table' => 'users',
            'alias' => 'user',
            'type' => 'INNER',
            'conditions' => 'user.id = article.user_id',
        ]);
        $this->set(compact('articles'));
    }

    /**
     *  Edit Article
     */
    public function edit($eid = null)
    {
        // set title
        $this->set('title', 'Edit Article');
        $Article = TableRegistry::get('Article');
        /**
         *  Set Hashids Configure and DecodeHex
         */
        $hashids = new Hashids(Configure::read('Hashid.key'), Configure::read('Hashid.length'), Configure::read('Hashid.characters'));
        $id = $hashids->decodeHex($eid);

        // get article
        $article = $Article->get($id);

        // update article
        if($this->request->is('put') AND !empty($this->request->getData()))
        {
            $article->accessible('user_id', FALSE);
            $article->accessible('id', FALSE);

            $update_article = $Article->patchEntity($article, $this->request->getData(), [
                'validate' => 'update_article'
            ]);
            
            $update_article->title  = $this->request->getData('title');
            $update_article->body   = $this->request->getData('body');
            
            // check validation errors
            if($update_article->errors())
            {
                $this->Flash->error(__('Please Fill required fields'));
            }else{
                // Form Validation FALSE
                if($Article->save($update_article))
                {
                    // update success
                    $this->Flash->success(__('Your Article has been Updated.'));
                    // $this->redirect('/admin/article/edit/'.$eid);
                }else{
                    // update server error
                    $this->Flash->error(__('Unable to update article!'));
                }
            }
        }

        // set data in template
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    /**
     *  Delete Article
     */
    public function delete($eid = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $Article = TableRegistry::get('Article');
        /**
         *  Set Hashids Configure and DecodeHex
         */
        $hashids = new Hashids(Configure::read('Hashid.key'), Configure::read('Hashid.length'), Configure::read('Hashid.characters'));
        $id = $hashids->decodeHex($eid);

        // get article
        $article = $Article->get($id);

        if ($Article->delete($article)) 
        {
            $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
            return $this->redirect('/admin/article/manage');
        }
    }
}
