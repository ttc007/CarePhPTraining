<?php
namespace App\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\View\Helper;

class GetNameEntityHelper extends Helper{
    public function getVillageName($village_id){
    	$villageQuery = TableRegistry::get('Villages', ['className' => 'App\Model\Table\VillagesTable']);
        $village = $villageQuery->findById($village_id)->first();
        return $village->get('name');
    }

    public function getSeasonName($season_id){
    	$seasonQuery = TableRegistry::get('Seasons', ['className' => 'App\Model\Table\SeasonsTable']);
        $season = $seasonQuery->findById($season_id)->first();
        return $season->get('name');
    }
}