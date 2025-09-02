<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\EmprestimoService;

class EmprestimosController extends AppController
{
    private EmprestimoService $service;

    public function initialize(): void
    {
        parent::initialize();
        $this->service = new EmprestimoService();
    }

    public function index()
    {
        $query = $this->service->listarEmprestimos();
        $emprestimos = $this->paginate($query);
        $this->set(compact('emprestimos'));
    }

    public function view($id = null)
    {
        $emprestimo = $this->service->obterEmprestimo((int)$id);
        $this->set(compact('emprestimo'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            try {
                $this->service->registrarEmprestimo($this->request->getData());
                $this->Flash->success(__('O empréstimo foi registrado com sucesso.'));

                return $this->redirect(['action' => 'index']);
            } catch (\RuntimeException $e) {
                $this->Flash->error($e->getMessage());
            }
        }

        $emprestimo = $this->Emprestimos->newEmptyEntity();
        ['livros' => $livros, 'usuarios' => $usuarios] = $this->service->listarLivrosUsuarios();
        $this->set(compact('emprestimo', 'livros', 'usuarios'));
    }

    public function devolver($id = null)
    {
        try {
            $this->service->registrarDevolucao((int)$id);
            $this->Flash->success(__('O empréstimo foi devolvido com sucesso.'));

            return $this->redirect(['action' => 'index']);
        } catch (\RuntimeException $e) {
            $this->Flash->error($e->getMessage());

            return $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        if ($this->service->deletarEmprestimo((int)$id)) {
            $this->Flash->success(__('O empréstimo foi deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível deletar o empréstimo.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
