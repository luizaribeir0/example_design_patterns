<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\FrozenDate;
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

    /**
     * Verifica se o empréstimo está em andamento.
     */
    public function emAndamento(): bool
    {
        return $this->status === self::STATUS_ANDAMENTO;
    }

    /**
     * Verifica se o empréstimo está devolvido.
     */
    public function devolvido(): bool
    {
        return $this->status === self::STATUS_DEVOLVIDO;
    }

    /**
     * Verifica se o empréstimo está atrasado.
     */
    public function atrasado(): bool
    {
        if ($this->status !== self::STATUS_ANDAMENTO) {
            return false;
        }

        $prazo = 7; // dias de prazo fixo
        return $this->data_emprestimo < FrozenDate::today()->subDays($prazo);
    }

    /**
     * Registra devolução (sem persistir ainda).
     */
    public function registrarDevolucao(): void
    {
        if (!$this->emAndamento()) {
            throw new \RuntimeException("Não é possível devolver: o empréstimo não está em andamento.");
        }

        $this->status = self::STATUS_DEVOLVIDO;
        $this->data_devolucao = FrozenDate::today();
    }

    /**
     * Marca como atrasado (sem persistir ainda).
     */
    public function marcarAtrasado(): void
    {
        if ($this->emAndamento()) {
            $this->status = self::STATUS_ATRASADO;
        }
    }
}
