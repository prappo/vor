<?php


namespace Vor;


class Database {

	public $connection;

	function __construct( $config ) {
		try {
			$connect = new \PDO( 'mysql:host=' . $config['host'] . ';dbname=' . $config['name'] . ';', $config['username'], $config['password'] );
			$connect->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

			return $this->connection = $connect;
		} catch( \PDOException $e ) {
			return false;
		}
	}

	public function query( $query ) {
		try {
			$statement = $this->connection->query( $query );

			return $statement;
		} catch(\PDOException $e) {
			return false;
		}
	}
}