<?php
// acceso a los datos

class clubModel
{

    private $db;

    function __construct()
    {
        // abro la conexion aca porque la necesito en todos los metodos (solo la abro una sola vez)
        $this->db = $this->getDB();
    }

    private function getDB()
    {
        $db = new PDO('mysql:host=localhost;dbname=data-jugadores;charset=utf8', 'root', '');
            return $db;
    }

    function insert($liga, $club)
    {
        $queryClubes = $this->db->prepare('INSERT INTO clubes (Club, Liga) VALUES (?,?)');
        $queryClubes->execute([$club, $liga]);

        return $this->db->lastInsertId();
    }

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


    public function getAll($liga = null, $orderBy = false, $orderCamp = false){

        if($liga===null){
            $sql = 'SELECT * FROM clubes';

            if($orderBy && $orderCamp){
                switch($orderBy){
                    case 'asc':
                        switch($orderCamp){
                            case 'Club':
                                $sql .= ' ORDER BY Club ASC';
                                break;
                            case 'Liga':
                                $sql .= ' ORDER BY Liga ASC';
                                break;
                        }
                        break;
                    case 'desc':
                        switch($orderCamp){
                            case 'Club':
                                $sql .= ' ORDER BY Club DESC';
                                break;
                            case 'Liga':
                                $sql .= ' ORDER BY Liga DESC';
                                break;
                        }
                        break;
                }
            }    
            $queryClubes = $this->db->prepare($sql);
            $queryClubes->execute();
            $clubes = $queryClubes->fetchAll(PDO::FETCH_OBJ);
            return $clubes;
        }

        if($liga !== null){
            $sql = 'SELECT * FROM clubes WHERE Liga = ?';
               
            if($orderBy && $orderCamp){
                switch($orderBy){
                    case 'asc':
                        switch($orderCamp){
                            case 'Club':
                                $sql .= ' ORDER BY Club ASC';
                                break;
                            case 'Liga':
                                $sql .= ' ORDER BY Liga ASC';
                                break;
                        }
                        break;
                    case 'desc':
                        switch($orderCamp){
                            case 'Club':
                                $sql .= ' ORDER BY Club DESC';
                                break;
                            case 'Liga':
                                $sql .= ' ORDER BY Liga DESC';
                                break;
                        }
                        break;
                }
            }    
            $query = $this->db->prepare($sql);
            $query->execute([$liga]);
    
            $clubes = $query->fetchAll(PDO::FETCH_OBJ);
            return $clubes;
        }
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
