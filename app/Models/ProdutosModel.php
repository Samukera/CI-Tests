<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutosModel extends Model
{
    protected $table = 'produtos';

    protected $primaryKey = 'id';

    protected $allowedFields = ['nome', 'valor'];

    protected $validationRules = [
        'nome' => 'required|min_length[3]|is_unique[produtos.nome]'
    ];
}
