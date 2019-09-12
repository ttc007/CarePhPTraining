<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

/**
 * 
 */
class BatchService
{
	var $batchRepository;

	function __construct($ward_id)
	{
		$this->ward_id = $ward_id;
		$this->batchRepository = TableRegistry::get('Batchs', ['className' => 'App\Model\Table\BatchsTable']);
	}

	function lockFarmerFertilizer($id, $isLock){
		$batch = $this->batchRepository->findById($id)->first();
		$batch->isLock = $isLock;
		$this->batchRepository->save($batch);
	}
}