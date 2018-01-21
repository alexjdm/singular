<?php
class Database
{
	/*private static $dbName = 'singula1_app';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'singula1_user_ap';
    private static $dbUserPassword = 'Singular2017';*/

    private static $dbName = 'singula1_app';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';

    private static $cont = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect() {
        if (null === self::$cont) {
            try {
                self::$cont =  new PDO('mysql:host='.self::$dbHost.'; dbname='.self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    /*Método para ejecutar una sentencia sql*/
    public function ejecutar($sql){
        $this->resultado = mysqli_query($this->link, $sql);
        return $this->resultado;
    }

    /*Método para obtener una fila de resultados de la sentencia sql*/
    public function obtener_fila($resultado, $fila){
        if ($fila==0){
            $this->array = mysqli_fetch_array($resultado);
        }else{
            mysqli_data_seek($resultado,$fila);
            $this->array = mysqli_fetch_array($resultado);
        }
        return $this->array;
    }

    function obtener_resultados($resultado)
    {
        return mysqli_fetch_array($resultado, MYSQL_ASSOC);
    }

    public static function disconnect() {
        self::$cont = null;
    }
}