<?PHP
class L2jDB_Connect {
	protected $connect;

	function __construct ($host, $user, $password, $dbname, $charset, $type) {
		$type = strtolower($type);
		if (($type == 'mysql') or !isset($type) or empty($type)) {
			$this->connect = new MySQL($host, $user, $password, $dbname, $charset);
		} elseif ($type == 'postgresql') {
			$this->connect = new PostGresQL($host, $user, $password, $dbname, $charset);
		} else {
			die('Unknown database type');
		}
	}
	
	function __destruct () {
		$this->connect = null;
	}
}

class L2jDB_API extends L2jDB_Connect {
	function Insert ($tablename, $data) {
		if (!isset($data) || empty($data)) return false;
		return $this->connect->Insert($tablename, $data);
	}
	
	function Remove ($tablename, $cond) {
		return $this->connect->Remove($tablename, $cond);
	}
	
	function Select ($tablename, $cond) {
		return $this->connect->Select($tablename, $cond);
	}
	function Update ($tablename, $data, $cond) {
		if (!isset($data) || empty($data)) return false;
		if (!isset($cond) || empty($cond)) return false;
		return $this->connect->Update($tablename, $data, $cond);
	}
	
	function CountOF($tablename) {
		$query = "SELECT COUNT(*) FROM `$tablename`";
		return sizeof($this->Executive($query));
	}
	
	function Executive ($query) {
		if (!isset($query) || empty($query)) return false;
		return $this->connect->Executive($query);
	}
}

class MySQL {
	private $connection;
	
	/* 
	 * Подключение к MySQL
	 * Соединение с БД является защищенным и доступным только классу
	 * При создание класса передаются параметры подключения
	 */
	function __construct ($host, $user, $password, $dbname, $charset) {
		$this->connection = mysql_connect($host,$user,$password);
		mysql_select_db($dbname);
		mysql_set_charset($charset);
	}

	/*
	 * Функция вставки в таблицу
	 * Принимает параметры: имя таблицы и ассоциативный массив данных
	 */
	function Insert ($tablename, $data) {
		$query = 'INSERT INTO `[tablename]` ([keys]) VALUES ([vals])';

		$keys = ''; $values = '';
		foreach ($data AS $key => $value) {
			$keys .= '`'.$key.'`, ';
			$values .= "'".$value."', ";
		}

		$replacement = array(
			'[keys]' => $keys,
			'[vals]' => $values,
			'[tablename]' => $tablename
		);
		$replacement2 = array(
			"', )" => "')",
			'`, )' => '`)'
		);

		$query = str_replace(array_keys($replacement), array_values($replacement), $query);
		$query = str_replace(array_keys($replacement2), array_values($replacement2), $query);

		return mysql_query($query);
	}
	
	/* 
	 * Функция удаления и выборки записей из БД
	 * Принимает параметры: имя таблицы, ассоциативный массив условий
	 */
	private function DelSelect($type, $tablename, $cond) {
		$query = "[type] FROM `[tablename]` WHERE ([cond])";

		$conds = "";
		if (isset($cond) & !empty($cond))
		foreach ($cond AS $key => $value) {
			$conds .= "`".$key."`"."="."'".$value."', ";
		}
		
		$replacement = array(
			'[tablename]' => $tablename,
			'[cond]' => $conds,
			'[type]' => $type
		);
		$replacement2 = array(
			"', )" => "')",
			'WHERE ()' => ''
		);

		$query = str_replace(array_keys($replacement), array_values($replacement), $query);
		$query = str_replace(array_keys($replacement2), array_values($replacement2), $query);

		return mysql_query($query);
	}

	function Remove ($tablename, $cond) {
		return $this->DelSelect("DELETE", $tablename, $cond);
	}
	function Select ($tablename, $cond) {
		$res = $this->DelSelect("SELECT *", $tablename, $cond);
		$badass = array();
		if ($res) while ($td = mysql_fetch_assoc($res)) {
			$badass[] = $td;
		}
		mysql_free_result($res);
		return $badass;
	}
	
	/* 
	 * Функция обновления записей в БД
	 * Принимает параметры: имя таблицы, ассоциативный массив данных, ассоциативный массив условий
	 */
	function Update ($tablename, $data, $cond) {
		$query = "UPDATE `[tablename]` SET [vals]] WHERE ([cond])";

		$values = '';
		$conds = "";
		foreach ($data AS $key => $value) {
			$values .= "`".$key."`"."="."'".$value."', ";
		}
		foreach ($cond AS $key => $value) {
			$conds .= "`".$key."`"."="."'".$value."', ";
		}
		
		$replacement = array(
			'[tablename]' => $tablename,
			'[vals]' => $values,
			'[cond]' => $conds,
		);
		$replacement2 = array(
			"', )" => "')",
			"', ]" => "'"
		);

		$query = str_replace(array_keys($replacement), array_values($replacement), $query);
		$query = str_replace(array_keys($replacement2), array_values($replacement2), $query);

		return mysql_query($query);
	}
	
	function Executive ($query) {
		$res = mysql_query($query);
		$badass = array();
		if ($res) while ($td = mysql_fetch_assoc($res)) {
			$badass[] = $td;
		}
		mysql_free_result($res);
		return $badass;
	}

	function __destruct () {
		mysql_close($this->connection);
	}
}

class PostGresQL {
	private $connection;

	/* 
	 * Подключение к PostGresQL
	 * Соединение с БД является защищенным и доступным только классу
	 * При создание класса передаются параметры подключения
	 */
	function __construct($host, $user, $password, $dbname, $charset) {
		$this->connection = pg_connect("host=$host dbname=$dbname user=$user password=$password options='--client_encoding=$charset'");
	}

	/*
	 * Функция вставки в таблицу
	 * Принимает параметры: имя таблицы и ассоциативный массив данных
	 */
	function Insert ($tablename, $data) {
		return pg_insert($this->connection, $tablename, $data);
	}
	
	function Remove ($tablename, $cond) {
		return pg_delete($this->connection, $tablename, $cond);
	}
	
	function Select ($tablename, $cond) {
		$res = pg_select($this->connection, $tablename, $cond);
		$badass = array();
		if ($res) while ($td = pg_fetch_assoc($res)) {
			$badass[] = $td;
		}
		pg_free_result($res);
		return $badass;
	}
	
	/* 
	 * Функция обновления записей в БД
	 * Принимает параметры: имя таблицы, ассоциативный массив данных, ассоциативный массив условий
	 */
	function Update ($tablename, $data, $cond) {
		return pg_update($this->connection, $tablename, $data, $cond);
	}
		
	function Executive ($query) {
		$res = pg_query($this->connection, $query);
		$badass = array();
		if ($res) while ($td = pg_fetch_assoc($res)) {
			$badass[] = $td;
		}
		pg_free_result($res);
		return $badass;
	}

	function __destruct() {
		pg_close($this->connection);
	}
}

?>