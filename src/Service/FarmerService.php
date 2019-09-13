<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

/**
 * 
 */
class FarmerService
{
	var $farmerRepository;
	var $batchRepository;
	var $seasonRepository;
	var $villageRepository;
	var $farmerFertilizersRepository;
	var $ward_id;

	function __construct($ward_id)
	{
		$this->ward_id = $ward_id;

		$this->farmerRepository = TableRegistry::get('Farmers', ['className' => 'App\Model\Table\FarmersTable']);
		$this->batchRepository = TableRegistry::get('Batchs', ['className' => 'App\Model\Table\BatchsTable']);
		$this->seasonRepository = TableRegistry::get('Seasons', ['className' => 'App\Model\Table\SeasonsTable']);
		$this->villageRepository = TableRegistry::get('Villages', ['className' => 'App\Model\Table\VillagesTable']);
		$this->farmerFertilizersRepository = TableRegistry::get('FarmerFertilizers', ['className' => 'App\Model\Table\FarmerFertilizersTable']);
	}

	function getBatchs($season_id){
		return $this->batchRepository->find()->where(['season_id ='=> $season_id])->all();
	}

	function getFarmers($conditions){
		
        $farmers = $this->farmerRepository->find()->where($conditions)->order(['group_id'=>'ASC']);
        return $farmers;
	}

	function setBatchFarmers($farmers, $batchs){
		foreach ($farmers as $farmer) {
            $farmer->batchs = [];
            foreach ($batchs as $batch) {
                $batchFarmer = $this->farmerFertilizersRepository
                                ->find()
                                ->where(['farmer_id =' => $farmer->id,
                                 'batch_id =' => $batch->id])
                                ->all();
                $farmer->batchs[$batch->id] = $batchFarmer;
            }
        }
	}

	function getDataPostIndex($request){
		$data = $request->getData();
        if(isset($request->getData()['group_id'])){
        	$data['group_id'] = $request->getData()['group_id'];
        } else {
        	$data['group_id'] = "";
        }
        
        $session = $request->getSession();
        $session->write('Season.id', $data['season_id']);
        $session->write('Village.id', $data['village_id']);
        $session->write('Group.id', $data['group_id']);
		return $data;
	}

	function getDataGetIndex($request){
        $session = $request->getSession();
		if($session->read('Season.id')){
            $season_id = $session->read('Season.id');
        } else {
            $season_id = $this->seasonRepository->find()->where(['ward_id'=>$this->ward_id])->order(['id'=>' DESC'])->first()->id;
        }
        
        if($session->read('Village.id')){
            $village_id = $session->read('Village.id');
        } else {
            $village_id = $this->villageRepository->find()->where(['ward_id' => $this->ward_id])->first()->id;
        }

        if($session->read('Group.id')){
            $group_id = $session->read('Group.id');
        } else {
            $group_id = "";
        }

        $data = [
        	'season_id' => $season_id,
        	'village_id' => $village_id,
        	'group_id' => $group_id
        ];
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

	function newEntity(){
		return $this->farmerRepository->newEntity();
	}

	function saveFarmer($data, $farmer){
		$farmer = $this->farmerRepository->patchEntity($farmer, $data);
        $farmer->ward_id = $this->ward_id;
        $this->farmerRepository->save($farmer);
	}

	function getFarmerById($id){
		return $this->farmerRepository->findById($id)->first();
	}
}