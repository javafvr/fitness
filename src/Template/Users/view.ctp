<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

?>
<?php $this->extend('../Layout/TwitterBootstrap/admin');?>


<?php $this->start('tb_content');?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
      <!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> -->

      <div class="container">
        <div class="row">
            <?php
            foreach($user['tasks'] as $task):
                
                if($task['is_new']){
                    $classTask="text-white bg-primary";
                    $status = "Новая";
                }else{
                    $classTask="bg-light";
                    $status = "Просмотрено";

                }
            ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card mb-3 <?php echo $classTask; ?>" style="max-width: 18rem;">
                    <div class="card-header"><?php echo $status; ?></div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $task['article']['title']?></h5>
                        <p class="card-text">
                        <?php echo $this->Text->truncate(
                            $task['article']['text'],
                            75,
                            [
                                'ellipsis' => '...',
                                'exact' => false
                            ]
                        );?>
                    </div>
                </div>
            </div>
            
            <?php
            endforeach;
            ?>
        </div>
        <!-- <h3><?= $user->has('name') ? h($user->name): 'Без имени' ?></h3>
        <div class="col-md-6">
            <?php echo $this->Html->image('../img/healthfood.jpg', ['alt' => 'health food']);?>
        </div>
        <div class="col-md-6">
            </p>
                Первоначальный вес : <?php echo $user->parameters[0]->weight;?> кг.
            <p>
            <?= __('Id') ?>
            <?= $this->Number->format($user->id) ?>
        </div> -->
    <!-- </div> -->
   
  
</main>
<?php $this->end();?>
