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

    public function initialize()
    {
        $this->loadComponent('Paginator');
        parent::initialize();
        $this->farmerFertilizersQuery = TableRegistry::get('FarmerFertilizers', ['className' => 'App\Model\Table\FarmerFertilizersTable']);
        $this->seasonQuery = TableRegistry::get('Seasons', ['className' => 'App\Model\Table\SeasonsTable']);
        $this->batchQuery = TableRegistry::get('Batchs', ['className' => 'App\Model\Table\BatchsTable']);
        $this->fertilizerQuery = TableRegistry::get('Fertilizers', ['className' => 'App\Model\Table\FertilizersTable']);
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Nông hộ';
        parent::beforeFilter($event);
    }
    
    public function index()
    {
        if ($this->request->is('post')) {
            $village_id = $this->request->getData()['village_id'];
            $season_id = $this->request->getData()['season_id'];
        } else {
            $villageQuery = TableRegistry::get('Villages', ['className' => 'App\Model\Table\VillagesTable']);
            
            $village_id = $villageQuery->find()->first()->id;
            $season_id = $this->seasonQuery->find('all', ['order'=>'Seasons.id DESC'])->first()->id;
        }
        $batchQuery = TableRegistry::get('Batchs', ['className' => 'App\Model\Table\BatchsTable']);
        $batchs = $batchQuery->find()->where(['season_id ='=> $season_id])->all();
        $farmerFertilizersQuery = TableRegistry::get('FarmerFertilizers', ['className' => 'App\Model\Table\FarmerFertilizersTable']);

        $farmers = $this->Farmers->find()->where(['village_id ='=> $village_id]);
        $farmers = $this->Paginator->paginate($farmers);
        foreach ($farmers as $farmer) {
            $farmer->batchs = [];
            foreach ($batchs as $batch) {
                $farmer->batchs[$batch->id] = $this->farmerFertilizersQuery->find()->where([
                                                            'farmer_id =' => $farmer->id,
                                                            'batch_id =' => $batch->id ])->all();
            }
        }
        
        $this->set(compact('farmers', 'batchs'));
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
            $this->Flash->error(__('Unable to add your FarmerFertilizers.'));
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
            $this->Flash->error(__('Unable to update your FarmerFertilizers.'));
        }
        $this->set(compact('farmer'));
    }

    public function addFarmerFertilizer($farmer_id, $batch_id){
        $data = $this->request->getData();
        $farmerFertilizer = $this->farmerFertilizersQuery->newEntity();
        $farmerFertilizer->farmer_id = $farmer_id;
        $farmerFertilizer->batch_id = $batch_id;

        $batch = $this->batchQuery->findById($batch_id)->first();
        $farmerFertilizer->season = $this->seasonQuery->findById($batch->season_id)->first();

        $farmer = $this->Farmers->findById($farmer_id)->first();

        $farmerFertilizers = $this->farmerFertilizersQuery->find()->where([
                                            'farmer_id =' => $farmer->id,
                                            'batch_id =' => $batch_id ])->all();
        $this->set(compact('farmerFertilizer', 'farmer', 'farmerFertilizers'));
    }

    public function allocationFertilizer() {
        $dataSubmit = $this->request->getData()['dataSubmit'];
        $farmer_id = $this->request->getData()['farmer_id'];
        $batch_id = $this->request->getData()['batch_id'];

        $this->farmerFertilizersQuery->deleteAll([
            'FarmerFertilizers.farmer_id' => $farmer_id,
            'FarmerFertilizers.batch_id' => $batch_id 
        ]);
        foreach ($dataSubmit as $key => $rowData) {
            $farmerFertilizer = $this->farmerFertilizersQuery->newEntity();
            $farmerFertilizer = $this->farmerFertilizersQuery->patchEntity($farmerFertilizer, $rowData);
            $fertilizer = $this->fertilizerQuery->findById($rowData['fertilizer_id'])->first();
            $farmerFertilizer->price = $fertilizer->price;
            $this->farmerFertilizersQuery->save($farmerFertilizer);
        }
    }
}
