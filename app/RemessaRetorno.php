<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cnab;
use Illuminate\Support\Facades\Storage;

class RemessaRetorno extends Model {

    protected $table = 'remessasretornos';
    public $timestamps = false;

    /**
     * Boletos relacionados com a remessa ou retorno em questão
     */
    public function boletos() {
        return $this->hasMany('App\Boleto');
    }

    //Configuração padrão do arquivo remesssa
    public function remessaConfig() {
        $codigo_banco = Cnab\Banco::SANTANDER;
        $arquivo = new Cnab\Remessa\Cnab400\Arquivo($codigo_banco);
        $arquivo->configure(array(
            'data_geracao' => new \DateTime(),
            'data_gravacao' => new \DateTime(),
            'nome_fantasia' => 'Escola de dança Aline Rosa', // seu nome de empresa
            'razao_social' => 'Aline Rosa ME', // sua razão social
            'cnpj' => '00714970000159', // seu cnpj completo
            'banco' => $codigo_banco, //código do banco
            'logradouro' => 'Av Assis Brasil',
            'numero' => '',
            'bairro' => 'Passo D\'Areia',
            'cidade' => 'Porto Alegre',
            'uf' => 'RS',
            'cep' => '71000-000',
            'agencia' => '2088',
            'conta' => '54522', // número da conta
            'conta_dac' => '9', //5 digito da conta
        ));

        return $arquivo;
    }

    //Insere boleto no arquivo remessa
    public function remessaInsere($boleto) {
        if ($boleto->usuario !== null) {
            $sacado = $boleto->usuario;
        } else {
            $sacado = objectValue();

            $sacado->nome = 'não declarado';
            $sacado->boleto_cpf = '00000000000';
            $sacado->bairro = '';
            $sacado->cidade = 'Porto Alegre';
            $sacado->cep = '9110000';
        }

        $remessaInsere = array(
            'codigo_ocorrencia' => 1, // 1 = Entrada de título, futuramente poderemos ter uma constante
            'nosso_numero' => '1234567',
            'numero_documento' => '42',
            'carteira' => '109',
            'especie' => Cnab\Especie::CNAB240_OUTROS, // Você pode consultar as especies Cnab\Especie
            'valor' => $boleto->valor, // Valor do boleto
            'instrucao1' => 2, // 1 = Protestar com (Prazo) dias, 2 = Devolver após (Prazo) dias, futuramente poderemos ter uma constante
            'instrucao2' => 0, // preenchido com zeros
            'sacado_nome' => $sacado->nome, // O Sacado é o cliente, preste atenção nos campos abaixo
            'sacado_tipo' => 'cpf', //campo fixo, escreva 'cpf' (sim as letras cpf) se for pessoa fisica, cnpj se for pessoa juridica
            'sacado_cpf' => $sacado->boleto_cpf,
            'sacado_logradouro' => $sacado->nome,
            'sacado_bairro' => $sacado->bairro,
            'sacado_cep' => $sacado->cep, // sem hífem
            'sacado_cidade' => $sacado->cidade,
            'sacado_uf' => 'RS',
            'data_vencimento' => new \DateTime($boleto->data_vencimento),
            'data_cadastro' => new \DateTime($boleto->data_emissao),
            'juros_de_um_dia' => 0.10, // Valor do juros de 1 dia'
            'data_desconto' => new \DateTime('2014-06-01'),
            'valor_desconto' => 10.0, // Valor do desconto
            'prazo' => 10, // prazo de dias para o cliente pagar após o vencimento
            'taxa_de_permanencia' => '0', //00 = Acata Comissão por Dia (recomendável), 51 Acata Condições de Cadastramento na CAIXA
            'mensagem' => 'Descrição do boleto',
            'data_multa' => new \DateTime('2014-06-09'), // data da multa
            'valor_multa' => ($boleto->data_vencimento) * 0.02, // valor da multa
        );

        return $remessaInsere;
    }

    // Gera arquivo remessa
    public function remessa($id_boleto, $id_remessa) {
        $arquivo = $this->remessaConfig();

        if (is_array($id_boleto)) {
            foreach ($id_boleto as $id) {
                $boleto = Boleto::find($id);
                $remessaInsere = $this->remessaInsere($boleto);
                $arquivo->insertDetalhe($remessaInsere);

                $boleto->remessaretorno_id = $id_remessa;
                $boleto->save();
            }
        } else {
            $boleto = Boleto::find($id_boleto);
            $remessaInsere = $this->remessaInsere($boleto);
            $arquivo->insertDetalhe($remessaInsere);
        }

        Storage::disk('remessa-retorno')->put('remessas/remessa_' . date('dmY') . '.txt', $arquivo->getText());
    }

    public function retorno($arquivo) {
        $cnabFactory = new Cnab\Factory();
        $arquivo = $cnabFactory->createRetorno($arquivo);
        $detalhes = $arquivo->listDetalhes();
        foreach ($detalhes as $detalhe) {
            if ($detalhe->getValorRecebido() > 0) {
                $nossoNumero = $detalhe->getNossoNumero();
                $valorRecebido = $detalhe->getValorRecebido();
                $dataPagamento = $detalhe->getDataOcorrencia();
                $carteira = $detalhe->getCarteira();
                // você já tem as informações, pode dar baixa no boleto aqui
            }
        }
    }

}
