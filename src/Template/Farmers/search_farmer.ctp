<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = false;
$this->extend('/Layout/default');

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';

?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $cakeDescription ?>
        </title>

        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('style.css') ?>
        <?= $this->Html->css('home.css') ?>
        <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
        <style type="text/css">
            .container{
                max-width: 1300px;
            }
        </style>
    </head>
    <body class="home">
        <?php echo $this->Form->create( null ,['class'=>'form-filter']); ?>
            <div class="row">
                <div class="col-md-4">
                    <?php
                        echo $this->Form->control('season_id', ['type' => 'select','options'=>$this->GetOptions->get('Seasons'), 'label' => 'Mùa vụ'
                            ,'value' => $season_id]);
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                        echo $this->Form->control('village_id', ['type' => 'select','options'=>$this->GetOptions->get('Villages'), 'label'=> 'Khu/thôn'
                            ,'value' => $village_id]);
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                        echo $this->Form->button(__('Lọc') , ['class'=>'btn-filter']);
                    ?>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
        <div class="row">
            <div class="w-100">
                <div class="pull-left">
                    <?php
                        echo $this->Form->create('', ['action' => 'searchFarmer', 'class' => 'form-search']);
                        echo $this->Form->control('key', ['placeholder' => 'Nhập tên nông hộ muốn tìm kiếm', 'class'=>'search-input', 'label'=>'']);
                        echo $this->Form->end();
                    ?>
                </div>
                <div class="pull-right">
                    <?= $this->Html->link('', ['action' => 'charge'], ['class'=> 'hidden', 'id' => 'urlCharge']) ;   ?>
                    <a class="charge" onclick="charge()">Tính tiền</a>
                </div>
            </div>
            <table class="table table-bordered table-striped" id='table-farmer'>
                <tr>
                    <th style="width: 50px">STT</th>
                    <th>Nông hộ</th>
                    <?php foreach ($batchs as $batch) : ?>
                        <th>
                            <?= $batch->name ?> (<?= $batch->date_provide ?>)
                            <?php if($batch->isLock) {?> 
                                <?= $this->Html->link("Mở sổ", ['action' => 'lockFarmerFertilizer', $batch->id, 0], ['class' => 'lock-farmer-fertilizer']) ?>
                            <?php } else { ?>
                                <?= $this->Html->link("Khóa sổ", ['action' => 'lockFarmerFertilizer', $batch->id, 1], ['class' => ' lock-farmer-fertilizer']) ?>
                            <?php } ?>
                        </th>
                    <?php endforeach ?>
                </tr>
                <?php foreach ($farmers as $key => $farmer): ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td>
                            <?= $this->Html->link($farmer->name, ['action' => 'edit', $farmer->id], ['class'=>'farmer-name']) ?><br>
                            Mã số: <?= $this->Html->link($farmer->id, ['action' => 'edit', $farmer->id]) ?><br>
                            Số điện thoại: <?= $farmer->phone ?><br>
                            Khu/thôn: <?= $this->GetNameEntity->getVillageName($farmer->village_id) ?>
                        </td>
                        <?php foreach ($batchs as $batch) : ?>
                            <td>
                                <?php foreach ($farmer->batchs[$batch->id] as $farmerFertilizer) : ?>
                                    <?= $this->GetNameEntity->getName('Fertilizers',  $farmerFertilizer->fertilizer_id) ?>: 
                                    <?= $farmerFertilizer->quantity ?> <?= $farmerFertilizer->unit ?><br>
                                <?php endforeach ?>
                                <?php if(!$batch->isLock) {?> 
                                    <?= $this->Html->link("+", ['action' => 'addFarmerFertilizer', $farmer->id,$batch->id ]) ?>
                                <?php } ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="paginate">
                <ul class="ul-paginate">
                    <?php
                        echo $this->Paginator->prev('«', [], [], array('class' => 'disabled')); 
                        echo $this->Paginator->numbers(); 
                        echo $this->Paginator->next('»', [], [], array('class' => 'disabled'));
                    ?>
                </ul>
                <div class="paginate-count">
                    <?php
                        echo " Page ".$this->Paginator->counter();
                    ?>
                </div>
            </div>
        </div>
        
    </body>
    <script type="text/javascript">
        function charge() {
            location.href = $("#urlCharge").attr('href') + "/" + $("#season-id").val() + "/" + $("#village-id").val();
        }
    </script>
</html>