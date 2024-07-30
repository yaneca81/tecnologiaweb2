<?php
require_once 'Database.php';


class Model
{
    protected $db;
    protected $table;
    protected $joins = [];
    protected $where = [];
    protected $orderBy = '';
    protected $limit = '';
    protected $joinNames = [];
    protected $selectColumns = [];
    protected $count = false;

    public function __construct($table)
    {
        $dbConfig = require 'config/database.php';
        $this->db = new Database($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database'], $dbConfig['port']);
        $this->table = $table;
    }

    public function count()
    {
        $this->count = true;
        return $this;
    }

    public function select(...$columns)
    {
        $this->selectColumns = array_merge($this->selectColumns, $columns);
        return $this;
    }

    public function join($table, $condition, $type = 'INNER')
    {
        $this->joins[] = "$type JOIN $table ON $condition";
        $this->joinNames[] = $table;
        return $this;
    }

    public function where($condition, $value = null)
    {
        if ($value !== null) {
            $condition = "$condition = '$value'";
        }
        $this->where[] = $condition;
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = "ORDER BY $column $direction";
        return $this;
    }

    public function limit($limit, $offset = 0)
    {
        $this->limit = "LIMIT $offset, $limit";
        return $this;
    }

    public function get()
    {
        $sql = $this->buildSelectQuery();

        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }

        if (!empty($this->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->where);
        }

        $sql .= ' ' . $this->orderBy . ' ' . $this->limit;

        $result = $this->db->query($sql);
        $rows = [];
        while ($row = $this->db->fetch($result)) {
            $formattedRow = $this->formatRow($row);
            $rows[] = $formattedRow;
        }

        $this->resetQuery();

        if ($this->count) {
            return $rows[0]['COUNT(*)'];
        }

        return $rows;
    }

    public function find($condition = null, $value = null)
    {
        if ($condition === null) {
            return $this->first();
        }

        if (is_numeric($condition) && $value === null) {
            return $this->where('id', $condition)->first();
        }

        if ($value !== null) {
            return $this->where($condition, $value)->first();
        }

        return $this->where($condition)->first();
    }

    public function first()
    {
        $result = $this->limit(1)->get();
        return $result ? $result[0] : null;
    }

    public function create($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $types = '';
        $values = array();
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } elseif (is_string($value)) {
                $types .= 's';
            } else {
                $types .= 'b';
            }
            $values[] = $value;
        }

        $stmt->bind_param($types, ...$values);

        $result = $stmt->execute();

        if ($result) {
            return $this->lastInsertId();
        }

        return false;
    }

    public function lastInsertId()
    {
        return mysqli_insert_id($this->db->connection);
    }

    public function update($id, $data)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $set = implode(", ", $set);
        $this->db->query("UPDATE {$this->table} SET $set WHERE id = $id");
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = $id");
    }

    private function formatRow($row)
    {
        $mainTable = [];
        $joinTables = [];

        foreach ($row as $column => $value) {
            $parts = explode('_', $column, 2);
            if (count($parts) == 2 && in_array($parts[0], $this->joinNames)) {
                $joinTables[$parts[0]][$parts[1]] = $value;
            } else {
                $mainTable[$column] = $value;
            }
        }

        foreach ($joinTables as $table => $fields) {
            $mainTable[$table] = $fields;
        }

        return $mainTable;
    }

    private function buildSelectQuery()
    {
        if ($this->count) {
            return "SELECT COUNT(*) FROM {$this->table}";
        }

        if (empty($this->selectColumns)) {
            return "SELECT * FROM {$this->table}";
        }

        $columns = [];
        foreach ($this->selectColumns as $column) {
            if (strpos($column, '.') !== false) {
                list($table, $col) = explode('.', $column);
                if ($table !== $this->table) {
                    $columns[] = "$column AS {$table}_{$col}";
                } else {
                    $columns[] = "$column";
                }
            } else {
                $columns[] = $column;
            }
        }

        return "SELECT " . implode(', ', $columns) . " FROM {$this->table}";
    }

    private function resetQuery()
    {
        $this->selectColumns = [];
        $this->joins = [];
        $this->joinNames = [];
        $this->where = [];
        $this->orderBy = '';
        $this->limit = '';
    }

    public function rawSql($sql, $isArray = true)
    {
        $result = $this->db->query($sql);

        if (!$result) {
            return null;
        }

        $rows = [];
        while ($row = $this->db->fetch($result)) {
            $rows[] = $isArray ? $row : $this->formatRow($row);
        }

        if (empty($rows)) {
            return null;
        }

        if ($isArray) {
            return $rows;
        } else {
            return count($rows) === 1 ? $rows[0] : $rows;
        }
    }

    public function executeQuery($sql)
    {
        return $this->db->query($sql);
    }

    public function prepare($sql)
    {
        return $this->db->connection->prepare($sql);
    }

    public function execute($stmt)
    {
        return $stmt->execute();
    }
}
