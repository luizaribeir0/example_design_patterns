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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $livro->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $livro->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Livros'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="livros form content">
            <?= $this->Form->create($livro) ?>
            <fieldset>
                <legend><?= __('Edit Livro') ?></legend>
                <?php
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('autor');
                    echo $this->Form->control('ano_publicacao');
                    echo $this->Form->control('isbn');
                    echo $this->Form->control('quantidade_total');
                    echo $this->Form->control('quantidade_disponivel');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
