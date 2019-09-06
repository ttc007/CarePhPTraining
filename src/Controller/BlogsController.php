<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class BlogsController extends AppController
{

    public function initialize()
    {
        $this->loadComponent('Paginator');
        parent::initialize();
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Tin tức';
        parent::beforeFilter($event);
    }
    public function index()
    {
        $blogs = $this->Paginator->paginate($this->Blogs->find());
        $this->set(compact('blogs'));
    }

    public function add()
    {
        $blog = $this->Blogs->newEntity();
        if ($this->request->is('post')) {
            $blog = $this->Blogs->patchEntity($blog, $this->request->getData());
            $blog->user_id = 1;
             
            if ($this->Blogs->save($blog)) {
                $this->Flash->success(__('Your blog has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your blog.'));
        }
        $this->set('blog', $blog);
    }

    public function edit($id)
    {
        $blog = $this->Blogs->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Blogs->patchEntity($blog, $this->request->getData());
            if ($this->Blogs->save($blog)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your blog.'));
        }
     
        $this->set('blog', $blog);
    }
}
