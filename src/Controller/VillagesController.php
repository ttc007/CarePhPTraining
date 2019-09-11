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
class VillagesController extends AppController
{
    public function initialize()
    {
        $this->loadComponent('Paginator');
        parent::initialize();
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Khu/thôn';
        parent::beforeFilter($event);
    }
    
    public function index()
    {
        $villages = $this->Villages->find()->where(['ward_id' => $this->ward_id])->all();
        $this->set(compact('villages'));
    }

    public function add()
    {
        $village = $this->Villages->newEntity();
        if ($this->request->is('post')) {
            $village = $this->Villages->patchEntity($village, $this->request->getData());
            $village->ward_id = $this->ward_id;
            if ($this->Villages->save($village)) {
                $this->Flash->success(__('Thông tin thôn/khu đã được lưu'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your blog.'));
        }
        $this->set(compact('village'));
    }

    public function edit($id)
    {
        $village = $this->Villages->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Villages->patchEntity($village, $this->request->getData());
            if ($this->Villages->save($village)) {
                $this->Flash->success(__('Thông tin thôn/khu đã được cập nhật'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your blog.'));
        }
        $this->set(compact('village'));
    }
}
