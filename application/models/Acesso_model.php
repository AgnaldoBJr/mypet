<?php
  if(!defined('BASEPATH')) exit('No direct script access allowed');
  /***************************************************************************************
  * Class: Acesso_model
  * 
  * Description: Classe modelo para buscar os emails no Banco de Dados para serem validados no
  * login.
  *
  *   Author: Agnaldo Burgo Junior
  * Created at: Fev/2019
  *
  *****************************************************************************************/
  class Acesso_model extends CI_Model{

    function __construct() {
      parent::__construct();
    }

    function readEmail($data){

      $this->db->select('*')->from('usuarios')->where('email', $data['email'])->limit(1);
      $results = $this->db->get()->result();
      return $results;
    
    }

    function readEmailWeb($data){

      $this->db->select('*')->from('clientes')->where('email', $data['email'])->limit(1);
      $results = $this->db->get()->result();
      return $results;
    
    }  
  }
