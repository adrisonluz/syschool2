<?php

if (!function_exists('getIdade')) {

    function getIdade($data) {
        list($dia, $mes, $ano) = explode('/', $data);
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        return $idade;
    }

}

if(!function_exists('consultaCEP')) {

    function consultaCEP($cep = ''){
        $reg = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);

        $dados['sucesso'] = (string) $reg->resultado;
        $dados['rua']     = (string) $reg->tipo_logradouro . ' ' . $reg->logradouro;
        $dados['bairro']  = (string) $reg->bairro;
        $dados['cidade']  = (string) $reg->cidade;
        $dados['estado']  = (string) $reg->uf;

        echo json_encode($dados);
    }
}


if(!function_exists('data')){

    function data($data, $inverte = true){
	$format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';

        switch($inverte){
            case true:
                $dataFormatada = date('d/m/Y', strtotime($data));
                return $dataFormatada;
                break;
            case false:
                if ($data != null && preg_match($format, $data, $partes)) {
                        return $partes[3].'-'.$partes[2].'-'.$partes[1];
                }
                break;
        }
    }
}

if (!function_exists('getDiaSemana')) {

    function getDiaSemana($dia) {
        $semanaArray = [
            'Sun' => 'domingo',
            'Mon' => 'segunda',
            'Tue' => 'terça',
            'Wed' => 'quarta',
            'Thu' => 'quinta',
            'Fri' => 'sexta',
            'Sat' => 'sábado'
        ];

        return $semanaArray[$dia];
    }

}

/**
* Função para gerar url amigável
*/
if (! function_exists('setUri')) {

  function setUri($string){
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
		$string = utf8_decode($string);
		$string = strtr($string, utf8_decode($a), $b);
		$string = strip_tags(trim($string));
		$string = str_replace(" ","-",$string);
		$string = str_replace(array("-----","----","---","--"),"-",$string);
		return strtolower(utf8_encode($string));
  }
}

/**
* Função para gerar resumos
*/
if (! function_exists('lmWord')) {
  function lmWord($string, $words = '100'){
    $string 	= strip_tags($string);
    $count		= strlen($string);

    if($count <= $words){
      return $string;
    }else{
      $strpos = strrpos(substr($string,0,$words),' ');
      return substr($string,0,$strpos).' ...';
    }

  }
}
