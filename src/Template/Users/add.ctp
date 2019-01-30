<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php $this->extend('../Layout/TwitterBootstrap/signin');?>
<div class="container">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Регистрация') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
        ?>
    </fieldset>
    <?= $this->Form->button('Зарегистрировать',['class'=>'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <div class="row text-center">
        <a href="/users/login" class="w-100 mt-3">Уже есть логин?</a>
    </div>
</div>
