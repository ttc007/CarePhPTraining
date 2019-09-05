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
class FarmersController extends AppController
{

    public function initialize()
    {
        $this->loadComponent('Paginator');
        parent::initialize();
    }
    
    public function index()
    {
        $farmers = $this->Paginator->paginate($this->Farmers->find());
        $this->set(compact('farmers'));
    }

    public function add()
    {
        $farmer = $this->Farmers->newEntity();
        if ($this->request->is('post')) {
            $farmer = $this->Farmers->patchEntity($farmer, $this->request->getData());
             
            if ($this->Farmers->save($farmer)) {
                $this->Flash->success(__('Your farmer has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your blog.'));
        }
        $this->set(compact('farmer'));
    }

    public function edit($id)
    {
        $farmer = $this->Farmers->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $farmer = $this->Farmers->patchEntity($farmer, $this->request->getData());
            if ($this->Farmers->save($farmer)) {
                $this->Flash->success(__('Your farmer has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your blog.'));
        }
        $this->set(compact('farmer'));
    }
}
