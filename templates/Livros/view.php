<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Livro $livro
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Livro'), ['action' => 'edit', $livro->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Livro'), ['action' => 'delete', $livro->id], ['confirm' => __('Are you sure you want to delete # {0}?', $livro->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Livros'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Livro'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="livros view content">
            <h3><?= h($livro->titulo) ?></h3>
            <table>
                <tr>
                    <th><?= __('Titulo') ?></th>
                    <td><?= h($livro->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Autor') ?></th>
                    <td><?= h($livro->autor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano Publicacao') ?></th>
                    <td><?= h($livro->ano_publicacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Isbn') ?></th>
                    <td><?= h($livro->isbn) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($livro->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantidade Total') ?></th>
                    <td><?= $this->Number->format($livro->quantidade_total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantidade Disponivel') ?></th>
                    <td><?= $this->Number->format($livro->quantidade_disponivel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($livro->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($livro->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Emprestimos') ?></h4>
                <?php if (!empty($livro->emprestimos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Livro Id') ?></th>
                            <th><?= __('Usuario Id') ?></th>
                            <th><?= __('Data Emprestimo') ?></th>
                            <th><?= __('Data Devolucao') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($livro->emprestimos as $emprestimo) : ?>
                        <tr>
                            <td><?= h($emprestimo->id) ?></td>
                            <td><?= h($emprestimo->livro_id) ?></td>
                            <td><?= h($emprestimo->usuario_id) ?></td>
                            <td><?= h($emprestimo->data_emprestimo) ?></td>
                            <td><?= h($emprestimo->data_devolucao) ?></td>
                            <td><?= h($emprestimo->status) ?></td>
                            <td><?= h($emprestimo->created) ?></td>
                            <td><?= h($emprestimo->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Emprestimos', 'action' => 'view', $emprestimo->id]) ?>
                                <?= $this->Form->postLink(__('Devolver'), ['controller' => 'Emprestimos', 'action' => 'devolver', $emprestimo->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Emprestimos', 'action' => 'delete', $emprestimo->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $emprestimo->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
