<?php
namespace App\Models;

use App\Databases\Database;

class Base {
	protected $table = "";
    private Database $connection;

    private $where;

    public function __construct()
    {
        $this->setConnection();
    }

    private function setConnection () {
    	if (!config("db.instance")) {
            config("db.instance", new Database());
        }

        $this->connection = config("db.instance");
    }

    public function query ($query) {
        $result = mysqli_query($this->connection->getConnection(), $query);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function execute ($query, $options) {
        $stmt = mysqli_prepare($this->connection->getConnection(), $query);

        if (count($options) > 0) {
            [ $types, $params ] = $options;

            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        return mysqli_stmt_execute($stmt);
    }

    public function all () {
        return $this->query("SELECT * FROM `{$this->table}`");
    }

    public function first () {
        return $this->query("SELECT * FROM `{$this->table}` WHERE {$this->where} LIMIT 1")[0];
    }

    public function create ($fields) {
        $columns = implode("`, `", array_keys($fields));
        $binded_types = '';
        $binded_values = [];
        $values = '';
		$x=1;

		foreach ($fields as $field => $value) {
            $binded_types .= "s";
			$values .='?';
			$binded_values[] =  $value;
			if ($x < count($fields)) {
				$values .=', ';
			}

			$x++;
		}

        $binded_values = [ $binded_types, $binded_values ];

        return $this->execute(
            "INSERT INTO `{$this->table}` (`{$columns}`) VALUES ({$values})", $binded_values);
    }

    public function where ($column, $operator, $value = null) {
        if (in_array($operator, [ '=', '!=', '>', '<', '>=', '<=' ])) {
            $this->where = "{$column}{$operator}'{$value}'";
        } else {
            $this->where = "{$column}='{$operator}'";
        }

        return $this;
    }

    public function update ($fields) {
        $binded_types = '';
        $binded_values = [];

        $set ='';
		$x = 1;

        foreach ($fields as $column => $field) {
			$set .= "`$column` = ?";
            $binded_types .= "s";
			$binded_values[] =  $field;
			if ( $x < count($fields) ) {
				$set .= ", ";
			}
			$x++;
		}

        $binded_values = [ $binded_types, $binded_values ];

        return $this->execute(
            "UPDATE `{$this->table}` SET $set WHERE {$this->where}", $binded_values);
    }

    public function delete () {
        return $this->execute(
            "DELETE FROM `{$this->table}` WHERE {$this->where}", []);
    }
}