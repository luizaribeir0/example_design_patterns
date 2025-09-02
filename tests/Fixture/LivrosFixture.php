<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LivrosFixture
 */
class LivrosFixture extends TestFixture
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
                'titulo' => 'Lorem ipsum dolor sit amet',
                'autor' => 'Lorem ipsum dolor sit amet',
                'ano_publicacao' => 'Lorem ipsum dolor sit amet',
                'isbn' => 'Lorem ipsum dolor ',
                'quantidade_total' => 1,
                'quantidade_disponivel' => 1,
                'created' => '2025-09-01 01:03:41',
                'modified' => '2025-09-01 01:03:41',
            ],
        ];
        parent::init();
    }
}
