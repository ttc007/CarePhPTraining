<p class="w-100">
    <?= $this->Html->link('Trang chủ', ['controller' => 'Farmers','action' => 'index']) ?> 
    <?php foreach ($hierarchys as $key => $hierarchy) :?>
    	<?php if($key < count($hierarchys)-1){ ?>
    		<i class="fa fa-angle-right" style="display: inline-block;margin:0 15px"></i> 
    		<?= $this->Html->link($hierarchy['title'], ['controller'=>$hierarchy['controller'],'action' => 'index']) ?> 
    	<?php } else { ?>
    		<i class="fa fa-angle-right" style="display: inline-block;margin:0 15px"></i> 
    		<?= $hierarchy['title'] ?>
    	<?php } ?>
    <?php endforeach ?>
</p>