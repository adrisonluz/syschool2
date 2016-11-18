<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Boleto\Banco\Santander;
use App\Boleto\Agente;
use App\Usuario;

class BoletoDoc extends Model {

    public $usuario_id;
    public $dataEmissao;
    public $dataVencimento;
    public $valor;
    public $desconto;
    public $seq;
    public $descDemo = array();

    public function SetUsuarioID($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function SetDataEmissao($dataEmissao) {
        $this->dataEmissao = $dataEmissao;
    }

    public function SetDataVencimento($dataVencimento) {
        $this->dataVencimento = $dataVencimento;
    }

    public function SetValor($valor) {
        $this->valor = $valor;
    }

    public function SetDesconto($valor) {
        $this->desconto = $valor;
    }

    public function SetSeq($seq) {
        $this->seq = $seq;
    }

    public function SetDescDemo($descDemo) {
        $this->descDemo = $descDemo;
    }

    public function emitirBoleto() {
        if ($usuario = Usuario::find($this->usuario_id)) {
            $usuario = Usuario::find($this->usuario_id);
        } else {
            $usuario = objectValue();
            $usuario->nome = 'não declarado';
            $usuario->boleto_nome = 'não declarado';
            $usuario->id = 00;
            $usuario->endereco = '';
            $usuario->cep = '';
            $usuario->bairro = '';
            $usuario->cidade = 'Porto Alegre / RS';
        }
        $sacado = new Agente($usuario->nome, $usuario->boleto_nome . ' - Código: ' . $usuario->id, $usuario->endereco, $usuario->cep, $usuario->bairro, $usuario->cidade);
        $cedente = new Agente('Aline Rosa ME', '00714970000159', 'Av Assis Brasil', '71000-000', 'Porto Alegre', 'RS');

        $data = substr($this->dataVencimento, 6, 4) . "-" . substr($this->dataVencimento, 3, 2) . "-" . substr($this->dataVencimento, 0, 2);

        $boleto = new Santander(array(
            // Parâmetros obrigatórios

            'dataVencimento' => new \DateTime($data),
            'valor' => $this->valor,
            'sequencial' => $this->seq, // Até 13 dígitos
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => 2088, // Até 4 dígitos
            'carteira' => 102, // 101, 102 ou 201
            'conta' => 5452295, // Código do cedente: Até 7 dígitos
            // IOS – Seguradoras (Se 7% informar 7. Limitado a 9%)
            // Demais clientes usar 0 (zero)
            'ios' => '0', // Apenas para o Santander
            // Parâmetros recomendáveis
            //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
            //'contaDv' => 5,
            'agenciaDv' => 5,
            'descricaoDemonstrativo' => $this->descDemo,
            'instrucoes' => array(// Até 8
                'Cobrar Mora diária de R$ 0,00',
                'Cobrar 2% de multa a partir de ' . $this->dataVencimento,
                'Protestar após 30 dias corridos',
                'Após o vencimento o doc deverá ser pago',
                'apenas no Banco Santander.',
            ),
            // Parâmetros opcionais
            //'resourcePath' => '../resources',
            //'moeda' => Santander::MOEDA_REAL,
            'dataDocumento' => new \DateTime(date('Y-m-d', strtotime($this->dataEmissao))),
            'dataProcessamento' => new \DateTime(date('Y-m-d', strtotime($this->dataEmissao))),
            //'contraApresentacao' => true,
            //'pagamentoMinimo' => 23.00,
            'aceite' => 'N',
            'especieDoc' => 'DS',
            'numeroDocumento' => '42',
            //'usoBanco' => 'Uso banco',
            //'layout' => 'layout.phtml',
            //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
            //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
            'descontosAbatimentos' => $this->desconto,
                //'moraMulta' => 123.12,
                //'outrasDeducoes' => 123.12,
                //'outrosAcrescimos' => 123.12,
                //'valorCobrado' => 123.12,
                //'valorUnitario' => 123.12,
                //'quantidade' => 1,
        ));

        echo $boleto->getOutput();
    }

}
