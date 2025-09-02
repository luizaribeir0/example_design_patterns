<?php

namespace App\Service;

use App\Model\Table\EmprestimosTable;
use App\Model\Table\LivrosTable;
use Cake\I18n\FrozenDate;
use Cake\ORM\TableRegistry;

class EmprestimoService
{
    private EmprestimosTable $emprestimosTable;
    private LivrosTable $livrosTable;

    public function __construct()
    {
        $this->emprestimosTable = TableRegistry::getTableLocator()->get('Emprestimos');
        $this->livrosTable = TableRegistry::getTableLocator()->get('Livros');
    }

    public function listarEmprestimos()
    {
        try {
            $this->emprestimosTable->atualizarAtrasados();

            return $this->emprestimosTable->find()->contain(['Livros', 'Usuarios']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function obterEmprestimo(int $id)
    {
        return $this->emprestimosTable->get($id, ['contain' => ['Livros', 'Usuarios']]);
    }

    public function registrarEmprestimo(array $dados): void
    {
        $livroId = (int)$dados['livro_id'];
        $usuarioId = (int)$dados['usuario_id'];
        $data = new FrozenDate($dados['data_emprestimo']);

        try {
            $this->emprestimosTable->registrarEmprestimo($livroId, $usuarioId, $data);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function registrarDevolucao(int $id): void
    {
        try {
            $this->emprestimosTable->registrarDevolucao($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function deletarEmprestimo(int $id): bool
    {
        try {
            $emprestimo = $this->emprestimosTable->get($id);
            $this->livrosTable->registrarDevolucao($emprestimo->livro_id);

            return $this->emprestimosTable->delete($emprestimo);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function listarLivrosUsuarios(): array
    {
        $livros = $this->emprestimosTable->Livros->find('list', limit: 200)->all();
        $usuarios = $this->emprestimosTable->Usuarios->find('list', limit: 200)->all();
        return compact('livros', 'usuarios');
    }
}
