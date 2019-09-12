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
    </head>
    <body class="home">
        <div class="row">
            <table>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                </tr>
                <?php foreach ($groups as $key => $group): ?>
                    <tr>
                        <td>
                            <?= $this->Html->link($key+1, ['action' => 'edit', $group->id]) ?>
                        </td>
                        <td>
                            <?= $this->Html->link($group->get('name'),
                             ['action' => 'edit', $group->id]) ?> -
                            <?= $this->GetNameEntity->getName('Villages', $group->village_id)?>
                        </td>
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
</html>