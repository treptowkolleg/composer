<?php

namespace Core\Model;

use DateTime;
use PDO;
use PDOException;
use PDOStatement;
use ReflectionClass;
use ReflectionException;

abstract class AbstractModel extends PDO implements ModelInterface
{
    public string $dsnString;

    /**
     * @param array $dsn
     * @param string|null $username
     * @param string|null $password
     * @param string|null $options
     * @param string $type
     */
    public function __construct(array $dsn = [], string $username = null, string $password = null, string $options = null, string $type = 'mysql')
    {
        try {
            $this->dsnString = "{$type}:";
            $i = 0;
            foreach ($dsn as $key => $value) {
                $this->dsnString .= "{$key}={$value}";
                if (++$i !== count($dsn)) $this->dsnString .= ";";
            }

            parent::__construct($this->dsnString, $username, $password);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
            $this->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        } catch (PDOException $e) {
            echo 'Exception abgefangen: ' . $e->getMessage() . "\n";
        }
    }

    /**
     * @param string $preparedStatement
     * @param array $data
     * @return false|PDOStatement
     */
    protected function select(string $preparedStatement, array $data = [])
    {
        $statement = $this->prepare($preparedStatement);
        foreach ($data as $key => $value) {
            switch ($value) {
                case $value instanceof DateTime:
                    $value = $value->getTimestamp();
                    break;
                case is_string($value):
                    break;
                case is_numeric($value):
                    $value = strval($value);
                    break;
            }
            $statement->bindValue(':' . $key, $value);
        }
        $this->execute($statement);
        return $statement;
    }



    /**
     * @param PDOStatement $statement
     * @return void
     */
    private function execute(PDOStatement $statement): void
    {
        $statement->execute();
    }

    /**
     * @param $sortBy
     * @return string
     */
    protected function createOrderData($sortBy): string
    {

        $orderData = "";
        if ($sortBy) {
            $sortBy = self::setBindValues($sortBy);
            $orderData .= " ORDER BY ";
            $i = 0;
            foreach ($sortBy as $column => $direction) {
                $orderData .= "$column $direction";
                $orderData .= (++$i === count($sortBy)) ? '' : ',';
            }
        }
        return $orderData;
    }

    /**
     * @param string $table
     * @param array $data
     * @return string
     */
    protected function insert(string $table, array $data): string
    {
        ksort($data);

        $table = strtolower($table);

        $fieldNames = implode(', ', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $stmt = self::prepare(" INSERT INTO $table ($fieldNames) VALUES ($fieldValues) ");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        self::execute($stmt);
        return $this->lastInsertId();
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     * @return int
     */
    protected function update(string $table, array $data, array $where): int
    {
        ksort($data);

        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key = :field_$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i == 0) {
                $whereDetails .= "$key = :where_$key";
            } else {
                $whereDetails .= " AND $key = :where_$key";
            }
            $i++;
        }
        $whereDetails = ltrim($whereDetails, ' AND');

        $stmt = self::prepare("UPDATE $table SET $fieldDetails WHERE $whereDetails");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":field_$key", $value);
        }

        foreach ($where as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }

        self::execute($stmt);
        return $stmt->rowCount();
    }

    /**
     * @param string $table
     * @param array $data
     * @return int
     */
    protected function delete(string $table, array $data): int
    {
        ksort($data);

        $whereDetails = null;
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $whereDetails .= "$key = :$key";
            } else {
                $whereDetails .= " AND $key = :$key";
            }
            $i++;
        }
        $whereDetails = ltrim($whereDetails, ' AND');

        //if limit is a number use a limit on the query
        $useLimit = "";
        if (is_numeric(1)) {
            $useLimit = "LIMIT 1";
        }

        $stmt = self::prepare("DELETE FROM $table WHERE $whereDetails $useLimit");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        try {
            self::execute($stmt);
        } catch (PDOException $exception){
            return $exception->getCode();
        }

        return $stmt->rowCount();
    }


    /**
     * @throws ReflectionException
     */
    protected function setEntityClass($entity): ReflectionClass
    {
        if (!class_exists($entity)) throw new ReflectionException();
        return new ReflectionClass($entity);
    }

    protected function setColumns(ReflectionClass $entityClass): string
    {
        $entityProperties = $entityClass->getProperties();
        $columns = false;
        foreach ($entityProperties as $property) {
            if(!$property->isPrivate())
            {
                $propertyNameAsArray = preg_split('/(?=[A-Z])/', $property->getName());
                $propertyNameAsSnakeTail = strtolower(implode('_', $propertyNameAsArray));
                $columns .= "{$propertyNameAsSnakeTail} AS {$property->getName()},";
            }
        }
        return $columns = rtrim($columns, ',');
    }

    protected function setPreparedStatement($data): string
    {
        $preparedStatement = false;
        foreach ($data as $property => $value) {
            $propertyNameAsArray = preg_split('/(?=[A-Z])/', $property);
            $propertyNameAsSnakeTail = strtolower(implode('_', $propertyNameAsArray));
            $preparedStatement .= " {$propertyNameAsSnakeTail} = :{$propertyNameAsSnakeTail} AND";
        }
        return rtrim($preparedStatement, 'AND');
    }

    protected function setBindValues($data): array
    {
        $dataAsSnakeTailedKeys = [];
        foreach ($data as $property => $value) {
            $propertyNameAsArray = preg_split('/(?=[A-Z])/', $property);
            $propertyNameAsSnakeTail = strtolower(implode('_', $propertyNameAsArray));
            $dataAsSnakeTailedKeys[$propertyNameAsSnakeTail] = $value;
        }
        return $dataAsSnakeTailedKeys;
    }

    protected function generateSnakeTailString(string $value): string
    {
        $valueAsArray = preg_split('/(?=[A-Z])/', $value);
        return strtolower(ltrim($propertyNameAsSnakeTail = implode('_', $valueAsArray),'_'));
    }
}
