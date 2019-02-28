<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');
  /**********************************************************************************************
  * Class: Acesso_model
  * 
  * Description: Classe genérica que faz a parte do Model no MVC, esta classe é responsável por
  * gerenciar todas as transações no banco de dados de inserção, listagem, alteração e exclusão.
  * Para quase todos os métodos, são recebidos as tables, os campos de chave primeira e condições  
  * WHERE escolhidas
  *
  * Author: Agnaldo Burgo Junior
  * Created at: Fev/2019
  *
  ************************************************************************************************/
	class Generic_model extends CI_Model{
		function __construct(){
		  parent::__construct();
		}

		function insert($table, $campoId, $data){
			$this->db->insert($table, $data);
     
      $lastRegisterId = $this->db->insert_id();
      		
    	if($lastRegisterId){	
        return $this->toArray($this->readById($table, $campoId, $lastRegisterId));
   		}
  		else {
    		return false;
  		}
		}

		function readById($table, $campoId, $id){
			$this->db->select('*')->from($table)->where($campoId, $id);
      
      $result = $this->db->get()->result();

  		if($result){
        foreach ($result as $resultado) {
          $res[] = $this->toArray($resultado);
        }
        return $res[0];
      }
      else {
        return false;
      }
		}

		function readAll($table){
			$this->db->select('*')->from($table);
      		
      $result = $this->db->get()->result();
          
      if($result){
  		  foreach ($result as $resultado) {
    		  $res[] = $this->toArray($resultado);
  		  }
     		return $res;
    	}
  		else {
    		return false;
  		}
    }

    function readAllWhere($table, $campoId, $id){
      $this->db->select('*')->from($table)->where($campoId, $id);
          
      $result = $this->db->get()->result();
          
      if($result){
        foreach ($result as $resultado) {
          $res[] = $this->toArray($resultado);
        }
        return $res;
      }
      else {
        return false;
      }
    }

		function update($table, $campoId, $id, $data){
			$this->db->where($campoId, $id);
      		
      $result = $this->db->update($table, $data);

      if($result)
      	return true;
      
      return false;
		}

		function delete($table, $campoId, $id){
			$this->db->where($campoId, $id); 
			
      $result = $this->db->delete($table);

			if($result)
      	return true;
      
      return false;
		}

		function readAndProjection($table, $camposDeProjecao){
			$this->db->select($camposDeProjecao)->from($table);
      
      $result = $this->db->get()->result();
      
      if($result == null){
        return false;
      }
          
      foreach ($result as $resultado) {
        $res[] = $this->toArray($resultado);
      }

  		if($res){
    		return $res;
    	}
  		else {
    		return false;
  		}
		}

    function readAndProjectionById($campos, $tables, $where){
      $sql = 'SELECT ' . $campos . ' FROM ' . $tables . ' WHERE ' . $where;

      $query = $this->db->query($sql);
      return $query->result_array(); 
    }

    function readAndProjectionManyTables($campos, $tables, $where){
      $sql = 'SELECT ' . $campos . ' FROM ' . $tables . ' WHERE ' . $where;

      $query = $this->db->query($sql);
      return $query->result_array(); 

    }

    function readAndProjectionOrderBy($campos, $tables, $where, $columns){
      $sql = 'SELECT ' . $campos . ' FROM ' . $tables . ' WHERE ' . $where . ' ORDER BY ' . $columns;
      
      $query = $this->db->query($sql);
      return $query->result_array(); 

    }

    function justQuery($sql){
      $query = $this->db->query($sql);
      
      return $query->result_array(); 

    }

		function toArray($obj){
			$reaged = (array) $obj;
      	
      foreach($reaged as $key => &$field){
      	if(is_object($field))
      		$field = toArray($field);
  		
      }
      return $reaged;
		}

    function lastInsert($table, $campoId){
      $this->db->select_max($campoId);
      
      $result= $this->db->get($table)->row_array();
      
      return $result[$campoId];    
    }


    





	}