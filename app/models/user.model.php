<?php
require_once 'config.php';

class userModel
{

    private $db;

    function __construct(){
        // abro la conexion aca porque la necesito en todos los metodos (solo la abro una sola vez)
        $this->db = $this->getDB();
        $this->_deploy();
    }

    private function getDB(){
        return $db = dataBase;
    }

    private function _deploy() {
        $query = $this->db->query('SHOW TABLES LIKE "usuario"');                                                 
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $sql =<<<END
            CREATE TABLE `usuario` (
                `id` int(11) NOT NULL,
                `nombre` varchar(250) NOT NULL,
                `contrasena` varchar(60) NOT NULL
            )          
            END;
            $this->db->query($sql);
            $password = '$2y$10$SQ9LCfDGsVXQEr0Eftx30O3K9ut/Y8ZfvJDVxeiFDeaOrRRvyGZa2';
            $sqlInsert = <<<END
            INSERT INTO `usuario` (`id`, `nombre`, `contrasena`) VALUES
            (1, 'webadmin', '$password');
            END;
            $this->db->query($sqlInsert);
        }
    }
    
    

    function getUserByName($usuario){
        $query = $this->db->prepare('SELECT * FROM usuario WHERE nombre = ?');
        $query->execute([$usuario]);  

        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }


}
