<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmprestimosFixture
 */
class EmprestimosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'livro_id' => 1,
                'usuario_id' => 1,
                'data_emprestimo' => '2025-09-01',
                'data_devolucao' => '2025-09-01',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-09-01 01:03:47',
                'modified' => '2025-09-01 01:03:47',
            ],
        ];
        parent::init();
    }
}
