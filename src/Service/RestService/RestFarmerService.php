<?php
namespace App\Service\RestService;

use Cake\ORM\TableRegistry;

/**
 * 
 */
class RestFarmerService
{
	var $farmerRepository;
	var $batchRepository;
	var $farmerFertilizersRepository;
	var $villageRepository;
	var $groupRepository;
	var $fertilizerRepository;

	function __construct(){
		$this->farmerRepository = TableRegistry::get('Farmers', ['className' => 'App\Model\Table\FarmersTable']);
		$this->batchRepository = TableRegistry::get('Batchs', ['className' => 'App\Model\Table\BatchsTable']);
		$this->farmerFertilizersRepository = TableRegistry::get('FarmerFertilizers', ['className' => 'App\Model\Table\FarmerFertilizersTable']);
		$this->villageRepository = TableRegistry::get('Villages', ['className' => 'App\Model\Table\VillagesTable']);
		$this->groupRepository = TableRegistry::get('Groups', ['className' => 'App\Model\Table\GroupsTable']);
		$this->fertilizerRepository = TableRegistry::get('Fertilizers', ['className' => 'App\Model\Table\FertilizersTable']);

	}

	function filterFarmers($data){
		$conditions = [
			'ward_id' => $data['ward_id'],
			'village_id' => $data['village_id'],
		];
		if($data['group_id']) $conditions['group_id'] = $data['group_id'];
		$farmers = $this->farmerRepository->find()->where($conditions)->order(['group_id' => 'ASC'])->all();
		$batchs = $this->setBatchFarmers($farmers, $data['season_id']);
		return ['farmers' => $farmers, 'batchs' => $batchs];
	}

	function setBatchFarmers($farmers, $season_id){
		$batchs = $this->batchRepository->find()->where(['season_id' => $season_id])->all();
		foreach ($farmers as $farmer) {
			if($farmer->group_id) $farmer->group = $this->groupRepository->findById($farmer->group_id)->first();
			if($farmer->village_id) $farmer->village = $this->villageRepository->findById($farmer->village_id)->first();
			$farmer->batchs = [];
            foreach ($batchs as $batch) {
            	$conditions = [
            		'farmer_id =' => $farmer->id,
                    'batch_id =' => $batch->id
            	];
                
                $data = $this->farmerFertilizersRepository->find()->where($conditions)->all();
                foreach ($data as $farmerFertilizer) {
                	$farmerFertilizer->fertilizer = $this->fertilizerRepository->findById($farmerFertilizer->fertilizer_id)->first();
                }
                $batchData = [
                	'batch' => $batch,
                	'data' => $data
                ];
                $farmer->batchs[$batch->id] = $batchData;
            }
		}
		return $batchs;
	}
}