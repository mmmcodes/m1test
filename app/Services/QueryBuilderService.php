<?php

namespace App\Services;

use App\Contracts\DatabaseInterface;
use PDO;
use PDOException;
use Closure;
use App\Contracts\QueryBuilderInterface;

class QueryBuilderService implements QueryBuilderInterface
{
  private $db;
  private $table;
  private $columns = '*';
  private $where;
  private $orderBy;
  private $limit;
  private $offset;
  private $query;

  protected $operators = ['=', '!=', '<', '>', '<=', '>=', '<>'];

  public function __construct(DatabaseInterface $db)
  {
    $this->db = $db;
  }

  public function table($table): static
  {
    $this->table = $this->ticks($table);

    return $this;
  }

  public function get(): string
  {
    $query = 'SELECT ' . $this->columns . ' FROM ' . $this->table;
    if (!is_null($this->where)) {
      $query .= ' WHERE ' . $this->where;
    }

    if (!is_null($this->orderBy)) {
      $query .= ' ORDER BY ' . $this->orderBy;
    }

    if (!is_null($this->limit)) {
      $query .= ' LIMIT ' . $this->limit;
    }

    if (!is_null($this->offset)) {
      $query .= ' OFFSET ' . $this->offset;
    }

    return $query;
  }

  public function select($columns): static
  {
    $this->columns = is_array($columns) ? implode(',', $columns) : $columns;
    return $this;
  }

  public function where($where, $operator = null, $val = null, $type = '', $andOr = 'AND'): static
  {
    if (is_array($where) && !empty($where)) {
      $_where = [];
      foreach ($where as $column => $data) {
        $_where[] = $type . $column . ' = ' . $this->escape($data);
      }
      $where = implode(' ' . $andOr . ' ', $_where);
    } else {
      if (empty($where)) {
        return $this;
      }

      if (is_array($operator)) {
        $params = explode('?', $where);
        $_where = '';
        foreach ($params as $key => $value) {
          if (!empty($value)) {
            $_where .= $type . $value . (isset($operator[$key]) ? $this->escape($operator[$key]) : '');
          }
        }
        $where = $_where;
      } elseif (!in_array($operator, $this->operators) || $operator == false) {
        $where = $type . $where . ' = ' . $this->escape($operator);
      } else {
        $where = $type . $where . ' ' . $operator . ' ' . $this->escape($val);
      }
    }

    $this->where = is_null($this->where)
        ? $where
        : $this->where . ' ' . $andOr . ' ' . $where;

    return $this;
  }

  public function update($data): string
  {
    $query = 'UPDATE ' . $this->table . ' SET ';
    $values = [];

    foreach ($data as $column => $value) {
      $values[] = $column . ' = ' . $value;
    }
    $query .= implode(',', $values);

    if ($this->where) {
      $query .= ' WHERE ' . $this->where;
    }

    if ($this->orderBy) {
      $query .= ' ORDER BY ' . $this->orderBy;
    }

    if ($this->limit) {
      $query .= ' LIMIT ' . $this->limit;
    }

    return $query;
  }

  public function insert($data): string
  {
    $query = 'INSERT INTO ' . $this->table . ' ';

    $values = array_values($data);
    if (isset($values[0]) && is_array($values[0])) {
      $column = implode(', ', array_keys($values[0]));
      $query .= '(' . $column . ') VALUES ';
      foreach ($values as $value) {
        $val = implode(', ', array_map([$this, 'escape'], $value));
        $query .= '(' . $val . '), ';
      }
      $query = trim($query, ', ');
    } else {
      $column = implode(', ', array_keys($data));
      $val = implode(', ', array_map([$this, 'escape'], $data));
      $query .= ' (' . $column . ') VALUES (' . $val . ')';
    }

    return $query;
  }

  public function delete($id): string
  {
    $query = 'DELETE FROM ' . $this->table . ' WHERE `id` = ' . $id;
    return $query;
  }

  public function orderBy($orderBy, $direction = 'DESC'): static
  {
    $this->orderBy = $this->ticks($orderBy) . ' ' . strtoupper($direction);
    return $this;
  }

  public function limit(Int $limit): static
  {
    $this->limit = $limit;
    return $this;
  }

  public function offset(Int $offset): static
  {
    $this->offset = $offset;
    return $this;
  }

  protected function quotes($value): string
  {
    return "'$value'";
  }

  public function ticks($value): string
  {
    return "`$value`";
  }
}