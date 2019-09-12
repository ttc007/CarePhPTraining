<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

/**
 * 
 */
class SeasonService
{
	var $seasonRepository;
	var $ward_id;

	function __construct($ward_id)
	{
		$this->seasonRepository = TableRegistry::get('Seasons', ['className' => 'App\Model\Table\SeasonsTable']);
		$this->ward_id = $ward_id;
	}

	function findByOne($conditions, $orders){
		return $this->seasonRepository->find()->where($conditions)->order($orders)->first();
	}
}