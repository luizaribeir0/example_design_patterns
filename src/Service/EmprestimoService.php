<?php

namespace App\Service;

use App\Model\Table\EmprestimosTable;
use Cake\I18n\FrozenDate;
use Cake\ORM\TableRegistry;

class EmprestimoService
{
    private EmprestimosTable $emprestimosTable;

    public function __construct()
    {
        $this->emprestimosTable = TableRegistry::getTableLocator()->get('Emprestimos');
    }

    public function listarEmprestimos()
    {
        $this->emprestimosTable->atualizarAtrasados();

        return $this->emprestimosTable->find()
            ->contain(['Livros', 'Usuarios']);
    }

    public function obterEmprestimo(int $id)
    {
        return $this->emprestimosTable->get($id, ['contain' => ['Livros', 'Usuarios']]);
    }

    public function registrarEmprestimo(array $dados): bool
    {
        $livroId = (int)$dados['livro_id'];
        $usuarioId = (int)$dados['usuario_id'];
        $data = new FrozenDate($dados['data_emprestimo']);
        return $this->emprestimosTable->registrarEmprestimo($livroId, $usuarioId, $data);
    }

    public function registrarDevolucao(int $id): bool
    {
        return $this->emprestimosTable->registrarDevolucao($id);
    }

    public function deletarEmprestimo(int $id): bool
    {
        try {
            $emprestimo = $this->emprestimosTable->get($id);
            return $this->emprestimosTable->delete($emprestimo);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            return false;
        }
    }

    public function listarLivrosUsuarios(): array
    {
        $livros = $this->emprestimosTable->Livros->find('list', limit: 200)->all();
        $usuarios = $this->emprestimosTable->Usuarios->find('list', limit: 200)->all();
        return compact('livros', 'usuarios');
    }
}
