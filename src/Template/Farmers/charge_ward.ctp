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
        <!-- <?php echo $this->Form->create( null ,['class'=>'form-filter']); ?>
            <div class="row">
                <div class="col-md-4">
                    <?php
                        echo $this->Form->control('season_id', ['type' => 'select','options'=>$this->GetOptions->getSeasonOptions(), 'label' => 'Mùa vụ', 
                        'value' => $season_id]);
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                        echo $this->Form->button(__('Tính tiền') , ['class'=>'btn-filter']);
                    ?>
                </div>
            </div>
        <?php echo $this->Form->end(); ?> -->
        <div class="row">
            <div class="w-100 text-right">
                <?= $this->Html->link("Quay về", ['action' => 'index'], ['class'=> '', 'id' => '']) ?>
            </div>
            <table class="table table-bordered table-striped" id='charge-table'>
                <tr>
                    <th style="width: 50px">STT</th>
                    <th>Khu/thôn</th>
                    <?php foreach ($batchs as $batch) : ?>
                        <th>
                            <?= $batch->name ?> (<?= $batch->date_provide ?>)
                        </th>
                    <?php endforeach ?>
                    <th style="width: 100px" class="text-right">Tổng cộng</th>
                </tr>
                <?php $totalVillage = 0; ?>
                <?php foreach ($villages as $key => $village): ?>
                    <?php $totalSeason = 0; ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td>
                            <?= $village->get('name') ?>
                        </td>
                        <?php foreach ($batchs as $key => $batch) : ?>
                            <td class="text-right">
                                <b><?= number_format($village->totalBatchs[$batch->id]->total)  ?>đ</b>
                                <?php $totalSeason += $village->totalBatchs[$batch->id]->total ?>
                            </td>
                        <?php endforeach ?>
                        <td class="text-right" >
                            <b class="text-danger total-farmer-batch"><?= number_format($totalSeason) ?>đ </b>
                            <?php $totalVillage += $totalSeason; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="<?= count($batchs)+2 ?>" class='text-center'>
                        Tổng tiền <b id="seasonName"></b>
                    </td>
                    <td class="text-right"><b class="text-danger total-farmer-batch"><?= number_format($totalVillage) ?>đ </b></td>
                </tr>
            </table>
        </div>
        
    </body>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#seasonName").html("<?= $this->GetNameEntity->getName('Seasons', $season_id) ?>");
        });
    </script>
</html>
