<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class Produtos extends ResourceController
{
    private $produtoModel;
    // private $token = 'mysecret'; //exemplo didático

    public function __construct()
    {
        $this->produtoModel = new \App\Models\ProdutosModel();
    }

    private function _validaToken()
    {
        return $this->request->getHeaderLine('token') == $this->token;
    }

    //GET ListaProdutos()
    public function list()
    {
        $data = $this->produtoModel->findAll();

        return $this->response->setJSON($data);
    }

    //POST inserir produtos()
    public function create()
    {
        $response = [];

        if ($this->_validaToken()) {
            $newProduto['nome'] = $this->request->getPost('nome');
            $newProduto['valor'] = $this->request->getPost('valor');

            try {
                if ($this->produtoModel->insert($newProduto)) {
                    $response = [
                        'status' => 'success',
                        'message' => 'created product'
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'erros' => $this->produtoModel->errors()
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'status' => 'error',
                    'erros' => $e
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid Token'
            ];
        }
        return $this->response->setJSON($response);
    }
}
