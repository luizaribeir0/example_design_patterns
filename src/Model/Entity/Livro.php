<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Livro Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string $autor
 * @property string|null $ano_publicacao
 * @property string|null $isbn
 * @property int $quantidade_total
 * @property int $quantidade_disponivel
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Emprestimo[] $emprestimos
 */
class Livro extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'titulo' => true,
        'autor' => true,
        'ano_publicacao' => true,
        'isbn' => true,
        'quantidade_total' => true,
        'quantidade_disponivel' => true,
        'created' => true,
        'modified' => true,
        'emprestimos' => true,
    ];

    /**
     * Verifica se o livro está disponível para empréstimo.
     */
    public function estaDisponivel(): bool
    {
        return $this->quantidade_disponivel > 0;
    }
}
