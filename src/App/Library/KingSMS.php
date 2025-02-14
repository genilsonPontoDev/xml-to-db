<?php

namespace App\Library;

class KingSMS
{
  private $login;
  private $token;
  private $apiUrl = 'http://painel.kingsms.com.br/kingsms/api.php';

  public function __construct($login, $token)
  {
    $this->login = $login;
    $this->token = $token;
  }

  public function send(string $numero, string $mensagem)
  {
    $params = [
      'acao' => 'sendsms',
      'login' => $this->login,
      'token' => $this->token,
      'numero' => $numero,
      'msg' => $mensagem
    ];

    $url = $this->apiUrl . '?' . http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      return 'Erro: ' . curl_error($ch);
    }

    curl_close($ch);

    return $response;
  }
}
