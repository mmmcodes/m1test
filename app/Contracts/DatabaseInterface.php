<?php
namespace App\Contracts;

interface DatabaseInterface {
  public function connect(): static;
  public function query(string $query): \PDOStatement;
  public function execute(string $query, array $variables);
}