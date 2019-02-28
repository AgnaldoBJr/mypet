<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


	/****************************************
	****    FUNÇÕES: GENÉRICAS    ***********
	*****************************************/
 
 	//Função para formatar data no formato aaaa-mm-dd
 	//Recebe como parâmetro uma data no formato brasileiro dd/mm/aaaa
	if (!function_exists('formataDataDb')){
		function formataDataDb($data){
			$datas = explode("/", $data);
			$novaData = $datas[1] . '/' . $datas[0] .'/'. $datas[2]; 

			$time = strtotime($novaData);
			$newformat = date('Y-m-d', $time);
			return $newformat;
		}
	}

	//Função para formatar data no formato brasileiro dd/mm/aaaa
 	//Recebe como parâmetro uma data no formato aaaa-mm-dd
	if (!function_exists('formataDataBr')){
		function formataDataBr($data){
			$data = explode('-', $data);
			$data = $data[2] . '/' . $data[1] . '/' . $data[0]; 

			return $data;	
		}
	}
