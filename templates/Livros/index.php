<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Livro> $livros
 */
?>
<div class="livros index content">
    <?= $this->Html->link(__('New Livro'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Livros') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('titulo') ?></th>
                    <th><?= $this->Paginator->sort('autor') ?></th>
                    <th><?= $this->Paginator->sort('ano_publicacao') ?></th>
                    <th><?= $this->Paginator->sort('isbn') ?></th>
                    <th><?= $this->Paginator->sort('quantidade_total') ?></th>
                    <th><?= $this->Paginator->sort('quantidade_disponivel') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro): ?>
                <tr>
                    <td><?= $this->Number->format($livro->id) ?></td>
                    <td><?= h($livro->titulo) ?></td>
                    <td><?= h($livro->autor) ?></td>
                    <td><?= h($livro->ano_publicacao) ?></td>
                    <td><?= h($livro->isbn) ?></td>
                    <td><?= $this->Number->format($livro->quantidade_total) ?></td>
                    <td><?= $this->Number->format($livro->quantidade_disponivel) ?></td>
                    <td><?= h($livro->created) ?></td>
                    <td><?= h($livro->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $livro->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $livro->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $livro->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $livro->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>