<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Livros Model
 *
 * @property \App\Model\Table\EmprestimosTable&\Cake\ORM\Association\HasMany $Emprestimos
 *
 * @method \App\Model\Entity\Livro newEmptyEntity()
 * @method \App\Model\Entity\Livro newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Livro> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Livro get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Livro findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Livro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Livro> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Livro|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Livro saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Livro>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Livro>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Livro>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Livro> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Livro>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Livro>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Livro>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Livro> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LivrosTable extends Table
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

        $this->setTable('livros');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Emprestimos', [
            'foreignKey' => 'livro_id',
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
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->requirePresence('titulo', 'create')
            ->notEmptyString('titulo');

        $validator
            ->scalar('autor')
            ->maxLength('autor', 255)
            ->requirePresence('autor', 'create')
            ->notEmptyString('autor');

        $validator
            ->scalar('ano_publicacao')
            ->allowEmptyString('ano_publicacao');

        $validator
            ->scalar('isbn')
            ->maxLength('isbn', 20)
            ->allowEmptyString('isbn')
            ->add('isbn', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('quantidade_total')
            ->notEmptyString('quantidade_total');

        $validator
            ->integer('quantidade_disponivel')
            ->notEmptyString('quantidade_disponivel');

        return $validator;
    }

    /**
     * Reduz a quantidade disponível em 1 ao emprestar um livro.
     */
    public function registrarEmprestimo(int $livroId): void
    {
        $livro = $this->get($livroId);
        if (!$livro->estaDisponivel()) {
            throw new \RuntimeException("O livro " . $livro->titulo . " não está disponível para empréstimo");
        }

        $livro->quantidade_disponivel -= 1;
        $this->save($livro);
    }

    /**
     * Aumenta a quantidade disponível em 1 ao devolver um livro.
     */
    public function registrarDevolucao(int $livroId): void
    {
        $livro = $this->get($livroId);
        if (!($livro->quantidade_disponivel < $livro->quantidade_total)) {
            throw new \RuntimeException("O livro " . $livro->titulo . " já foi devolvido");
        }

        $livro->quantidade_disponivel += 1;
        $this->save($livro);
    }
}
