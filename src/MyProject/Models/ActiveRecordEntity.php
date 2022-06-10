<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity implements \JsonSerializable
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ';', [], static::class);
    }

    abstract protected static function getTableName(): string;

    public static function getById(int $id): ?static
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' WHERE id = :id;',
            [':id' => $id],
            static::class
        );

        return $entities ? $entities[0] : null;
    }

    public static function findOneByColumn(string $columnName, $value): ?static
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' WHERE ' . $columnName . ' = :value;',
            [':value' => $value],
            static::class
        );

        return $result ? $result[0] : null;
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    protected function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->execute($sql, $params2values);
    }

    protected function insert(array $mappedProperties): void
    {
        $mpNotNull = array_filter($mappedProperties);
        $params = [];
        $columns = [];
        $params2values = [];

        foreach ($mpNotNull as $column => $value) {
            $params[] = ':' . $column;
            $columns[] = $column;
            $params2values[':' . $column] = $value;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . '(' . implode(', ', $columns) . ') 
        VALUES (' . implode(', ', $params) . ')';
        $db = Db::getInstance();
        $db->execute($sql, $params2values);
        $this->id = $db->getLastInsertId();
        $this->refresh();
    }

    protected function refresh(): void
    {
        $objFromDb = static::getById($this->id);

        foreach ($objFromDb as $key => $value) {
            $this->$key = $value;
        }
    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->execute(
            'DELETE FROM ' . static::getTableName() . ' WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    protected function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    protected function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    protected function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    public function jsonSerialize()
    {
        return $this->mapPropertiesToDbFormat();
    }

    public static function getPagesCount(int $itemsPerPage): int
    {
        $db = Db::getInstance();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ';');
        return ceil($result[0]->cnt / $itemsPerPage);
    }

    public static function getPage(int $pageNum, int $itemsPerPage): array
    {
        $db = Db::getInstance();
        return $db->query(
            sprintf(
                'SELECT * FROM `%s` ORDER BY id DESC LIMIT %d OFFSET %d;',
                static::getTableName(),
                $itemsPerPage,
                ($pageNum - 1) * $itemsPerPage
            ),
            [],
            static::class
        );
    }
}
