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

    public function getClubIdByName($clubName)
    {
        $query = $this->db->prepare('SELECT id FROM clubes WHERE Club = ?');
        $query->execute([$clubName]);
        return $query->fetchColumn(); // Devuelve el ID del club
    }



    function remove($id)
    {
        $queryClubes = $this->db->prepare('DELETE FROM clubes WHERE id = ?');
        $queryClubes->execute([$id]);
    }

    function getAll()
    {
        $queryClubes = $this->db->prepare('SELECT * FROM clubes ORDER BY Club ASC');
        $queryClubes->execute();
        $clubes = $queryClubes->fetchAll(PDO::FETCH_OBJ);
        return $clubes;
    }
    function editClub($ligaEditada, $clubEditado, $id)
    {
        $queryClubes = $this->db->prepare('
                UPDATE jugadores 
                JOIN clubes ON jugadores.id_club = clubes.id
                SET jugadores.Posicion = ?, clubes.Club = ?, clubes.Liga = ?
                WHERE jugadores.ID_Jugador = ?;
            ');
        $queryClubes->execute([$ligaEditada, $clubEditado, $id]);
    }
}
