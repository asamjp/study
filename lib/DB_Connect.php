<?php
header('Content-Type: text/html; charset=UTF-8');
class DB_Connect {

	private $dbh;

	function __construct($db_host, $db_name, $db_user, $db_password) {

		$this->dbh = new mysqli($db_host, $db_user, $db_password, $db_name);

		if ($this->dbh->connect_error) {
			$sql_error = $this->dbh->connect_error;
			die($sql_error);
		}
	}

	public function query($sql) {

		$res = $this->dbh->query($sql);

		if (!$res) {
			echo $sql;
			die($this->dbh->error);
		}
	}

	public function select_query($sql) {

		$res = $this->dbh->query($sql);

		if (!$res) {
			echo $sql;
			die($this->dbh->error);
		}
		$date_array = array("adate", "udate", "kanryo_date");
		$ret = array();
		while ($row = $res->fetch_assoc()) {
			foreach ($date_array as $item) {
				if (isset($row[$item]) && $row[$item] != "") {
					$t = strtotime(substr($row[$item], 0, 19));
					$row["{$item}_jpn_date"] = date('Y年n月j日', $t);
					$row["{$item}_def_datetime"] = date('Y/n/j　H：i', $t);
					//$row["{$item}_jpn_long"] = date('Y年n月j日',$t);
					$row["{$item}_jpn_long"] = date('Y年n月j日 H時i分', $t);
					//$row["{$item}_jpn_date"] = date('Y年n月j日',$t);
					//$row["{$item}_jpn_mid"] = date('n月j日 H時i分',$t);
					//$row["{$item}_mob"] = date('y/n/j\<\b\r\>H:i',$t);
				}
			}
			$ret[] = $row;
		}
		return $ret;
	}

	//クエリ用の文字列をクオート
	public function quoteSmart($string) {
		if (is_null($string)) {
			return "NULL";
		} elseif (is_int($string) || is_float($string)) {
			return $string;
		} else {
			return "'" . $this->dbh->real_escape_string($string) . "'";
		}
	}

	public function quote($string) {
		return $this->dbh->real_escape_string($string);
	}

}
