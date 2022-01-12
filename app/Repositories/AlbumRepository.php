<?php
namespace App\Repositories;

use App\Contracts\DatabaseInterface;
use App\Contracts\QueryBuilderInterface;
use App\Contracts\RepositoryInterface;

class AlbumRepository implements RepositoryInterface
{
  private DatabaseInterface $db;
  private QueryBuilderInterface $query;

  public function __construct(DatabaseInterface $db, QueryBuilderInterface $query)
  {
    $this->db = $db->connect();
    $this->query = $query;
    $this->query->table('albums');
  }

  public function all(string $orderBy = 'id', string $direction = 'DESC')
  {
    $this->query->orderBy($orderBy, $direction);
    $query = $this->query->get();
    return $this->db->query($query);
  }

  public function one(int $id)
  {
    $query = $this->query->where('`id` = '.$id)->limit(1)->get();
    return $this->db->query($query);
  }

  public function create(array $data)
  {
    $query = $this->query->insert($data);
    return $this->db->query($query);
  }

  public function update(int $id, array $data)
  {
    $query = $this->query->update($id, $data);
    return $this->db->query($query);
  }

  public function delete(int $id)
  {
    $query = $this->query->delete($id);
    return $this->db->query($query);
  }
}