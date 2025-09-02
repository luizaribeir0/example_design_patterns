<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmprestimosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmprestimosTable Test Case
 */
class EmprestimosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmprestimosTable
     */
    protected $Emprestimos;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Emprestimos',
        'app.Livros',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Emprestimos') ? [] : ['className' => EmprestimosTable::class];
        $this->Emprestimos = $this->getTableLocator()->get('Emprestimos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Emprestimos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\EmprestimosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\EmprestimosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
