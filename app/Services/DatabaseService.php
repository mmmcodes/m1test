<?php
namespace App\Services;

use App\Contracts\DatabaseInterface;
use PDO;

class DatabaseService implements DatabaseInterface
{
  public PDO $pdo;

  private object $config;

  public function __construct ($config = null)
  {
    if ($config === null) {
      $config = require dirname(__DIR__,2) . '/config/db.php';
    }
    $this->config = (object)$config;
  }

  public function connect(): static
  {
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $config = $this->config;
    $this->pdo = new PDO("mysql:host={$config->host};dbname={$config->database};charset={$config->charset}", $config->username, $config->password, $options);
    return $this;
  }

  public function query(string $query): \PDOStatement
  {
    return $this->pdo->query($query);
  }

  public function execute(string $query, array $variables)
  {
    $query = $this->pdo->prepare($query);
    return $query->execute($variables);
  }
}
