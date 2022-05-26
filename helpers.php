<?php

class DB {
    private $connection;
    private $options = [
        "host" => "localhost",
        "user" => "root",
        "password" => "",
        "database" => "php_course"
    ];

    public function __construct($options)
    {
        $this->options = array_merge($this->options, $options);
        $this->connection = $this->connectToDB();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function connectToDB()
    {
        $connection = mysqli_connect(
            $this->options['host'], 
            $this->options['user'], 
            $this->options['password'], 
            $this->options['database']
        );

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $connection;
    }

    public function query ($query) {
        return mysqli_query($this->connection, $query);
    }
}

class Model {
    protected $table = "";
    private DB $connection;

    private $where;

    public function __construct(DB $connection)
    {
        $this->connection = $connection;
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

function hitung_denda (string $tanggal_harus_kembali, int $denda_per_hari): int {
    $tanggal_harus_kembali = new DateTime($tanggal_harus_kembali);
    $tanggal_sekarang = new DateTime();
    $selisih = $tanggal_harus_kembali->diff($tanggal_sekarang);

    $denda = 0;

    if ($selisih->days > 0 && $selisih->invert == 0) {
        $denda = $selisih->days * $denda_per_hari;
    }

    return $denda;
}

function format_tanggal ($tanggal, $format = 'Y-m-d'): string {
    if (!$tanggal) return '';

    return date_format(date_create($tanggal), $format);
}

function _get($key) {
    return $_GET[$key] ?? false;
}
function _match($key, $match) {
    return (_get($key) == $match);
}
