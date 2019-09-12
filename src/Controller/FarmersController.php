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
use Cake\ORM\TableRegistry;
use App\Http\Session\ComboSession;

use Cake\Log\Log;

use App\Service\FarmerService;
use App\Service\SeasonService;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class FarmersController extends AppController
{
    var $farmerFertilizersQuery;
    var $seasonQuery;
    var $batchQuery;
    var $fertilizerQuery;
    var $villageQuery;
    var $wardQuery;

    var $farmerService;

    public function initialize()
    {
        parent::initialize();
        $this->farmerService = new FarmerService($this->ward_id);
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Nông hộ';
        parent::beforeFilter($event);
    }
    
    public function index()
    {
        $this->Pagematron->adjust();
        if ($this->request->is('post')) {
            $data = $this->farmerService->getDataPostIndex($this->request);
        } else {
            $data = $this->farmerService->getDataGetIndex($this->request);
        }
        $batchs = $this->farmerService->getBatchs($data['season_id']);
        $conditions = $this->farmerService->getConditionsFarmer($data);
        $farmers = $this->farmerService->getFarmers($conditions);
        $farmers = $this->paginate($farmers);
        $this->farmerService->setBatchFarmers($farmers, $batchs);

        $this->set(compact('farmers', 'batchs'));
        $this->set($data);
    }

    public function add()
    {
        $farmer = $this->farmerService->newEntity();
        if ($this->request->is('post')) {
            $this->farmerService->saveFarmer($this->request->getData());
            $this->Flash->success(__('Thông tin nông hộ đã được lưu'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('farmer'));
    }

    public function edit($id)
    {
        $farmer = $this->farmerService->getFarmerById($id);
        if ($this->request->is(['post', 'put'])) {
            $this->farmerService->saveFarmer($this->request->getData());
            $farmer = $this->Farmers->patchEntity($farmer, $this->request->getData());
            $this->Flash->success(__('Thông tin nông hộ đã được cập nhật'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('farmer'));
    }
}
