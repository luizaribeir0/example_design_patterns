<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Emprestimo Entity
 *
 * @property int $id
 * @property int $livro_id
 * @property int $usuario_id
 * @property \Cake\I18n\Date $data_emprestimo
 * @property \Cake\I18n\Date|null $data_devolucao
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Livro $livro
 * @property \App\Model\Entity\Usuario $usuario
 */
class Emprestimo extends Entity
{
    public const STATUS_ANDAMENTO = 'EM_ANDAMENTO';
    public const STATUS_ATRASADO = 'ATRASADO';
    public const STATUS_DEVOLVIDO = 'DEVOLVIDO';

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
        'livro_id' => true,
        'usuario_id' => true,
        'data_emprestimo' => true,
        'data_devolucao' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'livro' => true,
        'usuario' => true,
    ];
}
