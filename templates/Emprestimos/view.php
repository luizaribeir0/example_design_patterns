<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Emprestimo $emprestimo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(__('Delete Emprestimo'), ['action' => 'delete', $emprestimo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emprestimo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Devolver Emprestimo'), ['action' => 'devolver', $emprestimo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Emprestimos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Emprestimo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="emprestimos view content">
            <h3><?= h($emprestimo->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Livro') ?></th>
                    <td><?= $emprestimo->hasValue('livro') ? $this->Html->link($emprestimo->livro->titulo, ['controller' => 'Livros', 'action' => 'view', $emprestimo->livro->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Usuario') ?></th>
                    <td><?= $emprestimo->hasValue('usuario') ? $this->Html->link($emprestimo->usuario->nome, ['controller' => 'Usuarios', 'action' => 'view', $emprestimo->usuario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($emprestimo->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($emprestimo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Emprestimo') ?></th>
                    <td><?= h($emprestimo->data_emprestimo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Devolucao') ?></th>
                    <td><?= h($emprestimo->data_devolucao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($emprestimo->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($emprestimo->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
