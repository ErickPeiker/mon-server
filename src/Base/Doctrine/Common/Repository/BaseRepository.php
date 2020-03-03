<?php

namespace App\Base\Doctrine\Common\Repository;

use App\Base\Helper\FormatHelper;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping as ORM;
use ReflectionClass;
use ReflectionProperty;

trait BaseRepository
{
    protected $repository;

    public function getMessageNotFound()
    {
        return 'Não encontrado';
    }

    public function getClassMetadata()
    {
        return parent::getClassMetadata();
    }

    public function getUser()
    {
        return $this->tokenStorage->getToken() ? $this->tokenStorage->getToken()->getUser() : null;
    }

    public function createEntity()
    {
        $entityClass = $this->getEntityClass();
        return new $entityClass;
    }

    public function defaultFilters($queryWorker)
    {
        return $queryWorker;
    }

    /**
     * @return QueryWorker
     */
    public function findAll()
    {
        $queryWorker = $this->createQueryWorker();

        return $queryWorker;
    }

    public function findBy(array $filters, ?array $orderBy = null, $limit = null, $offset = null)
    {
        $queryWorker = $this->createQueryWorker();

        foreach ($filters as $key => $value) {
            if ($value === null) {
                $queryWorker->andWhere($key, 'isNull');
            } else {
                $queryWorker->andWhere($key, 'equals', $value);
            }
        }

        if ($orderBy) {
            foreach ($orderBy as $field => $order) {
                $queryWorker->orderBy($field, $order);
            }
        }

        if ($limit) {
            $queryWorker->paginate($limit);
        }
        if ($offset) {
            $queryWorker->getBuilder()->setFirstResult($offset);
        }

        return $queryWorker;
    }

    public function findOneBy(array $filters, $abort = true)
    {
        $queryWorker = $this->createQueryWorker();

        foreach ($filters as $key => $value) {
            if ($value === null) {
                $queryWorker->andWhere($key, 'isNull');
            } else {
                $queryWorker->andWhere($key, 'equals', $value);
            }
        }

        $entity = $queryWorker->getOneResult();

        abortIf((!$entity && $abort), 404, $this->getMessageNotFound());

        return $entity;
    }

    public function find($id, $abort = true)
    {
        if (is_object($id)) {
            return $id;
        }

        $entity = $this->createQueryWorker()
            ->andWhere('id', 'equals', $id)
            ->getOneResult();

        abortIf((!$entity && $abort), 404, $this->getMessageNotFound());

        return $entity;
    }

    /**
     * Inserir ou atualizar um registro.
     *
     * @param null | string | int | array
     *
     * @throws InvalidArgumentException Se $input não for null | string | int | array é lançada a exceção
     *
     * @return Bludata\Doctrine\Common\Interfaces\BaseEntityInterface
     */
    public function findOrCreate($input)
    {
        if (is_null($input)) {
            return $input;
        }

        if (is_string($input) && is_object(json_decode($input)) && is_array(json_decode($input, true))) {
            $input = json_decode($input, true);
        }

        if (is_array($input)) {
            if (array_key_exists('id', $input) && $input['id']) {
                $object = $this->find($input['id']);
            } else {
                $object = $this->createEntity();
            }

            $this->setPropertiesEntity($input, $object);

            return $object;
        }

        if (is_numeric($input) || is_string($input)) {
            return $this->find($input);
        }

        throw new \InvalidArgumentException('O parâmetro $input pode ser um null | string | array | numeric');
    }

    public function setPropertiesEntity(array $data, $entity)
    {
        foreach ($data as $key => $value) {
            $set = true;

            if (
                ((!isset($data['id']) || !$data['id']) && !in_array($key, $entity->getOnlyStore()))
                ||
                (isset($data['id']) && $data['id'] && !in_array($key, $entity->getOnlyUpdate()))
            ) {
                $set = false;
            }

            $methodSet = 'set'.ucfirst($key);
            $methodGet = 'get'.ucfirst($key);

            if ($set) {
                /**
                 * Armazena o valor enviado pelo usuário.
                 */
                $valueKey = is_string($value) && strlen($value) <= 0 ? null : $value;

                /**
                 * Classes utilizadas para buscar os metadados da classe e suas propriedades.
                 */
                $reflectionClass = new ReflectionClass(get_class($entity));
                $reflectionProperty = new ReflectionProperty(get_class($entity), $key);
                $annotationReader = new AnnotationReader();

                $propertyAnnotations = $annotationReader->getPropertyAnnotations($reflectionProperty);

                /**
                 * Busca a anotação Doctrine\ORM\Mapping\Column.
                 */
                $column = array_filter($propertyAnnotations, function ($annotation) {
                    return $annotation instanceof ORM\Column;
                });

                if ($column) {
                    $column = array_values($column);
                    $column = array_shift($column);
                }

                /*
                 * Caso seja um campo de data, utilizamos o método FormatHelper::parseDate para converter o valor enviado pelo usuário para um objeto DateTime.
                 */
                if ($column instanceof ORM\Column && ($column->type == 'date' || $column->type == 'datetime' || $column->type == 'time')) {
                    if ($column->type == 'time' && (is_string($valueKey) && strlen($valueKey) == 5)) {
                        $valueKey .= ':00';
                    }

                    $entity->$methodSet(
                        $valueKey ? FormatHelper::parseDate($valueKey, ($column->type == 'date' ? 'Y-m-d' : ($column->type == 'datetime' ? 'Y-m-d H:i:s' : 'H:i:s'))) : null
                    );
                } else {
                    /**
                     * Busca pelas anotações Doctrine\ORM\Mapping\ManyToOne || Doctrine\ORM\Mapping\OneToMany || Doctrine\ORM\Mapping\ManyToMany.
                     */
                    $ormMapping = array_filter($propertyAnnotations, function ($annotation) {
                        return $annotation instanceof ORM\ManyToOne
                            ||
                            $annotation instanceof ORM\OneToMany
                            ||
                            $annotation instanceof ORM\ManyToMany
                            ||
                            $annotation instanceof ORM\OneToOne;
                    });

                    /*
                     * Se for encontrado alguma das anotações, iremos realizar o tratamento adequado para a anotação encontrada.
                     */
                    if ($ormMapping) {
                        $ormMapping = array_values($ormMapping);
                        $ormMapping = array_shift($ormMapping);

                        $targetEntityName = $reflectionClass->getNamespaceName().'\\'.$ormMapping->targetEntity;
                        $targetEntity = new $targetEntityName();
                        $repositoryTargetEntity = $this->getManager()->getRepository($targetEntityName);

                        /**
                         * Caso seja encontrada a anotação Doctrine\ORM\Mapping\DiscriminatorMap em $targetEntity, setamos $repositoryTargetEntity com o repositório da entidade informada referente a $valueKey[$targetEntity->getDiscrName()].
                         */
                        $reflectionClassTargetEntity = new ReflectionClass($targetEntityName);
                        $targetEntityAnnotations = $annotationReader->getClassAnnotations($reflectionClassTargetEntity);

                        $discriminatorMap = array_filter($targetEntityAnnotations, function ($annotation) {
                            return $annotation instanceof ORM\DiscriminatorMap;
                        });

                        if ($discriminatorMap && isset($valueKey[$targetEntity->getDiscrName()])) {
                            $discriminatorMap = array_shift($discriminatorMap);

                            $targetEntityName = array_filter($discriminatorMap->value, function ($valueMap, $keyMap) use ($targetEntity, $valueKey) {
                                return $keyMap == $valueKey[$targetEntity->getDiscrName()];
                            }, ARRAY_FILTER_USE_BOTH);

                            if (!$targetEntityName) {
                                throw new \InvalidArgumentException('Nenhuma entidade foi encontrada para \''.$targetEntity->getDiscrName().'\' = \''.$valueKey[$targetEntity->getDiscrName()].'\'');
                            }

                            $targetEntityName = $reflectionClass->getNamespaceName().'\\'.array_shift($targetEntityName);
                            $targetEntity = new $targetEntityName();
                            $repositoryTargetEntity = $targetEntity->getRepository();
                        }

                        /*
                         * Se a propriedade estiver utilizando a anotação Doctrine\ORM\Mapping\ManyToOne e o usuário
                         * informou um número, então buscamos o devido objeto pelo seu id.
                         */
                        if ($ormMapping instanceof ORM\ManyToOne) {
                            $entity->$methodSet(
                                $valueKey ? $repositoryTargetEntity->findOrCreate($valueKey) : null
                            );
                        } elseif (($ormMapping instanceof ORM\OneToMany || $ormMapping instanceof ORM\ManyToMany) && is_array($valueKey)) {
                            /**
                             * Caso a propriedade esteja utilizando as anotações Doctrine\ORM\Mapping\OneToMany || Doctrine\ORM\Mapping\ManyToMany,
                             * então o usuário terá que implementar o método addX?().
                             * Do contrário será lançada uma BadMethodCallException.
                             */
                            $methodAdd = 'add'.$ormMapping->targetEntity;
                            if (!method_exists($entity, $methodAdd)) {
                                throw new \BadMethodCallException('Para utilizar '.$ormMapping->targetEntity.' em '.get_called_class().'::$'.$key.' você precisar declarar o método '.get_called_class().'::'.$methodAdd.'(), ou, informar o parâmetro '.$ormMapping->targetEntity.'::customMethodAdd');
                            }

                            /*
                             * Percorremos a lista original de elementos
                             */
                            foreach ($entity->$methodGet() as $element) {
                                /*
                                 * Buscamos no array enviado pelo usuário um elemento com o mesmo ID do original.
                                 */
                                $data = array_filter($valueKey, function ($value, $key) use ($element) {
                                    return (is_array($value) && isset($value['id']) && $value['id'] == $element->getId())
                                           ||
                                           $value == $element->getId();
                                }, ARRAY_FILTER_USE_BOTH);

                                if ($data) {
                                    /*
                                     * Caso o elemento seja encontrado, então atualizamos na lista original e removemos do array enviado pelo usuário.
                                     */
                                    $keyData = array_keys($data)[0];

                                    if (is_array($data[$keyData])) {
                                        $repositoryTargetEntity->setPropertiesEntity($data[$keyData], $element);
                                    }

                                    unset($valueKey[$keyData]);
                                } else {
                                    /*
                                     * Caso não seja encontrado, então significa que ele não será mais utilizado na lista, desse modo removemos da lista original.
                                     */

                                    /*
                                     * Removemos apenas o vinculo do registro
                                     */
                                    if ($ormMapping instanceof ORM\OneToMany && !$ormMapping->orphanRemoval) {
                                        $methodSetMappedBy = 'set'.ucfirst($ormMapping->mappedBy);
                                        $element->$methodSetMappedBy(null);
                                    } else {
                                        /*
                                         * Removemos apenas o registro (deletado)
                                         */
                                        $entity->$methodGet()->removeElement($element);
                                    }
                                }
                            }

                            /*
                             * Aqui adicionamos na lista original os novos elementos que ainda não foram persistidos.
                             */
                            foreach ($valueKey as $value) {
                                $entity->$methodAdd($repositoryTargetEntity->findOrCreate($value));
                            }
                        } elseif ($ormMapping instanceof ORM\OneToOne) {
                            $entity->$methodSet($repositoryTargetEntity->findOrCreate($valueKey));
                        }
                    } else {
                        /*
                         * Seta a propriedade com o valor enviado pelo usuário.
                         */
                        $entity->$methodSet($valueKey);
                    }
                }
            }
        }

        return $entity;
    }
}
