<?php

class Pagination extends Dbh{

	private $sqlQuery;
	private $limit;
	private $offset;
	
	function __construct($sql,$limit,$offset)
	{		
		$this->sqlQuery=$sql;
		$this->limit=$limit;
		$this->offset=$offset;
 
	}
         
	public function  get(){
		$result=$this->connect()->query($this->sqlQuery." limit ".$this->limit." offset ".$this->offset);
		$numRows=$result->num_rows;
		if($numRows>0){
			while($row=$result->fetch_assoc()){
				$data[]=$row;
		}
		return $data;
	    } 
	} 	
	public 	function pageNumber($sqli){
		       $result=$this->connect()->query($sqli);
		       $numRows=$result->num_rows;
		       if($numRows>0){
			       while($row=$result->fetch_assoc()){
				       $data[]=$row;
		       }
		       return (count($data))/$this->limit;
		      
		   } 
	   		
}
}
?>