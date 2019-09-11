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
                max-width: 1500px;
            }
            .row{
                max-width: 1500px;
            }
        </style>
    </head>
    <body class="home">
        <?php echo $this->Form->create( null ,['class'=>'form-filter']); ?>
            <div class="row">
                <div class="col-md-4">
                    <?php
                        echo $this->Form->control('season_id', ['type' => 'select','options'=>$this->GetOptions->get('Seasons'), 'label' => 'Mùa vụ', 
                        'value' => $season_id]);
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                        echo $this->Form->control('village_id', ['type' => 'select','options'=>$this->GetOptions->get('Villages'), 'label'=> 'Khu/thôn',
                            'value' => $village_id]);
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                        echo $this->Form->button(__('Tính tiền') , ['class'=>'btn-filter']);
                    ?>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
        <div class="row">
            <div class="w-100 text-right">
                <?= $this->Html->link("", ['action' => 'chargeWard'], ['class'=> 'hidden', 'id' => 'urlChargeWard']) ?>
                <a class="charge" onclick="chargeWard()">Tính tiền toàn bộ xã/thị trấn</a>
            </div>
            <table class="table table-bordered table-striped" id='charge-table'>
                <tr>
                    <th style="width: 50px">STT</th>
                    <th>Nông hộ</th>
                    <?php foreach ($batchs as $batch) : ?>
                        <th>
                            <?= $batch->name ?> (<?= $batch->date_provide ?>)
                        </th>
                    <?php endforeach ?>
                    <th style="width: 100px" class="text-right">Tổng cộng</th>
                </tr>
                <?php $totalVillage = 0; ?>
                <?php foreach ($farmers as $key => $farmer): ?>
                    <?php $totalSeason = 0; ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td>
                            <?= $this->Html->link($farmer->name, ['action' => 'edit', $farmer->id], ['class'=>'farmer-name']) ?><br>
                            Mã số: <?= $this->Html->link($farmer->id, ['action' => 'edit', $farmer->id]) ?><br>
                            Số điện thoại: <?= $farmer->phone ?><br>
                            Khu/thôn: <?= $this->GetNameEntity->getVillageName($farmer->village_id) ?>
                        </td>
                        <?php foreach ($batchs as $key => $batch) : ?>
                            <td>
                                <?php $totalBatch = 0; ?>
                                <?php foreach ($farmer->batchs[$batch->id] as $farmerFertilizer) : ?>
                                    <?= $this->GetNameEntity->getName('Fertilizers',  $farmerFertilizer->fertilizer_id) ?>: 
                                    <?= $farmerFertilizer->quantity ?> <?= $farmerFertilizer->unit ?><br>
                                    <?php  $totalBatch += $farmerFertilizer->quantity*$farmerFertilizer->price  ?>
                                <?php endforeach ?>
                                Tổng cộng: <span class="text-danger"><?= number_format($totalBatch) ?>đ </span>
                                <?php $totalSeason += $totalBatch; ?>
                            </td>
                        <?php endforeach ?>
                        <td class="text-right" >
                            <?= $this->Html->link("", ['action' => 'chargeFarmer'], 
                                ['class'=> 'hidden', 'id' => 'urlChargeFarmer']) ?>
                            <a onclick="chargeFarmer(<?= $farmer->id ?>)"><b class="text-danger total-farmer-batch"><?= number_format($totalSeason) ?>đ </b></a>
                            <?php $totalVillage += $totalSeason; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="<?= count($batchs)+2 ?>" class='text-center'>
                        Tổng tiền của khu/thôn <b id="villageName"></b> - <b id="seasonName"></b>
                    </td>
                    <td class="text-right"><b class="text-danger total-farmer-batch"><?= number_format($totalVillage) ?>đ </b></td>
                </tr>
            </table>
        </div>
        
    </body>
    <script type="text/javascript">
        function chargeWard() {
            location.href = $("#urlChargeWard").attr('href') + "/" + $("#season-id").val();
        }
        $(document).ready(function(){
            $("#villageName").html("<?= $this->GetNameEntity->getName('Villages', $village_id) ?>");
            $("#seasonName").html("<?= $this->GetNameEntity->getName('Seasons', $season_id) ?>");
        });
        function chargeFarmer(farmer_id){
            location.href = $("#urlChargeFarmer").attr('href') + "/" + farmer_id + "/" + $("#season-id").val();
        }
    </script>
</html>
