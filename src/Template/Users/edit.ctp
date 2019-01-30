<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Действия') ?></li>
        <li><?= $this->Form->postLink(
                __('Удалить профиль'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <!-- <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li> -->
        <!-- <li><?= $this->Html->link(__('List Parametrs'), ['controller' => 'Parametrs', 'action' => 'index']) ?></li> -->
        <!-- <li><?= $this->Html->link(__('New Parametr'), ['controller' => 'Parametrs', 'action' => 'add']) ?></li> -->
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Редактировать профиль') ?></legend>
        <?php
            echo $this->Form->control('name', ['label'=>'Ваше имя','name'=>'name','type' => 'text']);
            echo $this->Form->control('id', ['name'=>'id','type' => 'hidden']);
            echo $this->Form->control('parameters.0.weight');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Сохранить'), array('class'=>'btn btn-primary')); ?>
    <?= $this->Form->end() ?>
</div>
