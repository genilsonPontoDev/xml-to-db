<?php

use Core\Jwt;
use Core\Request;
use Core\Response;
use Core\Crip;
use App\Dto\User as userDto;
use App\Model\User;

global $router;
global $model;

$router->post("/usuarios/criar-usuario", function (Request $req, Response $res) use ($model) {
    try {        
        $email = $req->get('email') ?? '';
        $senha = $req->get('senha') ?? '';
        $senha = hash('sha256', $senha);        
        $data = $req->getAllParameters();
        $userDto = new userDto($data);                   
        
        // Verificando se o usuário já existe
        $usuarioExistente = $model->select('Usuarios', 'email = :email', ['email' => $email]);
        if (!empty($usuarioExistente)) {
            $res->status(400)->body(['error' => 'Usuário já existe.']);
            return;
        }

        $userInsert = new User($userDto);
        
        // Inserindo o novo usuário com todos os campos
        $novoUsuario = $userInsert->inserirUsuario();
        
        $res->status(201)->body(['message' => 'Usuário criado com sucesso.']);

    } catch (\Exception $e) {
        error_log($e->getMessage());
        $res->status(500)->body(['error' => 'Erro ao criar usuário.']);
    }
});

$router->get('/listar-usuarios', function (Request $req, Response $res) use ($model) {
    try {
        $page = $req->get('page') ?? 1;
        $pageSize = $req->get('pageSize') ?? 60;
        $pageNumber = (int) $page;
        $pageSizeNumber = (int) $pageSize;

        $skip = ($pageNumber - 1) * $pageSizeNumber;

        $usuarios = $model->paginate('usuarios', $pageNumber, $pageSizeNumber);

        $usuariosSemSenha = array_map(function ($usuario) {
            unset($usuario['senha']);
            return $usuario;
        }, $usuarios);

        return $res->status(200)->body([
            'data' => $usuariosSemSenha,
            'meta' => [
                'page' => $pageNumber,
                'pageSize' => $pageSizeNumber,
                'total' => count($usuarios),
            ],
        ]);
    } catch (\Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->get('/buscar-usuario/{id}', function (Request $req, Response $res) use ($model) {
    try {
        $id = $req->get('id');

        $usuario = $model->select('usuarios', 'idUsuario = :id', ['id' => (int)$id]);

        if (empty($usuario)) {
            $res->status(404);
            return $res->body(['error' => 'Usuário não encontrado.']);
        }

        $usuario = $usuario[0];
        unset($usuario['senha']);

        $res->status(200);
        return $res->body($usuario);
    } catch (Exception $error) {
        error_log($error);
        $res->status(500);
        return $res->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->put('/usuarios/atualizar-usuario/{id}', function (Request $req, Response $res) use ($model) {
    try {
        $id = $req->get('id');
        $data = $req->getAllParameters();

        //var_dump($data); die();

        $dadosAtualizados = ['bloqueado' => $req->get('bloqueado') == '' ? 0 : 1, 'status' => $req->get('status') == '' ? 0 : 1];
        $dadosAtualizados = array_merge($data, $dadosAtualizados);

        unset($dadosAtualizados['id']);
        unset($dadosAtualizados['idSubConta']);
        unset($dadosAtualizados['idTipoConta']);



        $usuarioAtualizado = $model->update('Usuarios', $dadosAtualizados, 'idUsuario = ' . $id, []);

        /* if ($usuarioAtualizado) {
            $usuarioSemSenha = $dadosAtualizados;
            unset($usuarioSemSenha['senha']);
            
            return $res->status(200)->body($usuarioSemSenha);
        } else {
            return $res->status(404)->body(['error' => 'Usuário não encontrado.']);
        } */
        return $res->status(200)->body($dadosAtualizados);
    } catch (Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->delete('/deletar-usuario/{id}', 'verifyToken', 'checkBlocked', function (Request $req, Response $res) use ($model) {
    try {
        $id = $req->get('id');

        $usuarioExistente = $model->select('usuarios', 'idUsuario = ?', [$id]);

        if (empty($usuarioExistente)) {
            $res->status(404);
            $res->body(['error' => 'Usuário não encontrado.']);
            return;
        }

        $model->query('DELETE FROM usuarios WHERE idUsuario = ?', [$id]);

        $res->status(204);
        $res->body([]);
    } catch (Exception $error) {
        error_log($error->getMessage());
        $res->status(500);
        $res->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->post('/adicionar-permissao/{idUsuario}', 'verifyToken', 'checkBlocked', function (Request $req, Response $res) use ($model) {
    try {
        $idUsuario = $req->get('idUsuario');
        $permissoes = json_decode($req->getBody(), true)['permissoes'];

        $usuarioExists = $model->select('usuarios', 'idUsuario = ?', [$idUsuario]);

        if (empty($usuarioExists)) {
            return $res->status(404)->body(['error' => 'Usuário não encontrado.']);
        }

        $usuario = $model->update('usuarios', [
            'permissoesDoUsuario' => json_encode($permissoes),
        ], 'idUsuario = ?', [$idUsuario]);

        if ($usuario) {
            return $res->status(200)->body($usuario);
        } else {
            return $res->status(500)->body(['error' => 'Erro ao adicionar permissões ao Usuário.']);
        }
    } catch (Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => 'Erro ao adicionar permissões ao Usuário.']);
    }
});

$router->delete("/remover-permissao/{idUsuario}", 'verifyToken', 'checkBlocked', function (Request $req, Response $res) use ($model) {
    try {
        $idUsuario = $req->get('idUsuario');
        $permissoes = json_decode($req->getBody(), true)['permissoes'];

        $usuarioExists = $model->select('usuarios', 'idUsuario = ?', [$idUsuario]);

        if (empty($usuarioExists)) {
            return $res->status(404)->body(['error' => "Usuário não encontrado."]);
        }

        $usuario = $model->select('usuarios', 'idUsuario = ?', [$idUsuario]);

        if (empty($usuario)) {
            return $res->status(404)->body(['error' => "Usuário não encontrado."]);
        }

        $novasPermissoes = array_filter(json_decode($usuario[0]['permissoesDoUsuario'], true) ?? [], function ($permissao) use ($permissoes) {
            return !in_array($permissao, $permissoes);
        });

        $model->update('usuarios', ['permissoesDoUsuario' => json_encode(array_values($novasPermissoes))], 'idUsuario = ?', [$idUsuario]);

        $usuarioSemSenha = $usuario[0];
        unset($usuarioSemSenha['senha']);

        return $res->status(200)->body(['message' => "Permissões removidas com sucesso.", 'usuarioSemSenha' => $usuarioSemSenha]);
    } catch (Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => "Erro ao remover permissões do Usuário."]);
    }
});

$router->get('/listar-permissoes/{idUsuario}', function (Request $req, Response $res) use ($model) {
    try {
        $idUsuario = $req->get('idUsuario');

        $usuarioExists = $model->select('usuarios', 'idUsuario = ?', [$idUsuario]);

        if (empty($usuarioExists)) {
            return $res->status(404)->body(['error' => "Usuário não encontrado."]);
        }

        $usuario = $usuarioExists[0];

        $permissoes = json_decode($usuario['permissoesDoUsuario'] ?? '[]', true);

        return $res->status(200)->body(['permissoes' => $permissoes]);
    } catch (Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => "Erro ao obter as permissões do Usuário."]);
    }
});

$router->post("/solicitar-redefinicao-senha-usuario", function (Request $req, Response $res) use ($model) {
    try {
        $body = json_decode($req->getBody(), true);
        $email = $body['email'] ?? null;
        $cpf = $body['cpf'] ?? null;

        if ($email) {
            $usuario = $model->select('usuarios', 'email = :email', ['email' => $email]);
        } elseif ($cpf) {
            $usuario = $model->select('usuarios', 'cpf = :cpf', ['cpf' => $cpf]);
        } else {
            $res->status(400);
            return $res->body(['error' => "É necessário fornecer um email ou CPF."]);
        }

        if (empty($usuario)) {
            $res->status(404);
            return $res->body(['error' => "Usuário não encontrado."]);
        }

        $tokenResetSenha = gerarToken(); // Assumindo que a função gerarToken está definida

        $usuarioAtualizado = $model->update('usuarios', [
            'tokenResetSenha' => $tokenResetSenha !== null ? $tokenResetSenha : "",
        ], 'idUsuario = :id', ['id' => $usuario[0]['idUsuario']]);

        $resetLink = "https://app.redetrade.com.br/resetPassword?id={$usuario[0]['idUsuario']}&token={$tokenResetSenha}";

        $emailDestinatario = $usuario[0]['email'];
        $assuntoEmail = "Redefinição de Senha - REDE TRADE";
        $corpoEmail = "Olá,\n\nVocê solicitou a redefinição de senha para sua conta na REDE TRADE. Por favor, clique no link a seguir para redefinir sua senha:\n\n{$resetLink}\n\nSe você não solicitou essa redefinição, ignore este e-mail.\n\nAtenciosamente,\nREDE TRADE";
        enviarEmail($emailDestinatario, $assuntoEmail, $corpoEmail); // Assumindo que a função enviarEmail está definida

        return $res->status(200)->body(['message' => "Um link para redefinição de senha foi enviado para o seu email."]);
    } catch (Exception $error) {
        error_log($error);
        $res->status(500);
        return $res->body(['error' => "Erro interno do servidor."]);
    }
});

$router->post("/redefinir-senha-usuario/{idUsuario}", function (Request $req, Response $res) use ($model) {
    try {
        $idUsuario = $req->get('idUsuario');
        $body = json_decode($req->getBody(), true);
        $novaSenha = $body['novaSenha'];
        $token = $body['token'];

        $usuario = $model->select('usuarios', 'idUsuario = :id AND tokenResetSenha = :token', [
            ':id' => intval($idUsuario),
            ':token' => $token,
        ]);

        if (empty($usuario)) {
            return $res->status(400)->body(['error' => "Token de redefinição de senha inválido."]);
        }

        $senhaCriptografada = password_hash($novaSenha, PASSWORD_BCRYPT);

        $model->update('usuarios', [
            'senha' => $senhaCriptografada,
            'tokenResetSenha' => null,
        ], 'idUsuario = :id', [':id' => intval($idUsuario)]);

        unset($usuario[0]['senha']);

        return $res->status(200)->body(['message' => "Senha atualizada com sucesso", 'usuarioSemSenha' => $usuario[0]]);
    } catch (Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => "Erro interno do servidor."]);
    }
});

$router->post("/usuarios/login", function (Request $req, Response $res) use ($model) {
    try {
        $login = $req->get('login');
        $senha = Crip::pass($req->get('senha'));


        $usuario = $model->select(
            'Usuarios',
            'email = :email OR cpf = :cpf AND senha = :senha',
            ['email' => $login, 'cpf' => $login, 'senha' => $senha]
        );
        $subconta = $model->select(
            'SubContas',
            'email = :email OR cpf = :cpf AND senha = :senha',
            ['email' => $login, 'cpf' => $login, 'senha' => $senha]
        );

        $user = !empty($usuario) ? $usuario[0] : (!empty($subconta) ? $subconta[0] : null);
        $userId = $user['idUsuario'] ?? $user['idSubContas'] ?? null;

        if (!$user) {
            return $res->status(404)->body(['error' => "Usuário não encontrado."]);
        }

        if (!$usuario[0]['email']) {
            return $res->status(401)->body(['error' => "Credenciais inválidas."]);
        }

        $secret = getenv('SECRET') ?: '';
        $jwt =  new Jwt($secret);
        $token = $jwt->createToken(['userId' => $userId], $secret, 'HS256', 3600);

        unset($user['senha'], $user['tokenResetSenha']);

        return $res->status(200)->body(['token' => $token, 'user' => $user]);
    } catch (Exception $error) {
        error_log($error);
        return $res->status(401)->body(['error' => "Erro ao fazer login."]);
    }
});

$router->get('/usuarios/user-info', function (Request $req, Response $res) use ($model) {
    try {
        $headers = apache_request_headers();
        $token = str_replace("Bearer ", "", $headers['Authorization']);

        $secret = getenv('SECRET') ?: '';
        $jwt =  new Jwt($secret);

        $data = $jwt->decodeToken($token);

        $userId = $data['userId'];

        $user = $model->select('Usuarios', 'idUsuario = :idUsuario', ['idUsuario' => $userId]);



        if (empty($user)) {
            return $res->status(404)->body(['error' => 'Usuário não encontrado.']);
        }

        $user = $user[0];

        $accounts = $model->select('Conta', 'usuarioId = :usuarioId', ['usuarioId' => $userId]);
        $user['conta'] = $accounts[0];

        $user['conta']['tipoDaConta'] = [];
        $user['conta']['tipoDaConta']['id'] = $user['conta']['tipoContaId'];
        $user['conta']['tipoDaConta']['descricao'] = 'Matriz';

        unset($user['senha'], $user['tokenResetSenha']);


        $res->status(200)->body($user);
    } catch (Exception $error) {
        error_log($error);
        $res->status(500)->body(['error' => 'Erro ao obter informações do usuário.']);
    }
});


$router->post("/usuarios/listar-tipo-usuarios", /*verifyToken, checkBlocked,*/ function (Request $req, Response $res) use ($model) {
    try {
        $page = $req->get('page') ?? 0;
        $pageSize = $req->get('pageSize') ?? 100;
        $pageNumber = (int) $page;
        $pageSizeNumber = (int) $pageSize;

        $tipoConta = $req->get('tipoConta') ?? null;


        if (!$tipoConta || !is_array($tipoConta) || count($tipoConta) === 0) {
            return $res->status(400)->body([
                'error' => 'O tipo de conta é obrigatório e deve ser um array não vazio no corpo da solicitação.'
            ]);
        }

        //$skip = ($pageNumber - 1) * $pageSizeNumber;

        //$usuarios = $model->select('Usuarios', 'tipoDaConta IN (:tipoConta)', [':tipoConta' => $tipoConta], $skip, $pageSizeNumber);   

        $parametros = [];


        foreach ($tipoConta as $k => $v) {
            $parametros[':tipoConta' . $k] = $v;
        }

        $meusIndicesFavoritos = implode(',', array_keys($parametros));        

        /* $usuarios = $model->query(
            'SELECT 
                U.idUsuario,
                U.usuarioCriadorId,
                U.matrizId,
                U.nome,
                U.cpf,
                U.email,
                U.imagem,
                U.statusConta,
                U.reputacao,
                U.razaoSocial,
                U.nomeFantasia,
                U.cnpj,
                U.inscEstadual,
                U.inscMunicipal,
                U.mostrarNoSite,
                U.descricao,
                U.tipo,
                U.tipoDeMoeda,
                U.status,
                U.restricao,
                U.nomeContato,
                U.telefone,
                U.celular,
                U.emailContato,
                U.emailSecundario,
                U.site,
                U.logradouro,
                U.numero,
                U.cep,
                U.complemento,
                U.bairro,
                U.cidade,
                U.estado,
                U.regiao,
                U.aceitaOrcamento,
                U.aceitaVoucher,
                U.tipoOperacao,
                U.categoriaId,
                U.subcategoriaId,
                U.taxaComissaoGerente,                
                U.bloqueado,
                GC.nome AS nomeGerente,
                GC.nomeContato,
                C.idConta,
                SC.idSubContas AS idContaGerenciada,
                O.idOferta,
                TC.tipoDaConta,
                U.tipo,
                TComprador.idTransacao AS idTransacaoComprador,
                TVendedor.idTransacao AS idTransacaoVendedor,
                COBR.idCobranca
            FROM 
                Usuarios U
            INNER JOIN 
                Conta C ON U.idUsuario = C.usuarioId
            INNER JOIN 
                TipoConta TC ON C.tipoContaId = TC.idTipoConta
            LEFT JOIN 
                Usuarios GC ON C.gerenteContaId = GC.idUsuario
            LEFT JOIN 
                SubContas SC ON U.idUsuario = SC.contaPaiId
            LEFT JOIN 
                Oferta O ON U.idUsuario = O.usuarioId
            LEFT JOIN 
                Transacao TComprador ON U.idUsuario = TComprador.compradorId
            LEFT JOIN 
                Transacao TVendedor ON U.idUsuario = TVendedor.vendedorId
            LEFT JOIN 
                Cobranca COBR ON U.idUsuario = COBR.usuarioId
            WHERE 
                U.tipo IN (' . $meusIndicesFavoritos . ')',
            $parametros
        ); */

        $usuarios = $model->query(
            'SELECT 
                *
            FROM 
                Usuarios
                WHERE 
                tipo IN (' . $meusIndicesFavoritos . ')',
            $parametros             
        );        
        

        $contas = $model->query('SELECT * FROM Conta');

        $hashContas = [];

        foreach ($contas as $conta) {
            $hashContas[$conta["usuarioId"]] = $conta;
        }

        foreach ($usuarios as &$usuario) {
            $usuario['conta'] = $hashContas[$usuario["idUsuario"]];
            $usuario['status'] = !!$usuario['status'];
            $usuario['bloqueado'] = !!$usuario['bloqueado'];
        }

        $usuariosSemSenha = array_map(function ($usuario) {
            unset($usuario['senha']);
            return $usuario;
        }, $usuarios);

        //var_dump($usuarios); die();

        return $res->status(200)->body([
            'data' => $usuariosSemSenha,
            'meta' => [
                'page' => $pageNumber,
                'pageSize' => $pageSizeNumber,
                'total' => count($usuarios), // Total de usuários sem a paginação
            ],
        ]);
    } catch (Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->get("/listar-ofertas/{idUsuario}", function (Request $req, Response $res) use ($model) {
    try {
        $idUsuario = $req->get('idUsuario');

        if (!filter_var($idUsuario, FILTER_VALIDATE_INT)) {
            $res->status(400);
            return $res->body(["error" => "ID do usuário inválido."]);
        }

        $usuario = $model->select('usuarios', 'idUsuario = ?', [$idUsuario]);

        if (empty($usuario)) {
            $res->status(404);
            return $res->body(["error" => "Usuário não encontrado."]);
        }

        return $res->status(200)->body(["data" => $usuario[0]['ofertas']]);
    } catch (Exception $error) {
        error_log($error);
        $res->status(500);
        return $res->body(["error" => "Erro interno do servidor."]);
    }
});

$router->get('/buscar-tipo-de-conta/{userId}', function (Request $req, Response $res) use ($model) {

    try {
        $userId = intval($req->get('userId')); // Certifique-se de usar o parâmetro correto

        $usuarioComTipoDaConta = $model->select('usuarios', 'idUsuario = :id', ['id' => $userId]);

        if (empty($usuarioComTipoDaConta)) {
            return $res->status(404)->body(['error' => 'Usuário não encontrado']);
        }

        $tipoDeConta = $usuarioComTipoDaConta[0]['conta']['tipoDaConta']['tipoDaConta'] ?? null;

        if (!$tipoDeConta) {
            return $res->status(404)->body(['error' => 'Tipo de conta não encontrado para este usuário']);
        }

        $res->body(['tipoDeConta' => $tipoDeConta]);
    } catch (Exception $error) {
        error_log("Erro ao buscar tipo de conta do usuário: " . $error->getMessage());
        $res->status(500)->body(['error' => 'Erro interno do servidor']);
    }
});

$router->get('/buscar-franquias/{matrizId}', function (Request $req, Response $res) use ($model) {

    try {
        $matrizId = $req->get('matrizId', 'ID da matriz não fornecido.');

        $franquias = $model->select('usuarios', 'usuarioCriadorId = :usuarioCriadorId AND conta.tipoDaConta.tipoDaConta IN ("Franquia", "Franquia Master")', [
            'usuarioCriadorId' => (int)$matrizId
        ]);

        return $res->body($franquias);
    } catch (Exception $error) {
        error_log($error);
        return $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->get('/usuarios-criados/{usuarioCriadorId}', function (Request $req, Response $res) use ($model) {

    try {
        $usuarioCriadorId = $req->get('usuarioCriadorId');

        $usuariosAssociados = $model->select('usuarios', 'usuarioCriadorId = :usuarioCriadorId AND conta.tipoDaConta.tipoDaConta = :tipoDaConta', [
            'usuarioCriadorId' => (int)$usuarioCriadorId,
            'tipoDaConta' => 'Associado',
        ]);

        if (empty($usuariosAssociados)) {
            $res->status(404);
            return $res->body(['error' => 'Não foi possível encontrar os associados.']);
        }


        $usuariosAssociadosSemSenha = array_map(function ($usuario) {
            unset($usuario['senha'], $usuario['tokenResetSenha']);
            return $usuario;
        }, $usuariosAssociados);

        $res->status(200);
        return $res->body($usuariosAssociadosSemSenha);
    } catch (Exception $error) {
        error_log($error);
        $res->status(500);
        return $res->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->get('/usuarios/buscar-usuario-params', function (Request $req, Response $res) use ($model) {
    try {
        $nome = $req->get('nome');
        $nomeFantasia = $req->get('nomeFantasia');
        $razaoSocial = $req->get('razaoSocial');
        $nomeContato = $req->get('nomeContato');
        $estado = $req->get('estado');
        $cidade = $req->get('cidade');
        //$usuarioCriadorId = $req->get('usuarioCriadorId');
        $tipoDaConta = $req->get('tipoDaConta');
        $filter = [];
        $page = intval($queryParams['page'] ?? 1);
        $pageSize = intval($queryParams['pageSize'] ?? 10);
        $skip = ($page - 1) * $pageSize;
        //$queryParams = $model->query("SELECT * FROM Usuarios")[0] ?? [];
        $sql = 'SELECT * FROM Usuarios';
        $tipoContaVal = $model->query("SELECT * FROM TipoConta");

        //$queryParams['usuarioCriador'] = ['nomeFantasia' => $queryParams['nomeFantasia'] ?? []];



        $filter = [];

        if ($nome) {
            $filter['nome'] = $nome;
        }
        if ($nomeFantasia) {
            $filter['nomeFantasia'] = $nomeFantasia;
        }
        if ($razaoSocial) {
            $filter['razaoSocial'] = $razaoSocial;
        }
        if ($nomeContato) {
            $filter['nomeContato'] = $nomeContato;
        }
        if ($estado) {
            $filter['estado'] = $estado;
        }
        if ($cidade) {
            $filter['cidade'] = $cidade;
        }
        /* if ($usuarioCriadorId) {
            var_dump($usuarioCriadorId); die('coisa');
            //$filter['usuarioCriadorId'] = $usuarioCriadorId;
        } */

        if ($tipoDaConta) {
            $filter['tipo'] = $tipoDaConta;
        } else {
            $filter['tipo'] = 'Associado';
        }



        $newFilter = [];

        foreach ($filter as $k => $v) {
            $newFilter[':' . $k] = $v;
        }

        $keys = array_keys($filter);

        if (count($keys) > 0) {
            $keys = array_map(function ($v) {
                return "$v = :{$v}";
            }, $keys);
            $sql .= " WHERE " . implode(' AND ', $keys);
        }

        $queryParams = $model->query($sql, $newFilter);
        //var_dump($queryParams); die('coisa');

        foreach ($queryParams as &$qp) {
            $qp['usuarioCriador'] = ['nomeFantasia' => 'Matriz'];
            $qp['conta'] = ['saldoDinheiro' => 0];
            $qp['status'] = !!$qp['status'];
            $qp['bloqueado'] = !!$qp['bloqueado'];
        }

        $totalUsers = count($queryParams);

        $totalPages = ceil($totalUsers / $pageSize);
        $nextPage = null;

        if ($page < $totalPages) {
            $nextPageNumber = $page + 1;
            $nextPage = sprintf(
                "%s://%s%s?page=%d&pageSize=%d",
                $_SERVER['REQUEST_SCHEME'],
                $_SERVER['HTTP_HOST'],
                $_SERVER['REQUEST_URI'],
                $nextPageNumber,
                $pageSize
            );
        }

        $res->body([
            'data' => $queryParams,
            'meta' => [
                'totalResults' => $totalUsers,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'pageSize' => $pageSize,
                'nextPage' => $nextPage,
            ],
        ]);
    } catch (Exception $error) {
        error_log("Erro ao pesquisar usuários: " . $error->getMessage());
        $res->status(500);
        $res->body(['error' => 'Erro ao pesquisar usuários']);
    }
});
