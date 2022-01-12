<?php

namespace App\Contracts;

interface QueryBuilderInterface
{
  public function table($table);

  public function select($columns);

  public function where($where, $operator = null, $val = null, $type = '', $andOr = 'AND');

  public function update($data);

  public function insert($data);

  public function delete($id);

  public function orderBy($orderBy, $direction = 'DESC');
}