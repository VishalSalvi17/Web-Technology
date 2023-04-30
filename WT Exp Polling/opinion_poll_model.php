<?php
	class Opinion_poll_model {
		private $db_connection;
		private $host = 'localhost';
		private $db_name = 'database';
		private $u_name = 'vishal';
		private $password = '';

		public function __construct() {
			// Connecting to MySQL server
			$this->db_connection = mysqli_connect($this->host, $this->u_name, $this->password);
			if (!$this->db_connection)
				die("MySQL connection error:  " .mysqli_error($this->db_connection));
			if (!mysqli_select_db($this->db_connection, $this->db_name))
				die("Database selection error: " .mysqli_error($this->db_connection));
		}

		private function execute_query($sql_stmt) {
			// SQL statement execution
			$result = mysqli_query($this->db_connection, $sql_stmt);
			return !$result ? FALSE : TRUE;
		}

		public function select($sql_stmt) {
			$result = mysqli_query($this->db_connection, $sql_stmt);
			if (!$result)
				die("Database access error: " .mysqli_error($this->db_connection));
			$rows = mysqli_num_rows($result);
			$data = array();
			if ($rows)
				while ($row = mysqli_fetch_array($result))
					$data = $row;
			return $data;
		}

		public function insert($sql_stmt) {
			return $this->execute_query($sql_stmt);
		}

		public function __destruct(){
			mysqli_close($this->db_connection);
		}
	}
?>