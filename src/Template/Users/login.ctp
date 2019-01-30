<?php $this->extend('../Layout/TwitterBootstrap/signin');?>
<div class="container ">
        <h1>Вход</h1>
        <?= $this->Form->create() ?>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->button('Войти',['class'=>'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    <div class="row text-center">
        <a href="/users/add" class="w-100 mt-3">Нет аккаунта? Зарегистрируй!</a>
    </div>
</div>



