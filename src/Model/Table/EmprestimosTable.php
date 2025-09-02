<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Emprestimo;
use Cake\I18n\FrozenDate;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Emprestimos Model
 *
 * @property \App\Model\Table\LivrosTable&\Cake\ORM\Association\BelongsTo $Livros
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 *
 * @method \App\Model\Entity\Emprestimo newEmptyEntity()
 * @method \App\Model\Entity\Emprestimo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Emprestimo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Emprestimo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Emprestimo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Emprestimo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Emprestimo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Emprestimo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Emprestimo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Emprestimo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Emprestimo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Emprestimo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Emprestimo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Emprestimo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Emprestimo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Emprestimo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Emprestimo> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmprestimosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('emprestimos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Livros', [
            'foreignKey' => 'livro_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('livro_id')
            ->notEmptyString('livro_id');

        $validator
            ->integer('usuario_id')
            ->notEmptyString('usuario_id');

        $validator
            ->date('data_emprestimo')
            ->requirePresence('data_emprestimo', 'create')
            ->notEmptyDate('data_emprestimo');

        $validator
            ->date('data_devolucao')
            ->allowEmptyDate('data_devolucao');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['livro_id'], 'Livros'), ['errorField' => 'livro_id']);
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'), ['errorField' => 'usuario_id']);

        return $rules;
    }

    /**
     * Cria e salva um novo empréstimo, se o livro estiver disponível.
     */
    public function registrarEmprestimo(int $livroId, int $usuarioId, FrozenDate $data): bool
    {
        $livrosTable = $this->getAssociation('Livros')->getTarget();
        $livro = $livrosTable->get($livroId);

        if (!$livro->estaDisponivel()) {
            return false;
        }

        $existe = $this->find()
            ->where([
                'livro_id' => $livroId,
                'usuario_id' => $usuarioId,
                'status' => Emprestimo::STATUS_ANDAMENTO
            ])
            ->count();

        if ($existe > 0) {
            return false;
        }

        $emprestimo = $this->newEntity([
            'livro_id' => $livroId,
            'usuario_id' => $usuarioId,
            'data_emprestimo' => $data,
            'status' => Emprestimo::STATUS_ANDAMENTO
        ]);

        if ($this->save($emprestimo)) {
            return $livrosTable->registrarEmprestimo($livroId);
        }

        return false;
    }

    /**
     * Registra devolução de um empréstimo (usando regra de domínio da Entity).
     */
    public function registrarDevolucao(int $emprestimoId): bool
    {
        $emprestimo = $this->get($emprestimoId, contain: ['Livros']);

        try {
            $emprestimo->registrarDevolucao();
        } catch (\RuntimeException $e) {
            return false;
        }

        if ($this->save($emprestimo)) {
            $livrosTable = $this->getAssociation('Livros')->getTarget();
            return $livrosTable->registrarDevolucao($emprestimo->livro_id);
        }

        return false;
    }

    /**
     * Atualiza status de empréstimos atrasados (delegando regra para a Entity).
     */
    public function atualizarAtrasados(): int
    {
        $atrasados = $this->find()
            ->where(['status' => Emprestimo::STATUS_ANDAMENTO])
            ->all();

        $count = 0;
        foreach ($atrasados as $emp) {
            if ($emp->atrasado()) {
                $emp->marcarAtrasado();
                if ($this->save($emp)) {
                    $count++;
                }
            }
        }

        return $count;
    }
}
