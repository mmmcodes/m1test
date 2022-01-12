<?php
namespace App;

use App\Contracts\ResponseInterface;

class Response implements ResponseInterface
{

  public static function view($template, $variables = [])
  {
    $fileFullName = dirname(__DIR__) . '/view/' . $template . '.php';

    if (!file_exists($fileFullName)) {
      return '';
    }

    if (!empty($variables) && is_array($variables)) {
      extract($variables);
    }

    ob_start();
    include $fileFullName;
    echo ob_get_clean();
    exit;
  }

  public static function json($data)
  {
    header_remove();
    http_response_code(200);
    header('Content-type: application/json');
    echo json_encode($data);
    exit;
  }




}
