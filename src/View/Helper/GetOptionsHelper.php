<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

class GetOptionsHelper extends Helper
{
    public function getVillageOptions(){
        $villageQuery = TableRegistry::get('Villages', ['className' => 'App\Model\Table\VillagesTable']);
        $villages = $villageQuery->find()->all();
        $villageOptions = [];
        foreach ($villages as $key => $village) {
            $villageOptions[$village->get('id')] = $village->get('name');
        }
        return $villageOptions;
    }

    public function getSeasonOptions(){
        $seasonQuery = TableRegistry::get('Seasons', ['className' => 'App\Model\Table\SeasonsTable']);
        $seasons = $seasonQuery->find('all', ['order'=>'Seasons.id DESC'])->all();
        $seasonOptions = [];
        foreach ($seasons as $key => $season) {
            $seasonOptions[$season->get('id')] = $season->get('name');
        }
        return $seasonOptions;
    }

    public function get($entity){
        $query = TableRegistry::get($entity);
        $rows = $query->find('all')->all();
        $options = [];
        foreach ($rows as $key => $row) {
            $options[$row->get('id')] = $row->get('name');
        }
        return $options;
    }
}