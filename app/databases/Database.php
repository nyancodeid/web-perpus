<?php
namespace App\Databases;

class Database {
	private $connection;
    private $options = [
        "host" => "localhost",
        "user" => "root",
        "password" => "",
        "database" => "database_name"
    ];

    public function __construct($options = null)
    {
        if (is_null($options)) {
            $options = $this->getConfig();
        }

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

    public function getConfig () {
        return [
            "host" => config("db.host"),
            "database" => config("db.database"),
            "user" => config("db.user"),
            "password" => config("db.password"),
        ];
    }
}