<?php 

/**
 * MyDB Class
 *
 * @category  Database Utility class
 * @author    Uzaif Nilger <jcampbell@ajillion.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/
class MyDB extends MySQLi
{
	protected $query;
	protected $host;
	protected $user;
	protected $password;
	protected $database;
	
	public function __construct($config=[])
    {
        $this -> host = $config['host'];
        $this -> user = $config['user'];
        $this -> password = $config['password'];
        $this -> database = $config['database'];
        $this -> connect_me();
    }
    private function connect_me()
    {
        $this -> connection = $this-> connect($this->host,$this->user,$this->password,$this->database);
        if( $this -> connect_error )
            die($this->connect_error);
    }
    private function extracts($data) 
    {
        $column = array("","");
        foreach ($data as $index => $details)
        {
            $column[0].= $index.",";
			$details=is_string($details) ? "'".$this->real_escape_string($details)."'" : $details;
            $column[1].=$details.",";
        }
        $column[0] = rtrim($column[0],",");
        $column[1] = rtrim($column[1],",");
        return $column;
    }
    private function append($data) 
    {
        $string = "";
        foreach($data as $index => $details)
        {
			
			$details=is_string($details) ? "'".$this->real_escape_string($details)."'" : $details;
            $string.= $index."=".$this -> real_escape_string($details).",";
        }
        $string = rtrim($string,",");
        return $string;
    }
	
	
	/**
	* 	This function is made for Insert  Data in Table
	* 	@param $table is used for in which  table we want to Insert Data
	* 	@param $data is used for passing data into table
	*		
	*		eg:$db->insert("users",array(
	*		"username"=>"Mark",
	*		"password"=>md5($password),
	*		"email"=>"uz@myownmail.com"));
	*/
    public function insert($table,$data)
    {
        $extracted = $this -> extracts($data);
		
		//echo 	"INSERT INTO ".$table." (".$extracted[0].") VALUES(".$extracted[1].")";
		
        $this -> query("INSERT INTO ".$table." (".$extracted[0].") VALUES(".$extracted[1].")");
        if($this -> error)
            return $this -> error;
        else
            return $this -> insert_id;
    }
	
	/**
	* 	This function is made for Update Data in Table
	* 	@param $table is used for defined table name
	* 	@param $data is used for defined data want to Update in table
	* 	@param $where is used as defined where to update Data in table;
	*		
	*		eg:$db->update("users",array(
	*		"username"=>"Mark",
	*		"email"=>"mark@mail.com"
	*		"age"=>21),
	*		"id=5")
	*/
    public function update($table,$data,$where)
    {
        $extracted = $this -> append($data);
       // $sql="UPDATE ".$table." SET ".$extracted." WHERE ".$where;
		$this -> query("UPDATE ".$table." SET ".$extracted." WHERE ".$where);
		
		if($this -> error)
            return $this -> error;
    }
    public function select($table,$column = "",$where = 1,$orderby = "",$limit = "")
    {
        if($column == "")
            $column='*';
        if($orderby == "")
            $orderby = 'NULL';
        if($limit != "")
        {
            $limit = "LIMIT ".$limit;
        }
        $result = $this -> query("SELECT ".$column." FROM ".$table." WHERE ".$where." ORDER BY ".$orderby."".$limit."");
        if($this -> error)
        {
            return $this -> error;
        }
        else
        {
           $data=array();
            while($row = $result -> fetch_assoc())
            {
                $data[] = $row;
            }
            return $data;
        }
    }
    public function delete($table,$where)
    {
        $this -> query("DELETE FROM ".$table." WHERE ".$where."");
        if($this -> error)
        {
            return $this -> error;
        }
        else
        {
            return true;
        }
    }
	
	/**
	*	This function is Used For Running any Kind of Raw Sql query 
	*	Query Which We will run directly in SQL
	*  eg . SELECT count(empname) from emp
	*
	*/
	
	public function sql($query)
	{
		$this->query=$query;
		$stmt=$this->prepareQuery();
		$stmt->execute();
		$data=$this->bindResult($stmt);
		return $data;
	}
	
	/**
	*Get All the Record From the Table
	*
	*/
	
	public function get($table)
	{
		$query="SELECT *from $table";
		return $this->sql($query);
	}
	
	protected function bindResult($stmt)
	{
		$param=array();
		$result=array();
		$meta=$stmt->result_metadata();
		
		
		while($field=$meta->fetch_field())
		{
			$param[]=&$row[$field->name];
		}
		call_user_func_array(array($stmt,"bind_result"),$param);
		while($stmt->fetch())
		{	$x=array();
			foreach($row as $key => $val)
			{
				$x[$key]=$val;
			}
			$result[]=$x;
		}
		
		return $result;
	}
	
	protected function prepareQuery()
	{
		if(!$stmt=$this->prepare($this->query))
		{
			trigger_error("Problem Prepare an Query",E_USER_ERROR);
		}
		return $stmt;
	}

}
