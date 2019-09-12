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
use Cake\Event\Event;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class GroupsController extends AppController
{
    public function initialize()
    {
        $this->loadComponent('Paginator');
        $this->loadComponent('Pagematron');

        parent::initialize();
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Tổ';
        parent::beforeFilter($event);
    }
    
    public function index()
    {
        $this->Pagematron->adjust();
        $groups = $this->Groups->find()->where(['ward_id' => $this->ward_id])->order(['village_id'=>'ASC']);
        $groups = $this->paginate($groups);
        $this->set(compact('groups'));
    }

    public function add()
    {
        $group = $this->Groups->newEntity();
        if ($this->request->is('post')) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            $group->ward_id = $this->ward_id;
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('Thông tin tổ đã được lưu'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your blog.'));
        }
        $this->set(compact('group'));
    }

    public function edit($id)
    {
        $group = $this->Groups->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('Thông tin tổ đã được cập nhật'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your blog.'));
        }
        $this->set(compact('group'));
    }
}
