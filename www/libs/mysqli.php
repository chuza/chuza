<?php
	// IMPORTANT: this is a reduced version of ezdb1.php
	// Its purpose is SPEED, only SPEED, use ezdb1.php if you want debug information.
	// YOU HAVE BEEEN WARNED. 
	//				-- ricardo galli
	//
	// ==================================================================
	//  Author: Justin Vincent (justin@visunet.ie)
	//	Web: 	http://php.justinvincent.com
	//	Name: 	ezSQL
	// 	Desc: 	Class to make it very easy to deal with mySQL database connections.
	//
	// !! IMPORTANT !!
	//
	//  Please send me a mail telling me what you think of ezSQL
	//  and what your using it for!! Cheers. [ justin@visunet.ie ]
	//
	// ==================================================================
	// User Settings -- CHANGE HERE

	//define("EZSQL_DB_USER", $globals['db_user']);			// <-- mysql db user
	//define("EZSQL_DB_PASSWORD", $globals['db_password']);		// <-- mysql db password
	//define("EZSQL_DB_NAME", $globals['db_name']);		// <-- mysql db pname
	//define("EZSQL_DB_HOST", $globals['db_server']);	// <-- mysql server host

	// ==================================================================
	//	The Main Class

	class db {

		var $show_errors = true;
		var $num_queries = 0;	
		var $col_info;
		var $dbuser;
		var $dbpassword;
		var $dbname;
		var $dbhost;
		var $dbmaster;
		var $persistent;
		var $master_persistent;
		var $dbh_update = false;
		var $dbh_select = false;
		var $dbh = false;


		// ==================================================================
		//	DB Constructor - connects to the server and selects a database

		function db($dbuser='', $dbpassword='', $dbname='', $dbhost='localhost', $dbmaster=false) {
			$this->dbuser = $dbuser;
			$this->dbpassword = $dbpassword;
			$this->dbname = $dbname;
			$this->dbhost = $dbhost;
			$this->dbmaster = $dbmaster;
			$this->in_transaction = 0;
			if ( $dbmaster && $dbmaster != $dbhost ) {
				$this->dbmaster = $dbmaster;
			} else {
				$this->dbmaster = false;
			}
		}

		function transaction() {
			if ($this->in_transaction == 0) {
				$this->query('SET AUTOCOMMIT=0');
      			$this->query('START TRANSACTION');
			}
			$this->in_transaction++;
			return $this->in_transaction;
		}

		function commit() {
			$this->in_transaction--;
			if ($this->in_transaction == 0) {
      			$this->query('COMMIT');
				$this->query('SET AUTOCOMMIT=1');
			}
			return $this->in_transaction;
		}

		// Reset the connection to the slave if it was using the master
		function barrier() {
			if ($this->dbh && $this->dbh !== $this->dbh_select) {
				if ($this->dbh_select) {
					$this->dbh = & $this->dbh_select;
				} else {
					$this->connect();
				}
			}
		}

		function connect($master = false) {
			if ($master && $this->dbmaster ) {
				if ($this->dbh_update) {
					$this->dbh = & $this->dbh_update;
					return;
				} else {
					if ($this->master_persistent) {
						// PHP 5.2 does not support mysqli persistent connections, so we use the standard
						//$this->dbh_update = @mysqli_connect('p:'.$this->dbmaster, $this->dbuser,$this->dbpassword);
						$this->dbh_update = @mysqli_connect($this->dbmaster, $this->dbuser,$this->dbpassword);
					} else {
						$this->dbh_update = @mysqli_connect($this->dbmaster, $this->dbuser,$this->dbpassword);
					}
					$this->dbh = & $this->dbh_update;
				}
			} else { 
				if ($this->persistent) {
					// PHP 5.2 does not support mysqli persistent connections, so we use the standard
					//$this->dbh_select = @mysqli_connect('p:'.$this->dbhost, $this->dbuser,$this->dbpassword);
					$this->dbh_select = @mysqli_connect($this->dbhost, $this->dbuser,$this->dbpassword);
				} else {
					$this->dbh_select = @mysqli_connect($this->dbhost, $this->dbuser,$this->dbpassword);
				}
				$this->dbh = & $this->dbh_select;
			}

			if ( ! $this->dbh ) {
				echo _('Error conectando a la BBDD, volvemos en unos segundos, seguramente estamos actualizando el sistema'). "\n";
				die;
			}
			mysqli_set_charset($this->dbh, 'utf8');
			if (!empty($this->dbname)) $this->select($this->dbname);
		}

		// ==================================================================
		//	Select a DB (if another one needs to be selected)

		function select($db) {
			if (!$this->dbh)  $this->connect();
			if ( !@mysqli_select_db($this->dbh, $db)) {
				$this->print_error("<ol><b>Error selecting database <u>$db</u>!</b><li>Are you sure it exists?<li>Are you sure there is a valid database connection?</ol>");
			}
		}

		// ====================================================================
		//	Format a string correctly for safe insert under all PHP conditions
		
		function escape($str) {
			if (!$this->dbh)  $this->connect();
			return mysqli_real_escape_string($this->dbh, stripslashes($str));
		}

		// ==================================================================
		//	Print SQL/DB error.

		function print_error($str = "") {
			
			// All erros go to the global error array $EZSQL_ERROR..
			global $EZSQL_ERROR;

			if (!$this->dbh)  $this->connect();
			// If no special error string then use mysql default..
			if ( !$str ) {
				$str = mysqli_error($this->dbh);
				$error_no = mysqli_errno($this->dbh);
			}
			
			// Log this error to the global array..
			$EZSQL_ERROR[] = array 
							(
								"error_str"  => $str,
								"error_no"   => $error_no
							);

			// Is error output turned on or not..
			if ( $this->show_errors ) {
				// If there is an error then take note of it
				print "<blockquote><font face=arial size=2 color=ff0000>";
				print "<b>SQL/DB Error --</b> ";
				print "[<font color=000077>$str</font>]";
				print "</font></blockquote>";
			} else {
				return false;	
			}
		}

		// ==================================================================
		//	Turn error handling on or off..

		function show_errors() {
			$this->show_errors = true;
		}
		
		function hide_errors() {
			$this->show_errors = false;
		}

		// ==================================================================
		//	Kill cached query results

		function flush() {

			// Get rid of these
			$this->last_result = null;
			$this->col_info = null;

		}

		// ==================================================================
		//	Basic Query	- see docs for more detail

		function query($query) {
			
			// For reg expressions
			$query = trim($query); 
			$is_update = preg_match("/^(insert|delete|update|replace)\s+/i",$query);

			if (!$this->dbh || ($is_update && ! $this->dbh_update !==  $this->dbh) )  $this->connect($is_update);

			
			// initialise return
			$return_val = 0;

			// Flush cached values..
			$this->flush();

			// Perform the query via std mysql_query function..
			$this->result = @mysqli_query($this->dbh, $query);
			$this->num_queries++;

			// If there is an error then take note of it..
			if ( mysqli_error($this->dbh) ) {
				$this->print_error();
				return false;
			}
			
			// Query was an insert, delete, update, replace
			if ( $is_update ) {
				$this->rows_affected = mysqli_affected_rows($this->dbh);
				
				// Take note of the insert_id
				if ( preg_match("/^(insert|replace)\s+/i",$query) ) {
					$this->insert_id = mysqli_insert_id($this->dbh);	
				}
				
				// Return number fo rows affected
				$return_val = $this->rows_affected;
			} else {
				// Store Query Results	
				$num_rows=0;
				while ( $row = @mysqli_fetch_object($this->result) ) {
					// Store relults as an objects within main array
					$this->last_result[$num_rows] = $row;
					$num_rows++;
				}

				@mysqli_free_result($this->result);

				// Log number of rows the query returned
				$this->num_rows = $num_rows;
				
				// Return number of rows selected
				$return_val = $this->num_rows;
			}

			return $return_val;
		}

		// ==================================================================
		//	Get one variable from the DB - see docs for more detail

		function get_var($query=null,$x=0,$y=0) {

			// If there is a query then perform it if not then use cached results..
			if ( $query ) {
				$this->query($query);
			}

			// Extract var out of cached results based x,y vals
			if ( $this->last_result[$y] ) {
				$values = array_values(get_object_vars($this->last_result[$y]));
			}

			// If there is a value return it else return null
			return (isset($values[$x]) && $values[$x]!=='')?$values[$x]:null;
		}

		// ==================================================================
		//	Get one row from the DB - see docs for more detail

		function get_object($query,$class) {

			if (!$this->dbh) $this->connect();

			$this->result = @mysqli_query($this->dbh, $query);
			// If there is an error then take note of it..
			if ( mysqli_error($this->dbh) ) {
				$this->print_error();
				return false;
			}
			$object = @mysqli_fetch_object($this->result, $class);
			@mysqli_free_result($this->result);

			return $object?$object:null;
		}

		function get_row($query=null,$y=0) {

			// If there is a query then perform it if not then use cached results..
			if ( $query ) {
				$this->query($query);
			}

			return $this->last_result[$y]?$this->last_result[$y]:null;
		}

		// ==================================================================
		//	Function to get 1 column from the cached result set based in X index
		// se docs for usage and info

		function get_col($query=null,$x=0) {

			// If there is a query then perform it if not then use cached results..
			if ( $query ) {
				$this->query($query);
			}

			// Extract the column values
			for ( $i=0; $i < count($this->last_result); $i++ ) {
				$new_array[$i] = $this->get_var(null,$x,$i);
			}

			return $new_array;
		}

		// ==================================================================
		// Return the the query as a result set - see docs for more details

		function get_results($query=null) {

			// If there is a query then perform it if not then use cached results..
			if ( $query ) {
				$this->query($query);
			}

			// Send back array of objects. Each row is an object
			return $this->last_result;
		}


		// ==================================================================
		// Function to get column meta data info pertaining to the last query
		// see docs for more info and usage

		function get_col_info($info_type="name",$col_offset=-1) {
			if ( $this->col_info ) {
				if ( $col_offset == -1 ) {
					$i=0;
					foreach($this->col_info as $col ) {
						$new_array[$i] = $col->{$info_type};
						$i++;
					}
					return $new_array;
				} else {
					return $this->col_info[$col_offset]->{$info_type};
				}

			}

		}
}
?>
