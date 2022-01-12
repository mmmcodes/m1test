<?php

namespace App\Controllers;

use App\Contracts\RequestInterface;
use App\Repositories\AlbumRepository;
use App\Response;

class AlbumController
{
  protected RequestInterface $request;
  protected AlbumRepository $repo;

  public function __construct(AlbumRepository $repo, RequestInterface $request)
  {
    $this->repo = $repo;
    $this->request = $request;
  }

  public function list()
  {
    $albums = $this->repo->all();
    Response::json($albums);
  }

  public function show()
  {
    $id = $this->request->params('id');
    $album = $this->repo->one($id);
    Response::json($album);
  }

  public function update()
  {
    $id = (int)$this->request->post('id');
    $data = $this->request->post('data');

    try {
      $this->repo->update($id, $data);
      Response::json(true);
    } catch (\Exception $exception) {
      Response::json($exception);
    }
  }

  public function delete()
  {
    $id = $this->request->post('id');

    try {
      $this->repo->delete((int)$id);
      Response::json(true);
    } catch (\Exception $exception) {
      Response::json($exception);
    }
  }
}