<?php
namespace App\Contracts;

interface RepositoryInterface {
  public function all(string $orderBy = 'id');

  public function one(Int $id);

  public function create(Array $data);

  public function update(Int $id, array $data);

  public function delete(Int $id);
}