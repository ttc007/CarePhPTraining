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

use App\Service\ChargeService;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ChargesController extends AppController
{
    var $chargeService;

    public function initialize()
    {
        parent::initialize();
        $this->chargeService = new ChargeService($this->ward_id);
    }
    public function beforeFilter(Event $event)
    {
        $this->titleController = 'Tính tiền';
        parent::beforeFilter($event);
    }
    
    public function index(){
        
    }

    public function chargeWard($season_id){
        $villages = $this->chargeService->getVillageList(['ward_id' => $this->ward_id]);
        if ($this->request->is('post')) {
            $season_id = $this->request->getData()['season_id'];
        }
        $batchs = $this->chargeService->getBatchList(['season_id =' => $season_id]);;
        $this->chargeService->setBatchVillages($villages, $batchs);
        $ward = $this->chargeService->getWard($this->ward_id);
        $this->set(compact('season_id', 'villages', 'batchs', 'ward'));
    }

    public function chargeFarmer($farmer_id, $season_id){
        $farmer = $this->chargeService->getFarmer($farmer_id);
        $batchs = $this->chargeService->getBatchList(['season_id =' => $season_id]);
        $farmer->batchs = [];
        $this->chargeService->setBatchFarmer($farmer, $batchs);
        $season = $this->chargeService->getSeason($season_id);
        $this->set(compact('farmer', 'batchs', 'season'));
    }
}
