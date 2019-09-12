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

use App\Service\FarmerFertilizerService;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class FarmerFertilizersController extends AppController
{   
    var $farmerFertilizerService;

    public function initialize()
    {
        $this->loadComponent('Paginator');
        parent::initialize();

        $this->farmerFertilizerService = new FarmerFertilizerService($this->ward_id);
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Phân bón';
        parent::beforeFilter($event);
    }
    public function index()
    {
        $fertilizers = $this->Paginator->paginate($this->Fertilizers->find()->where(['ward_id' => $this->ward_id]));
        $this->set(compact('fertilizers'));
    }

    public function add($farmer_id, $batch_id){
        $farmerFertilizer = $this->farmerFertilizerService->newEntity();
        $farmerFertilizer->farmer_id = $farmer_id;
        $farmerFertilizer->batch_id = $batch_id;

        $batch = $this->farmerFertilizerService->getBatch($batch_id);
        $farmerFertilizer->season = $this->farmerFertilizerService->getSeason($batch->season_id);

        $farmer = $this->farmerFertilizerService->getFarmer($farmer_id);

        $farmerFertilizers = $this->farmerFertilizerService->getListFarmerFertilizer(['farmer_id =' => $farmer->id,'batch_id =' => $batch_id ]);

        $this->set(compact('farmerFertilizer', 'farmer', 'farmerFertilizers', 'batch'));
    }

    public function allocationFertilizer() {
        $data = $this->request->getData();
        $this->farmerFertilizerService->allocationFertilizer($data);
    }

    
}
