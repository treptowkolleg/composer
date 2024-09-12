<?php

namespace Core\Component\DataStorageComponent;

use Core\Model\AbstractModel;
use Core\Model\RepositoryFactory\AbstractRepositoryFactory;
use Core\Repository\AbstractRepository;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class EntityManager extends EntityManagerComponent
{


    /**
     * @param $entity
     * @param int|null $id
     * @return false|int|string
     */
    public function persist($entity, int $id = null){
        $data = [];
        try {
            $entity_class = self::generateReflectionClass($entity);
            $class_name = self::generateSnakeTailString($entity_class->getShortName());
            foreach($entity_class->getProperties() as $property){
                if(!in_array($property->getName(),['id','created','updated'])) {
                    if($property->isProtected()){
                        $propertyName = ucfirst($property->getName());
                        $method = "get$propertyName";

                        $data[self::generateSnakeTailString($propertyName)] = $entity->$method();
                    }
                }
            };

            if ($id){
                $row = $this->select("SELECT * FROM $class_name WHERE id = :id", ['id' => $id]);
                if ($row){
                    return $this->update($class_name, $data, ['id' => $id]);
                }
            } else {
                return $this->insert($class_name, $data);
            }
            return false;
        } catch (ReflectionException $exception)
        {

        }
        return false;
    }

    public function remove($entity, $id)
    {
        $entityClass = self::setEntityClass($entity);
        $tableName = self::generateSnakeTailString($entityClass->getShortName());
        if ($id) {
            $row = $this->select("SELECT * FROM $tableName WHERE id = :id", ['id' => $id]);
            if ($row) {
                return $this->delete($tableName, ['id' => $id]);
            }
        }
        return false;
    }

    public function truncate($entity): string
    {
        $entity_class = self::generateReflectionClass($entity);
        $class_name = strtolower($entity_class->getShortName());
        try {
            return $this->truncate($class_name);
        } catch (Exception $e){
            return 'Exception abgefangen: '. $e->getMessage() . "\n";
        }
    }

    protected function generateReflectionClass($entity){
        try {
            return new ReflectionClass($entity);
        } catch (ReflectionException $reflectionException){
            return 'Exception abgefangen: '. $reflectionException->getMessage() . "\n";
        }
    }

    public function isUnique(string $column, string $data, AbstractRepositoryFactory $repositoryFactory): int
    {
        $result = $repositoryFactory->findOneBy([$column => $data]);
        return (bool)array_filter((array)$result);
    }
}