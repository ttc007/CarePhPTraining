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
class SeasonsController extends AppController
{

    public function initialize()
    {
        $this->loadComponent('Paginator');
        parent::initialize();
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Mùa vụ';
        parent::beforeFilter($event);
    }
    public function index()
    {
        $seasons = $this->Paginator->paginate($this->Seasons->find());
        $this->set(compact('seasons'));
    }

    public function add()
    {
        $season = $this->Seasons->newEntity();
        if ($this->request->is('post')) {
            $season = $this->Seasons->patchEntity($season, $this->request->getData());
             
            if ($this->Seasons->save($season)) {
                $this->Flash->success(__('Your season has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your blog.'));
        }
        $this->set(compact('season'));
    }

    public function edit($id)
    {
        $season = $this->Seasons->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Seasons->patchEntity($season, $this->request->getData());
            if ($this->Seasons->save($season)) {
                $this->Flash->success(__('Your season has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your blog.'));
        }
        $this->set(compact('season'));
    }
}
