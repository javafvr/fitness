<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

?>
<?php $this->extend('../Layout/TwitterBootstrap/admin');?>


<?php $this->start('tb_content');?>
<main role="main" class="mt-5">
      <div class="container">
        <div class="row">
            <?php
            foreach($articles as $article):
                //$user->tasks[4]->id; 
                if(count($article->tasks)){
                    $classTask="bg-light";
                    $status = "Просмотрено";
                }else{
                    $classTask="text-white bg-primary";
                    $status = "Новая";

                }
            ?>
            <div class="col-12 col-md-6 col-xl-4">
                    <a href="/articles/view/<?=$article->id?>" style="text-decoration:none; display:block;">
                    <div class="card mb-3  <?php echo $classTask; ?>" style="max-width: 18rem;">
                        <div class="card-header"><?php echo $status; ?></div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $article->title?></h5>
                                <p class="card-text">
                                    <?php echo $this->Text->truncate(
                                        $article->text,
                                        75,
                                        [
                                            'ellipsis' => '...',
                                            'exact' => false
                                        ]
                                    );?>
                                </p>
                        </div>
                    </div>
                    </a>
                <!-- </a> -->
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

<style>
a.card {
  color: inherit!important;
  text-decoration: inherit;
}
a.card button {
  z-index: 1;
}
a.card-body{
    color:inherit;
}

.card.bg-light{
    color:black;
}

a.card.disabled,
a.card[disabled] {
  pointer-events: none;
  opacity: .8;
}

</style>