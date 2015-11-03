<?php 

/**
 * MyDB Class
 *
 * @category  Database Utility class
 * @author    Uzaif Nilger 
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/
class MyDB extends MySQLi {
	protected $query;
	protected $host;
	protected $user;
	protected $password;
	protected $database;
	public static $db;
	public function __construct($config = []) {
		$this->host = $config ['host'];
		$this->user = $config ['user'];
		$this->password = $config ['password'];
		$this->database = $config ['database'];
		$this->connect_me ();
	}
	protected function connect_me() {
		$this->connection = $this->connect ( $this->host, $this->user, $this->password, $this->database );
		self::$db = $this->connection;
		if ($this->connect_error)
			die ( $this->connect_error );
	}
	

	/**
	 * This function is made for Insert Data in Table
	 * 
	 * @param $table is
	 *        	used for in which table we want to Insert Data
	 * @param $data is
	 *        	used for passing data into table
	 *        	
	 *        	eg:$db->insert("users",array(
	 *        	"username"=>"Mark",
	 *        	"password"=>md5($password),
	 *        	"email"=>"uz@myownmail.com"));
	 */
	public function insert($table, $data) {
		$extracted = $this->extracts ( $data );
		$this->query ( "INSERT INTO " . $table . " (" . $extracted [0] . ") VALUES(" . $extracted [1] . ")" );
		if ($this->error)
			return $this->error;
		else
			return $this->insert_id;
	}
	
	/**
	 * This function is made for Update Data in Table
	 * 
	 * @param $table is
	 *        	used for defined table name
	 * @param $data is
	 *        	used for defined data want to Update in table
	 * @param $where is
	 *        	used as defined where to update Data in table;
	 *        	
	 *        	eg:$db->update("users",array(
	 *        	"username"=>"Mark",
	 *        	"email"=>"mark@mail.com"
	 *        	"age"=>21),
	 *        	"id=5")
	 */
	public function update($table, $data, $where) {
		$extracted = $this->append ( $data );
		$this->query ( "UPDATE " . $table . " SET " . $extracted . " WHERE " . $where );
		
		if ($this->error)
			return $this->error;
	}
	public function delete($table, $where) {
		$this->query ( "DELETE FROM " . $table . " WHERE " . $where . "" );
		if ($this->error) {
			return $this->error;
		} else {
			return true;
		}
	}
	
	/**
	 * This function is Used For Running any Kind of Raw Sql query
	 * Query Which We will run directly in SQL
	 * eg .
	 * SELECT count(empname) from emp
	 */
	public function sql($query) {
		$data = array ();
		if ($result = $this->query ( $query )) {
			while ( $row = $result->fetch_assoc () ) {
				$data [] = $row;
			}
		}
		return $data;
	}
	
	private function extracts($data) {
		$column = array (
				"",
				""
		);
		foreach ( $data as $index => $details ) {
			$column [0] .= $index . ",";
			$details = is_string ( $details ) ? "'" . $this->real_escape_string ( $details ) . "'" : $details;
			$column [1] .= $details . ",";
		}
		$column [0] = rtrim ( $column [0], "," );
		$column [1] = rtrim ( $column [1], "," );
		return $column;
	}
	private function append($data) {
		$string = "";
		foreach ( $data as $index => $details ) {
				
			$details = is_string ( $details ) ? "'" . $this->real_escape_string ( $details ) . "'" : $details;
			$string .= $index . "=" . $details . ",";
		}
		$string = rtrim ( $string, "," );
		return $string;
	}
	
	
	/**
	 * Get All the Record From the Table
	 */
	public function get($table) {
		$query = "SELECT *from $table";
		return $this->sql ( $query );
	}
}
