<?php

use Core\Request;
use Core\Response;


global $router;
global $model;

$router->post('/planos/criar-plano', function(Request $req, Response $res) use ($model) {    
    try {        
        $nomePlano = $req->get('nomePlano') ?? '';
        $tipoDoPlano = $req->get('tipoDoPlano') ?? '';
        $taxaInscricao = $req->get('taxaInscricao') ?? '';
        $taxaComissao = $req->get('taxaComissao') ?? '';
        $taxaManutencaoAnual = $req->get('taxaManutencaoAnual') ?? '';

        
        //$planoExistente = $model->select('Plano', 'nomePlano = ?', [$nomePlano]);
        $planoExistente = $model->query("SELECT * FROM Plano WHERE nomePlano = :nomePlano", [':nomePlano' => $nomePlano]);
        
        if (!empty($planoExistente)) {
            return $res->status(400)->json(['error' => 'Já existe um plano com o mesmo nome.']);
        }
        
        
        $novoPlano = $model->insert('Plano', [
            'nomePlano' => $nomePlano,
            'tipoDoPlano' => $tipoDoPlano,
            'taxaInscricao' => $taxaInscricao,
            'taxaComissao' => $taxaComissao,
            'taxaManutencaoAnual' => $taxaManutencaoAnual,
        ]);

        //var_dump($novoPlano); die('no céu tem pão');

        return $res->status(201)->json($novoPlano);
    } catch (\Exception $e) {
        error_log($e->getMessage());
        return $res->status(500)->json(['error' => 'Erro interno do servidor.']);
    }
});

$router->get('/planos/listar-planos', function(Request $req, Response $res) use ($model) {
    try {
        $page = (int)$req->get('page');        
        $pageSize = (int)$req->get('pageSize');
        $offset = ($page - 1) * $pageSize;
        
        $totalItems = $model->query("SELECT COUNT(*) as total FROM Plano");
        //$totalPages = ceil($totalItems / $pageSize);
        
        $planos = $model->query("
        SELECT * FROM Plano"
        );

        $planos['contas'] = [];

        $contas = $model->query("
        SELECT * FROM Conta"
        );

        $planosComContas = [];

        foreach ($planos as $p) {
            foreach ($contas as $c) {
                if ($p['idPlano'] == $c['planoId']) {                    
                    $p['contas'] = $c;
                }
            }
            $planosComContas[] = $p;
        }
        
        $planos = $planosComContas;
        
        //var_dump($planos); die();
        
        $metadata = [
            'page' => $page,
            'pageSize' => $pageSize,
            'totalItems' => (int)$totalItems,
            'totalPages' => (int)$totalPages,
        ];        
        
        return $res->status(200)->body(['planos' => $planos, 'metadata' => $metadata]);
    } catch (\Exception $e) {
        error_log($e->getMessage());
        return $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->post("/atribuir-plano/{idConta}/{idPlano}", function(Request $req, Response $res) use ($model) {
    try {
        $idConta = (int)$req->get('idConta');
        $idPlano = (int)$req->get('idPlano');

        $conta = $model->select('conta', 'idConta = ?', [$idConta]);
        $plano = $model->select('plano', 'idPlano = ?', [$idPlano]);

        if (empty($conta) || empty($plano)) {
            return $res->status(404)->body(['error' => 'Conta ou plano não encontrados.']);
        }

        $contaAtualizada = $model->update('conta', ['planoId' => $idPlano], 'idConta = ?', [$idConta]);

        if ($contaAtualizada) {
            $contaAtualizada = $model->select('conta', 'idConta = ?', [$idConta]); // Obter conta atualizada com detalhes
            return $res->status(200)->body($contaAtualizada);
        } else {
            return $res->status(500)->body(['error' => 'Erro ao atualizar a conta.']);
        }
    } catch (\Exception $e) {
        error_log($e->getMessage());
        return $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->post("/remover-plano/{idConta}", function(Request $req, Response $res) use ($model) {
    try {
        $idConta = (int)$req->get('idConta');

        $conta = $model->select('conta', 'idConta = ?', [$idConta]);
        if (empty($conta)) {
            return $res->status(404)->body(['error' => 'Conta não encontrada.']);
        }

        $contaAtualizada = $model->update('conta', ['planoId' => null], 'idConta = ?', [$idConta]);

        $usuario = $model->select('usuario', 'idUsuario = ?', [$conta[0]['usuarioId']]);
        
        $contaAtualizada['usuario'] = $usuario;

        return $res->status(200)->body($contaAtualizada);
    } catch (\Exception $e) {
        error_log($e->getMessage());
        return $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

$router->put("/atualizar-plano/{id}", function(Request $req, Response $res) use ($model) {
    try {
        $id = (int)$req->get('id');
        $dadosAtualizados = json_decode($req->getBody(), true);

        $planoAtualizado = $model->update('plano', $dadosAtualizados, 'idPlano = :id', ['id' => $id]);

        if ($planoAtualizado) {
            $res->status(200)->body($planoAtualizado);
        } else {
            $res->status(404)->body(['error' => 'Plano não encontrado.']);
        }
    } catch (\Exception $e) {
        error_log($e->getMessage());
        $res->status(500)->body(['error' => 'Erro interno do servidor.']);
    }
});

