<?php



    class jugadorModel{

        private $db;

        function __construct(){
            // abro la conexion aca porque la necesito en todos los metodos (solo la abro una sola vez)
            $this->db = $this->getDB();
        }

        private function getDB(){
            $db = new PDO('mysql:host=localhost;dbname=data-jugadores;charset=utf8', 'root', '');
            return $db;       
        }
        

        public function getAll($nacionalidad = null, $orderBy = false, $orderCamp = false){

            if($nacionalidad===null){
                $sql = 'SELECT * FROM jugadores';
    
                    if($orderBy && $orderCamp){
                        switch($orderBy){
                            case 'asc':
                                switch($orderCamp){
                                    case 'Nombre':
                                        $sql .= ' ORDER BY Nombre ASC';
                                        break;
                                    case 'Posicion':
                                        $sql .= ' ORDER BY Posicion ASC';
                                        break;
                                    case 'Nacimiento':
                                        $sql .= ' ORDER BY Nacimiento ASC';
                                        break;
                                    case 'id_club':
                                        $sql .= ' ORDER BY id_club ASC';
                                        break;
                                    case 'Nacionalidad':
                                        $sql .= ' ORDER BY Nacionalidad ASC';
                                        break;
                                }
                                break;
                            case 'desc':
                                switch($orderCamp){
                                    case 'Nombre':
                                        $sql .= ' ORDER BY Nombre DESC';
                                        break;
                                    case 'Posicion':
                                        $sql .= ' ORDER BY Posicion DESC';
                                        break;
                                    case 'Nacimiento':
                                        $sql .= ' ORDER BY Nacimiento DESC';
                                        break;
                                    case 'id_club':
                                        $sql .= ' ORDER BY id_club DESC';
                                        break;
                                    case 'Nacionalidad':
                                        $sql .= ' ORDER BY Nacionalidad DESC';
                                        break;
                                }
                                break;
                        }
                    }
        
                $query = $this->db->prepare($sql);
                $query->execute();
        
                $jugadores = $query->fetchAll(PDO::FETCH_OBJ);
            
                return $jugadores;
                    } 
    
            if($nacionalidad !== null){
                $sql = 'SELECT * FROM jugadores WHERE Nacionalidad = ?';
                   
                if($orderBy && $orderCamp){
                    switch($orderBy){
                        case 'asc':
                            switch($orderCamp){
                                case 'Nombre':
                                    $sql .= ' ORDER BY Nombre ASC';
                                    break;
                                case 'Posicion':
                                    $sql .= ' ORDER BY Posicion ASC';
                                    break;
                                case 'Nacimiento':
                                    $sql .= ' ORDER BY Nacimiento ASC';
                                    break;
                                case 'id_club':
                                    $sql .= ' ORDER BY id_club ASC';
                                    break;
                                case 'Nacionalidad':
                                    $sql .= ' ORDER BY Nacionalidad ASC';
                                    break;
                            }
                            break;
                        case 'desc':
                            switch($orderCamp){
                                case 'Nombre':
                                    $sql .= ' ORDER BY Nombre DESC';
                                    break;
                                case 'Posicion':
                                    $sql .= ' ORDER BY Posicion DESC';
                                    break;
                                case 'Nacimiento':
                                    $sql .= ' ORDER BY Nacimiento DESC';
                                    break;
                                case 'id_club':
                                    $sql .= ' ORDER BY id_club DESC';
                                    break;
                                case 'Nacionalidad':
                                    $sql .= ' ORDER BY Nacionalidad DESC';
                                    break;
                            }
                            break;
                    }
                }
                $query = $this->db->prepare($sql);
                $query->execute([$nacionalidad]);
        
                $jugadores = $query->fetchAll(PDO::FETCH_OBJ);
                return $jugadores;
            }
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