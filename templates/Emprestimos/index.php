<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Emprestimo> $emprestimos
 */
?>
<div class="emprestimos index content">
    <?= $this->Html->link(__('New Emprestimo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Emprestimos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('livro_id') ?></th>
                    <th><?= $this->Paginator->sort('usuario_id') ?></th>
                    <th><?= $this->Paginator->sort('data_emprestimo') ?></th>
                    <th><?= $this->Paginator->sort('data_devolucao') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprestimos as $emprestimo): ?>
                <tr>
                    <td><?= $this->Number->format($emprestimo->id) ?></td>
                    <td><?= $emprestimo->hasValue('livro') ? $this->Html->link($emprestimo->livro->titulo, ['controller' => 'Livros', 'action' => 'view', $emprestimo->livro->id]) : '' ?></td>
                    <td><?= $emprestimo->hasValue('usuario') ? $this->Html->link($emprestimo->usuario->nome, ['controller' => 'Usuarios', 'action' => 'view', $emprestimo->usuario->id]) : '' ?></td>
                    <td><?= h($emprestimo->data_emprestimo) ?></td>
                    <td><?= h($emprestimo->data_devolucao) ?></td>
                    <td><?= h($emprestimo->status) ?></td>
                    <td><?= h($emprestimo->created) ?></td>
                    <td><?= h($emprestimo->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $emprestimo->id]) ?>
                        <?= $this->Form->postLink(__('Devolver'), ['action' => 'devolver', $emprestimo->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $emprestimo->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $emprestimo->id),
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
