<?php $this->extend('../../Layout/TwitterBootstrap/admin');?>

<?php $this->start('tb_content');?>
<main role="main" class="mt-5">
    <div class="container">
        <div class="row">
            <h3><?= __('Статьи') ?></h3>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <!-- <th scope="col"><?= $this->Paginator->sort('id') ?></th> -->
                        <th scope="col"><?= $this->Paginator->sort('Название') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Создана') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Исправлена') ?></th>
                        <th scope="col" class="actions"><?= __('Действия') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <!-- <td><?= $this->Number->format($article->id) ?></td> -->
                        <td><?= h($article->title) ?></td>
                        <td><?= h($article->created) ?></td>
                        <td><?= h($article->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $article->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $article->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
        </div>
    </div>
</main>
<?php $this->end();?>