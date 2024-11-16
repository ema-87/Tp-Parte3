<?php
// acceso a los datos

class clubModel
{

    private $db;

    function __construct()
    {
        // abro la conexion aca porque la necesito en todos los metodos (solo la abro una sola vez)
        $this->db = $this->getDB();
        $this->_deploy();
    }

    private function getDB()
    {
        $db = new PDO('mysql:host=localhost;dbname=data-jugadores;charset=utf8', 'root', '');
            return $db;
    }

    private function _deploy()
    {
        $query = $this->db->query('SHOW TABLES LIKE "clubes"');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END
                CREATE TABLE clubes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    Club varchar(50) NOT NULL,
                    Liga varchar(100) NOT NULL
                );         
                END;
            $this->db->query($sql);

            $sqlInsert = <<<END
                INSERT INTO clubes (id, Club, Liga) VALUES
                (1, 'Boca Juniors', 'Argentina'),
                (2, 'Real Madrid CF', 'Espana'),
                (3, 'Newcastle United', 'Inglaterra'),
                (4, 'FC Barcelona', 'España'),
                (5, 'Bayern Munich', 'Alemania'),
                (20, 'Villareal', 'Espana'),
                (21, 'Inter ', 'Italia'),
                (22, 'Milan', 'Italia'),
                (24, 'River Plate', 'Argentina'),
                (25, 'FC Barcelona', 'España'),
                (26, 'Ferro', 'Argentina');
                END;
            $this->db->query($sqlInsert);
        }
    }


    function insert($liga, $club)
    {
        $queryClubes = $this->db->prepare('INSERT INTO clubes (Club, Liga) VALUES (?,?)');
        $queryClubes->execute([$club, $liga]);

        return $this->db->lastInsertId();
    }

    /*public function getClubIdByName($clubName)
    {
        $query = $this->db->prepare('SELECT id FROM clubes WHERE Club = ?');
        $query->execute([$clubName]);
        return $query->fetchColumn(); // Devuelve el ID del club
    }*/

    function getClub($id) {
        $query = $this->db->prepare('SELECT * FROM clubes WHERE clubes.id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }


    function remove($id)
{
    // Primero, eliminar los jugadores que están asociados al club
    $queryJugadores = $this->db->prepare('UPDATE jugadores SET id_club = NULL WHERE id_club = ?');
    $queryJugadores->execute([$id]);

    // Luego eliminar el club
    $queryClubes = $this->db->prepare('DELETE FROM clubes WHERE id = ?');
    $queryClubes->execute([$id]);
}



    function getAll($orderBy = false){
        $sql = 'SELECT * FROM clubes';

        if($orderBy){
            switch($orderBy){
                case 'asc':
                    $sql .= ' ORDER BY Club ASC';
                    break;
                case 'desc':
                    $sql .= ' ORDER BY Club DESC';
                    break;
            }
        }
        $queryClubes = $this->db->prepare($sql);
        $queryClubes->execute();
        $clubes = $queryClubes->fetchAll(PDO::FETCH_OBJ);
        return $clubes;
    }


    function editClub($clubEditado, $ligaEditada, $id)
    {
        $queryClubes = $this->db->prepare('
                UPDATE clubes 
                SET clubes.Club = ?, clubes.Liga = ?
                WHERE clubes.id = ?;
            ');
        $queryClubes->execute([$clubEditado, $ligaEditada, $id]);
    }
}
