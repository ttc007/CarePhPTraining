<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

/**
 * 
 */
class ChargeService
{
	var $ward_id;
	var $seasonRepository;
	var $batchRepository;
	var $farmerRepository;
	var $farmerFertilizersRepository;
	var $wardRepository;

	function __construct($ward_id)
	{
		$this->ward_id = $ward_id;
		$this->seasonRepository = TableRegistry::get('Seasons', ['className' => 'App\Model\Table\SeasonsTable']);
		$this->villageRepository = TableRegistry::get('Villages', ['className' => 'App\Model\Table\VillagesTable']);
		$this->batchRepository = TableRegistry::get('Batchs', ['className' => 'App\Model\Table\BatchsTable']);
		$this->farmerRepository = TableRegistry::get('Farmers', ['className' => 'App\Model\Table\FarmersTable']);
		$this->farmerFertilizersRepository = TableRegistry::get('FarmerFertilizers', ['className' => 'App\Model\Table\FarmerFertilizersTable']);
		$this->wardRepository = TableRegistry::get('Wards', ['className' => 'App\Model\Table\WardsTable']);
	}

	function getSeason($id){
		return $this->seasonRepository->findById($id)->first();
	}

	function getBatchList($conditions){
		return $this->batchRepository->find()->where($conditions)->all();
	}

	function getFarmerList($conditions, $order){
		return $this->farmerRepository->find()->where($conditions)->order($order);
	}

	function setBatchFarmers($farmers, $batchs){
		foreach ($farmers as $farmer) {
            $farmer->batchs = [];
            foreach ($batchs as $batch) {
            	$batchFarmer = $this->farmerFertilizersRepository
                	->find()
                    ->where([
                    	'farmer_id =' => $farmer->id,
                		'batch_id =' => $batch->id
                    ])->all();
                $farmer->batchs[$batch->id] = $batchFarmer;
            }
        }
	}

	function getDataForIndex($request){
		$data = [];
        $session = $request->getSession();

		if ($request->is('post')) {
			$data = $request->getData();
			if(isset($request->getData()['group_id'])){
	        	$data['group_id'] = $request->getData()['group_id'];
	        } else {
	        	$data['group_id'] = "";
	        }
	        
	        $session->write('Charge.Season.id', $data['season_id']);
	        $session->write('Charge.Village.id', $data['village_id']);
	        $session->write('Charge.Group.id', $data['group_id']);
        } else {
            if($session->read('Charge.Season.id')){
            	$season_id = $session->read('Season.id');
	        } else {
	            $season_id = $this->seasonRepository->find()->where(['ward_id'=>$this->ward_id])->order(['id'=>' DESC'])->first()->id;
	        }
	        if($session->read('Charge.Village.id')){
	            $village_id = $session->read('Village.id');
	        } else {
	            $village_id = $this->villageRepository->find()->where(['ward_id' => $this->ward_id])->first()->id;
	        }
	        if($session->read('Charge.Group.id')){
	            $group_id = $session->read('Group.id');
	        } else {
	            $group_id = "";
	        }
	        $data = [
	        	'season_id' => $season_id,
	        	'village_id' => $village_id,
	        	'group_id' => $group_id
	        ];
        }
    	return $data;
	}

	function getConditionsFarmer($data){
		$conditions = [];
		if($data['group_id'] != ""){
            $conditions['group_id = '] = $data['group_id'];
        }
        $conditions['village_id = '] = $data['village_id'];
        return $conditions;
	}

	function getVillageList($conditions){
		return $this->villageRepository->find()->where($conditions)->all();
	}

	function getWard($id){
		return $this->wardRepository->findById($id)->first();
	}

	function setBatchVillages($villages, $batchs){
		foreach ($villages as $village) {
            $village->totalBatchs = [];
            foreach ($batchs as $batch) {
                $query = $this->farmerFertilizersRepository->find('all',
                    [
                        'conditions' => [
                            'FarmerFertilizers.batch_id' => $batch->id,
                            'FarmerFertilizers.village_id' => $village->id
                        ]
                    ]
                );
                $query->select(['total' => $query->func()->sum('total')]);

                $village->totalBatchs[$batch->id] = $query->first();
            }
        }
	}

	function getFarmer($id){
		return $this->farmerRepository->findById($id)->first();
	}

	function setBatchFarmer($farmer, $batchs){
		foreach ($batchs as $batch) {
			$batchFarmer = $this->farmerFertilizersRepository->find()
                ->where([
                    'farmer_id' => $farmer->id, 
                    'batch_id' => $batch->id
            ])->all();
            $farmer->batchs[$batch->id] = $batchFarmer;
        }
	}
}