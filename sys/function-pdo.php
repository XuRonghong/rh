<?php
/*!
	 * Exlocus (with Agi)
	 * Copyright (c) 2015
	 * Version: 1.0.5 (2019-8-19)
	 * PHP 7.0
	 * PDO
	 */

//資料陣列組合字串
function implodeSQL($data1, &$data2)
{
	if (empty($data1)) return false;
	$str = '';
	$params = [];
	$data2 = is_array($data2) ? $data2 : array($data2);
	foreach ($data1 as $key => $value) {
		if ($str) {
			$str .= " AND ";
		}
		if ($value == '') {
			$str .= "`$key`=default";
		} else {
			$str .= "`$key`=:" . $key;
			$params[$key] = $value;
		}
	}
	$data2 = array_merge($params, $data2);
	return $str;
}

//取得單值資料
function getSingleValue($sql, $params = [], $default = '')
{
	global $db;
	$rs = $db->prepare($sql);
	$rs->execute($params);
	if (!$row = $rs->fetch()) {
		return $default;
	} else {
		return $row[0];
	}
}

//取得單筆資料
function getSingleRow($sql, $params = [], $default = '')
{
	global $db;
	$rs = $db->prepare($sql);
	$rs->execute($params);
	if (!$row = $rs->fetch(PDO::FETCH_ASSOC)) {
		return $default;
	} else {
		return $row;
	}
}

//取得多筆資料,資料回傳一個2維陣列
function getMultiRow($sql, $params = [], &$rowCount=null)
{
	global $db;
	$rs = $db->prepare($sql);
	$rs->execute($params);
	// $rs->execute(($params==null)?'':$params);
	$rowCount = $rs->rowCount();
	if ($rowCount <= 0) {
		return [];
	} else {
		while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			$arr[] = $row;
		}
		return $arr;
	}
}

//取得多筆值,將資料轉換成一個陣列後回傳
function getArrayValue($sql)
{
	global $db;
	$rs = $db->query($sql);
	if ($rs->rowCount() <= 0) {
		return [];
	} else {
		while ($row = $rs->fetch(PDO::FETCH_NUM)) {
			$arr[] = $row[0];
		}
		return $arr;
	}
}

//取得索引資料
function getIndexValue($sql, $params = null)
{
	global $db;
	$arr = [];
	if ($params == null) {
		$rs = $db->query($sql);
	} else {
		$rs = $db->prepare($sql);
		$rs->execute(($params == null) ? '' : $params);
	}
	if ($rs->rowCount() > 0) {
		while ($row = $rs->fetch(PDO::FETCH_NUM)) {
			$arr[$row[0]] = $row[1];
		}
	}
	return $arr;
}

//取得索引列
function getIndexRow($sql, $column = ['title'], $index = 'no')
{
	global $db;
	$arr = [];
	$rs = $db->query($sql);
	if ($rs->rowCount() > 0) {;
		while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
			if ($column == '*') {
				$arr[$row[$index]] = $row;
			} else {
				foreach ($column as $key) {
					$arr[$row[$index]][$key] = $row[$key];
				}
			}
		}
	}
	return $arr;
}

//取得前一筆資料	
function getPrevData($sql, $key, $tar = 'no')
{
	global $db;
	$rs = $db->query($sql);
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
		if ($row[$tar] == $key) {
			if ($prevrow != '')
				return $prevrow[$tar];
			break;
		}
		$prevrow = $row;
	}
}

//取得下一筆資料
function getNextData($sql, $key, $tar = 'no')
{
	global $db;
	$rs = $db->query($sql);
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
		if ($row[$tar] == $key) {
			if ($row = $rs->fetch(PDO::FETCH_ASSOC))
				return $row[$tar];
			break;
		}
	}
}

//取得資料總筆數
function getTotalCount($sql, $params = null)
{
	global $db;
	if ($params == null) {
		$rs = $db->query($sql);
	} else {
		$rs = $db->prepare($sql);
		$rs->execute(($params == null) ? '' : $params);
	}
	return ($rs) ? $rs->rowCount() : 0;
}

//取得資料表欄位名稱
function getColumName($tablename, $assoc = null)
{
	global $db;
	$sql = 'SELECT * FROM ' . $tablename;
	$rs = $db->query($sql);
	for ($i = 0, $imax = $rs->columnCount(); $i < $imax; $i++) {
		$field = $rs->getColumnMeta($i);
		$columname[] = $field['name'];
	}
	return $columname;
}

//取得資料庫資料表名稱
function getDBTable($dbname, $colum = 0)
{
	$re = mysql_query("SHOW TABLES FROM $dbname");
	while ($row = mysql_fetch_array($re, MYSQL_NUM)) {
		$arr[] = $row[$colum];
	}
	return $arr;
}

//資料新增(資料陣列,資料表名稱,是否顯示)
function dataInsert($tablename, $data, $trace = null)
{
	global $db;
	if (empty($data)) return false;
	if (empty($tablename)) return false;
	$str = '';
	$strvalue = '';
	$params = [];
	foreach ($data as $key => $value) {
		if ($str) {
			$str .= ",";
		}
		$str .= "`$key`";
		if ($strvalue) {
			$strvalue .= ",";
		}
		if ($value == '') {
			$strvalue .= 'default';
		} else {
			$strvalue .= "?";
			$params[] = $value;
		}
	}
	$sql = "INSERT INTO $tablename(" . $str . ")VALUES(" . $strvalue . ")";
	if ($trace) {
		echo $sql;
		print_r($$params);
	};
	$rs = $db->prepare($sql);
	$rs->execute($params);
	return $db->lastInsertId();
}

//資料更新(資料表名稱,資料陣列,條件,條件參數,是否顯示)
function dataUpdate($tablename, $data1, $where, $data2 = [], $trace = null)
{
	global $db;
	if (empty($tablename)) return false;
	if (empty($data1)) return false;
	if (empty($where)) return false;
	$str = '';
	$params = [];
	$data2 = is_array($data2) ? $data2 : array($data2);
	foreach ($data1 as $key => $value) {
		if ($str) {
			$str .= ",";
		}
		if ($value == '') {
			$str .= "`$key`=default";
		} else {
			// $str.="`$key`=?";
			// $params[]=$value;	
			$str .= "`$key`=:" . $key;
			$params[$key] = $value;
		}
	}
	$params = array_merge($params, $data2);
	$sql = "UPDATE `$tablename` SET $str $where";
	if ($trace) {
		echo $sql;
		print_r($$params);
	};
	$rs = $db->prepare($sql);
	$rs->execute($params);
	return $rs->rowCount();
}

//
function dataDelete($tablename, $where, $data = [], $trace = null)
{
	global $db;
	if (empty($tablename)) return false;
	if (empty($where)) return false;
	if (empty($data)) return false;
	// $params = [];
	// $params = array_merge($params,$data);
	$params = $data;
	$sql = "DELETE FROM `$tablename` $where";
	if ($trace) {
		echo $sql . " \n <br> ";
		print_r($params);
	};
	$rs = $db->prepare($sql);
	$rs->execute($params);
	return $rs->rowCount();
}

// 取得where字串,指定名稱
function getSqlWhereOnly($arr, $name, $operator = 'AND', $case = '=')
{
	$str = '';
	for ($i = 0; $i < count($arr); $i++) {
		if ($str) {
			$str .= ' ' . $operator . ' ';
		}
		if ($case == '=')
			$str .= "`$name`={$arr[$i]}";
		else if ($case == 'LIKE')
			$str .= "`$name` LIKE '%{$arr[$i]}%'";
	}
	return $str;
}

// 取得 pdo where字串,指定名稱
function getSqlWhereIn($arr, $name)
{
	if (count($arr) == 0) return false;
	$str = '';
	for ($i = 0, $imax = count($arr); $i < $imax; $i++) {
		if ($str) {
			$str .= ",";
		}
		$str .= '?';
	}
	return "$name IN($str)";
}

// 取得 pdo where字串,指定條件(變數陣列,條件陣列,運算子)
function getSqlWhere($arr, $case, $operator = 'AND')
{
	if (count($arr) == 0) return false;
	$str = '';
	foreach ($arr as $key => $value) {
		if (strpos($value, ' ')) {
			if ($str) {
				$str .= " $operator ";
			}
			$jarr = explode(' ', $value);
			$substr = '';
			for ($j = 0, $jmax = count($jarr); $j < $jmax; $j++) {
				if ($jarr[$j] != "") {
					if ($substr != "") {
						$substr .= " OR ";
					}
					if (empty($case[$key])) {
						$substr .= "$key=?";
					} else {
						if ($case[$key] == "LIKE") {
							$substr .= "$key LIKE ?";
						} else {
							$substr .= "$key {$case[$key][$j]} ?";
						}
					}
				}
			}
			$str .= '(' . $substr . ')';
		} elseif ($value != '') {
			if ($str != '') {
				$str .= " $operator ";
			}
			if (empty($case[$key])) {
				$str .= "$key=?";
			} else {
				$str .= "$key {$case[$key]} ?";
			}
		}
	}
	return $str;
}

// 取得 pdo where字串,指定條件(變數陣列,條件陣列,運算子)
function getSqlWhere2($arr, $case, $operator = 'AND')
{
	if (count($arr) == 0) return false;
	$str = '';
	foreach ($arr as $key => $value) {
		if (strpos($value, ' ')) {
			if ($str) {
				$str .= " $operator ";
			}
			$jarr = explode(' ', $value);
			$substr = '';
			for ($j = 0, $jmax = count($jarr); $j < $jmax; $j++) {
				if ($jarr[$j] != "") {
					if ($substr != "") {
						$substr .= " OR ";
					}
					if (empty($case[$key])) {
						$substr .= "`$key` = :" . $key . $j;
					} else {
						if ($case[$key] == "LIKE") {
							$substr .= "`$key` LIKE :" . $key . $j;
						} else {
							$substr .= "`$key` {$case[$key][$j]} :" . $key . $j;
						}
					}
				}
			}
			$str .= '(' . $substr . ')';
		} elseif ($value != '') {
			if ($str != '') {
				$str .= " $operator ";
			}
			if (empty($case[$key])) {
				$str .= "`$key` = :$key";
			} else {
				$str .= "`$key` {$case[$key]} :$key";
			}
		}
	}
	return $str;
}

// 取得 pdo params值,指定條件(變數陣列,條件陣列)
function getSqlParams($arr, $case)
{
	if (count($arr) == 0) return false;
	$params = [];
	foreach ($arr as $key => $value) {
		if (strpos($value, ' ')) {
			$value = explode(' ', $value);
			for ($i = 0, $imax = count($value); $i < $imax; $i++) {
				if ($case[$key] == "LIKE") {
					$params[] = '%' . $value[$i] . '%';
				} else {
					$params[] = $value[$i];
				}
			}
		} else {
			if (isset($case[$key]) && $case[$key] == "LIKE") {
				$params[] = '%' . $value . '%';
			} else {
				$params[] = $value;
			}
		}
	}
	return $params;
}


// 取得 pdo params值,指定條件(變數陣列,條件陣列)
function getSqlParams2($arr, $case)
{
	if (count($arr) == 0) return false;
	foreach ($arr as $key => $value) {
		if (strpos($value, ' ')) {
			$value = explode(' ', $value);
			for ($i = 0, $imax = count($value); $i < $imax; $i++) {
				if ($case[$key] == "LIKE") {
					$arr[$key . $i] = '%' . $value[$i] . '%';
				} else {
					$arr[$key . $i] = $value[$i];
				}
			}
			unset($arr[$key]);
		} else {
			if (isset($case[$key]) && $case[$key] == "LIKE") {
				$arr[$key] = '%' . $value . '%';
			}
		}
	}
	return $arr;
}
