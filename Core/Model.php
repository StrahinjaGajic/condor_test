<?php

namespace Core;

use Core\Databases\DatabaseA;
use Core\Interfaces\ModelInterface;

/**
 *
 * Base model
 *
 */
class Model implements ModelInterface
{
    protected static $DB = null;

    protected $className = null;

    protected $fillable = [];

    public function __construct()
    {
        $this->setDatabaseConnection();

        self::$DB->setCurrentModelName(get_class($this));
    }

    /**
     * Set default database connection
     */
    public function setDatabaseConnection()
    {
        self::$DB = DatabaseA::getInstance();
    }

    /**
     * Get all rows from specified model
     *
     * @param string $columns specify which columns to query
     * @return array|null
     */
    public function getAll($columns = '*')
    {
        return self::$DB->query("SELECT {$columns} FROM ".$this->table)->get();
    }

    /**
     * Get all rows where column = data
     *
     * @param string $columns
     * @param string $column
     * @param string|int $data
     * @return array|null
     */
    public function where($column, $data, $columns = '*')
    {
        return self::$DB->query("SELECT {$columns} FROM {$this->table} WHERE {$column} = '{$data}'")->get();
    }

    /**
     * Store data in database
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $queryData = [];
        foreach ($this->fillable as $field) {
            if (array_key_exists($field, $data)) {
                $queryData[$field] = $data[$field];
            }
        }

        $fields = array_keys($queryData);
        $insertFields = implode(', ', $fields);
        $insertValues = ':' . implode(', :', $fields);

        $query = self::$DB->query("INSERT INTO {$this->table} ({$insertFields}) VALUES ({$insertValues})");

        foreach ($queryData as $key => $value) {
            $query->bind(':' . $key, $value);
        }

        return $query->execute();
    }

    /**
     * Update data in database
     *
     * @param array $data
     * @param int $id
     *
     * @return boolean
     */
    public function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $queryData = [];

        $updateParams = [];

        foreach ($this->fillable as $field) {
            if (array_key_exists($field, $data)) {
                $queryData[$field] = $data[$field];

                $updateParams[] = "{$field} = :{$field}";
            }
        }

        $updateParams = implode(', ', $updateParams);

        $query = self::$DB->query("
            UPDATE {$this->table} SET {$updateParams} WHERE id = {$id}
        ");

        foreach ($queryData as $key => $value) {
            $query->bind(':' . $key, $value);
        }

        return $query->execute();
    }

    /**
     * Delete resource from database
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return self::$DB->query("
            DELETE FROM {$this->table} WHERE id = {$id}
        ")->execute();
    }
}
