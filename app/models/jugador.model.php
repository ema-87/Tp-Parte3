<?php



    class jugadorModel{

        private $db;

        function __construct(){
            // abro la conexion aca porque la necesito en todos los metodos (solo la abro una sola vez)
            $this->db = $this->getDB();
            $this->_deploy();
        }

        private function _deploy() {
            $query = $this->db->query('SHOW TABLES LIKE "clubes"');
            $tables = $query->fetchAll();
            
            if (count($tables) == 0) {
                $sqlClubes = <<<END
                CREATE TABLE clubes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    Club varchar(50) NOT NULL,
                    Liga varchar(100) NOT NULL
                );         
                END;

                $this->db->exec($sqlClubes);

                $sqlInsertClubes = <<<END
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

                $this->db->exec($sqlInsertClubes);
            }

            $query = $this->db->query('SHOW TABLES LIKE "jugadores"');
            $tables = $query->fetchAll();
            if(count($tables) == 0) {
                $sql = <<<END
                CREATE TABLE `jugadores` (
                `ID_Jugador` int(11) NOT NULL,
                `Nombre` varchar(50) NOT NULL,
                `Posicion` varchar(50) NOT NULL,
                `Nacimiento` date NOT NULL,
                `id_club` int(11) NOT NULL,
                `Nacionalidad` varchar(150) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

                ALTER TABLE `jugadores`
                ADD PRIMARY KEY (`ID_Jugador`),
                ADD KEY `id` (`id_club`) USING BTREE;

                ALTER TABLE `jugadores`
                MODIFY `ID_Jugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

                ALTER TABLE `jugadores`
                ADD CONSTRAINT `jugadores_ibfk_1` FOREIGN KEY (`id_club`) REFERENCES `clubes` (`id`) ON UPDATE CASCADE;
                END;
                $this->db->exec($sql);
                
                $sqlInsert = <<<END
                INSERT INTO `jugadores` (`ID_Jugador`, `Nombre`, `Posicion`, `Nacimiento`, `id_club`, `Nacionalidad`) VALUES
                (1, 'Lamine Yamal', 'Extremo Derecho', '2007-09-13', 1, 'Espana'),
                (4, 'Leandro Brey', 'Mediocampita', '2002-09-21', 4, 'Argentina'),
                (37, 'ZX', 'Arquero', '2024-10-23', 5, 'Espana'),
                (38, 'asdsdasd', 'asd', '2024-10-07', 1, 'Argentina'),
                (40, 'Libre', 'Arquero', '2024-10-01', 5, '');
                END;

                $this->db->exec($sqlInsert);
            }
        }

        private function getDB(){
            $db = new PDO('mysql:host=localhost;dbname=data-jugadores;charset=utf8', 'root', '');
            return $db;       
        }
        

        function getAll($orderBy = false){
            $sql = 'SELECT * FROM jugadores';

            if($orderBy){
                switch($orderBy){
                    case 'asc':
                        $sql .= ' ORDER BY Nombre ASC';
                        break;
                    case 'desc':
                        $sql .= ' ORDER BY Nombre DESC';
                        break;
                }
            }
            

            $queryJugadores = $this->db->prepare($sql);
            $queryJugadores->execute();
            $jugadores = $queryJugadores->fetchAll(PDO::FETCH_OBJ);
            return $jugadores;
        }


        function getDetallesJugadores($id) {
            $query = $this->db->prepare('SELECT jugadores.ID_Jugador, jugadores.Nombre, jugadores.Posicion, jugadores.Nacimiento, jugadores.Nacionalidad, clubes.Club AS club_nombre, clubes.Liga
                             FROM jugadores
                             JOIN clubes ON jugadores.id_club = clubes.id
                             WHERE jugadores.ID_Jugador = ?');

            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }
        

        function insert($nombre, $posicion, $nacimiento, $clubId, $nacionalidad){            
            $queryJugadores = $this->db->prepare('INSERT INTO jugadores (Nombre, Posicion, Nacimiento, id_club, Nacionalidad) VALUES (?,?,?,?,?)');
            $queryJugadores->execute([$nombre, $posicion, $nacimiento, $clubId, $nacionalidad]);
        
            return $this->db->lastInsertId();
        }

        function editJugador($clubEditado, $posicionEditada, $ligaEditada, $ID_Jugador) {
            $queryJugadores = $this->db->prepare('
                UPDATE jugadores 
                JOIN clubes ON jugadores.id_club = clubes.id
                SET jugadores.Posicion = ?, clubes.Club = ?, clubes.Liga = ?
                WHERE jugadores.ID_Jugador = ?;
            ');
            $queryJugadores->execute([$posicionEditada, $clubEditado, $ligaEditada, $ID_Jugador]);
        }
        

        function remove($id){
            $queryJugadores = $this->db->prepare('DELETE FROM jugadores WHERE ID_Jugador = ?');
            $queryJugadores->execute([$id]);
        }

    }

?>