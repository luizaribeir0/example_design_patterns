<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Emprestimo $emprestimo
 * @var \Cake\Collection\CollectionInterface|string[] $livros
 * @var \Cake\Collection\CollectionInterface|string[] $usuarios
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Emprestimos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="emprestimos form content">
            <?= $this->Form->create($emprestimo) ?>
            <fieldset>
                <legend><?= __('Add Emprestimo') ?></legend>
                <?php
                    echo $this->Form->control('livro_id', ['options' => $livros]);
                    echo $this->Form->control('usuario_id', ['options' => $usuarios]);
                    echo $this->Form->control('data_emprestimo');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
