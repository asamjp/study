<?php

require_once "DB_Connect.php";

define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', '');
define( 'DB_NAME', 'study');

header('Content-Type: text/html; charset=UTF-8');

$db = new DB_Connect(DB_HOST, DB_NAME, DB_USER, DB_PASS);

function select_query($sql) {
	global $db;
	$data = $db->select_query($sql);
	return $data;
}

/**
 * 全テーブル一覧を取得する。
 */
function get_table_all_list($columns_flg=false) {
	global $db;
	$sql = "show tables;";

	if ($columns_flg) {
		$table_list = $db->select_query($sql);
		foreach($table_list as $table) {
			$table_name = $table["Tables_in_ros"];
			$columns = get_columns($table_name);
			$table_data_list[$table_name] = $columns;
		}
	} else {
		$table_list = $db->select_query($sql);
		foreach($table_list as $table) {
			$table_name = $table["Tables_in_ros"];
			$table_data_list[] = $table_name;
		}
	}
	return $table_data_list;
}

/**
 * 対象テーブルのカラム情報を取得する。
 */
function get_columns($table_name) {
	global $db;
	$sql = "show columns from `".$table_name."`;";
	$columns = $db->select_query($sql);
	return $columns;
}

function create_up_sql($table_nm,$data,$skip_col_list = array()) {
	global $db;
	$sql = "show columns from ".$table_nm.";";
	$columns = $db->select_query($sql);
	$up_sql = "";
	foreach ($columns as $column) {
		// 主キーなどキー情報取得 ※アルファベットはとりあえず大文字にしておく
		$col_key = strtoupper($column["Key"]);
		// 主キー以外の場合(主キーは変更することがないため)
		if ("PRI" != $col_key && !in_array($col_key, $skip_col_list)) {
			$col_name = $column["Field"];
			$value = $data[$col_name];
			if (null !== $value && !in_array($col_name, $skip_col_list)) {
				if ("" != $up_sql) {
					$up_sql .= ", ";
				}
				// 型とnullを取得 ※アルファベットはとりあえず大文字にしておく
				$col_type = strtoupper($column["Type"]);
				$col_null = strtoupper($column["Null"]);

				// date系が空文字の場合、NULLが許容されていればNULLを設定
				if ("" === $value && ("DATE" == $col_type || "DATETIME" == $col_type) && "YES" == $col_null) {
					$up_sql .= $col_name . " = NULL";
				} else {
					// INT型の場合数値以外削除する
					if (strpos($col_type, "INT")) {
						$value = preg_replace("/[^0-9]/","",$value);
					}
					$up_sql .= $col_name . " = " . $db->quoteSmart($value);
				}
			}
		}
	}
	
	return $up_sql;
}

function create_ins_col($table_nm,$data,$skip_col_list = array()) {
	global $db;
	$sql = "show columns from ".$table_nm.";";
	$columns = $db->select_query($sql);
	$ins_col = "";
	foreach ($columns as $column) {
		// 主キーなどキー情報取得 ※アルファベットはとりあえず大文字にしておく
		$col_key = strtoupper($column["Key"]);
		// 主キー以外の場合(主キーは自動採番のため、こちらから指定しない想定)
		if ("PRI" != $col_key) {
			$col_name = $column["Field"];
			$value = $data[$col_name];
			if (null !== $value && !in_array($col_name, $skip_col_list)) {
				if ("" != $ins_col) {
					$ins_col .= ", ";
				}
				$ins_col .= $col_name;
			}
		}
	}
	
	return $ins_col;
}

function create_ins_val($table_nm,$data,$skip_col_list = array()) {
	global $db;
	$sql = "show columns from ".$table_nm.";";
	$columns = $db->select_query($sql);
	$ins_sql = "";
	foreach ($columns as $column) {
		// 主キーなどキー情報取得 ※アルファベットはとりあえず大文字にしておく
		$col_key = strtoupper($column["Key"]);
		// 主キー以外の場合(主キーは自動採番のため、こちらから指定しない想定)
		if ("PRI" != $col_key) {
			$col_name = $column["Field"];
			$value = $data[$col_name];
			if (null !== $value && !in_array($col_name, $skip_col_list)) {
				if ("" != $ins_sql) {
					$ins_sql .= ", ";
				}
				// 型とnullを取得 ※アルファベットはとりあえず大文字にしておく
				$col_type = strtoupper($column["Type"]);
				$col_null = strtoupper($column["Null"]);

				// date系が空文字の場合、NULLが許容されていればNULLを設定
				if ("" == $value && ("DATE" == $col_type || "DATETIME" == $col_type) && "YES" == $col_null) {
					$ins_sql .= "NULL";
				} else {
					// INT型の場合数値以外削除する
					if (strpos($col_type, "INT")) {
						$value = preg_replace("/[^0-9]/","",$value);
					}
					$ins_sql .= $db->quoteSmart($value);
				}
			}
		}
	}
	
	return $ins_sql;
}