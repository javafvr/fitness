<?php
/* @var $this \Cake\View\View */
use Cake\Core\Configure;

// $session_user = $this->request->session()->read('Auth.User');

$this->Html->css('BootstrapUI.dashboard', ['block' => true]);
$this->prepend('tb_body_attrs', ' class="' . implode(' ', [$this->request->getParam('controller'), $this->request->getParam('action')]) . '" ');
$this->start('tb_body_start');
?>



<body <?= $this->fetch('tb_body_attrs') ?>>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/"><?= Configure::read('App.title') ?></a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button> -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        </div>
        <?php if(!empty($loggedIn)): ?>
            <a class="btn btn-danger my-2 my-sm-0" href="/users/logout">Выйти</a>
        <?php else:?>
            <a class="btn btn-success my-2 my-sm-0" href="/users/login">Войти</a>
        <?php endif;?>
    </nav>
    <?php echo $this->fetch('tb_content'); ?>
    <?php

    /**
     * Default `flash` block.
     */
    if (!$this->fetch('tb_flash')) {
        $this->start('tb_flash');
        if (isset($this->Flash)) {
            echo $this->Flash->render();
        }
        $this->end();
    }
    $this->end();

    $this->start('tb_body_end');
    echo '</body>';
    $this->end();

    $this->append('content', '</div></div></div>');
    echo $this->fetch('content');
