<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

/**
 * 
 */
class FarmerFertilizerService
{
	var $farmerFertilizerRepository;
	var $batchRepository;
	var $seasonRepository;
	var $farmerRepository;
	var $fertilizerRepository;

	var $ward_id;

	function __construct($ward_id)
	{
		$this->farmerFertilizerRepository = TableRegistry::get('FarmerFertilizers', ['className' => 'App\Model\Table\FarmerFertilizersTable']);
		$this->batchRepository = TableRegistry::get('Batchs', ['className' => 'App\Model\Table\BatchsTable']);
		$this->seasonRepository = TableRegistry::get('Seasons', ['className' => 'App\Model\Table\SeasonsTable']);
		$this->farmerRepository = TableRegistry::get('Farmers', ['className' => 'App\Model\Table\FarmersTable']);
		$this->fertilizerRepository = TableRegistry::get('Fertilizers', ['className' => 'App\Model\Table\FertilizersTable']);


		$this->ward_id = $ward_id;
	}

	function newEntity(){
		return $this->farmerFertilizerRepository->newEntity();
	}

	function getBatch($id){
		return $this->batchRepository->findById($id)->first();
	}

	function getSeason($id){
		return $this->seasonRepository->findById($id)->first();
	}

	function getFarmer($id){
		return $this->farmerRepository->findById($id)->first();
	}

	function getListFarmerFertilizer($conditions){
		return $this->farmerFertilizerRepository->find()->where($conditions)->all();
	}

	function allocationFertilizer($data){
		$dataSubmit = $data['dataSubmit'];
        $farmer_id = $data['farmer_id'];
        $batch_id = $data['batch_id'];

        $batch = $this->getBatch($batch_id);
        $farmer = $this->getFarmer($farmer_id);

        $this->farmerFertilizerRepository->deleteAll([
            'FarmerFertilizers.farmer_id' => $farmer_id,
            'FarmerFertilizers.batch_id' => $batch_id 
        ]);
        foreach ($dataSubmit as $key => $rowData) {
            $farmerFertilizer = $this->farmerFertilizerRepository->newEntity();
            $farmerFertilizer = $this->farmerFertilizerRepository->patchEntity($farmerFertilizer, $rowData);
            $fertilizer = $this->fertilizerRepository->findById($rowData['fertilizer_id'])->first();
            $farmerFertilizer->price = $fertilizer->price;
            $farmerFertilizer->unit = $fertilizer->unit;
            $farmerFertilizer->village_id = $farmer->village_id;
            $farmerFertilizer->total = $fertilizer->price*$rowData['quantity'];
            $farmerFertilizer->season_id = $batch->season_id;

            $this->farmerFertilizerRepository->save($farmerFertilizer);
        }
	}
}