<?php

// Coordinador entre vista y modelo
include_once 'app/models/jugador.model.php';
include_once 'app/view/json.view.php';

class jugadorApiController
{

    private $modelJugadores;
    private $viewJugadores;

    function __construct()
    {

        // instancio las clases en model y view para utilizar sus metodos dentro de la clase
        $this->modelJugadores = new jugadorModel();
        $this->viewJugadores = new JsonView();
    }

    function getAll($req, $res)
    {
         $orderBy= false;
         if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
         }

        $jugadores = $this->modelJugadores->getAll($orderBy);
       return $this->viewJugadores->response($jugadores);
    }


    public function create($req, $res) {

        // valido los datos
        if (empty($req->body->nombre) || empty($req->body->posicion) || empty($req->body->nacimiento) || empty($req->body->clubId) || empty($req->body->nacionalidad)) {
            return $this->viewJugadores->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $nombre = $req->body->nombre;       
        $posicion = $req->body->posicion;       
        $nacimiento = $req->body->nacimiento;    
        $clubId = $req->body->clubId;  
        $nacionalidad = $req->body->nacionalidad;     

        // inserto los datos
        $id = $this->modelJugadores->insert($nombre, $posicion, $nacimiento, $clubId, $nacionalidad);

        if (!$id) {
            return $this->viewJugadores->response("Error al insertar el jugador", 500);
        }

        // buena práctica es devolver el recurso insertado
        $jugador = $this->modelJugadores->getDetallesJugadores($id);
        return $this->viewJugadores->response($jugador, 201);
    }

    public function update($req, $res) {
        $id = $req->params->id;

        // verifico que exista
        $jugador = $this->modelJugadores->getDetallesJugadores($id);
        if (!$jugador) {
            return $this->viewJugadores->response("el jugador con el id=$id no existe", 404);
        }

         // valido los datos
         if (empty($req->body->posicion) || empty($req->body->clubId) || empty($req->body->liga)) {
            return $this->viewJugadores->response('Faltan completar datos', 400);
        }

        // obtengo los datos      
        $posicion = $req->body->posicion;       
        $clubId = $req->body->clubId;  
        $liga = $req->body->liga;  
        

        // actualiza la tarea
        $this->modelJugadores->editJugador( $clubId,$posicion, $liga, $id);

        // obtengo la tarea modificada y la devuelvo en la respuesta
        $jugador = $this->modelJugadores->getDetallesJugadores($id);
        $this->viewJugadores->response($jugador, 200);
    }



    function get($req, $res)
    {
        $id = $req->params->id;
        $jugador = $this->modelJugadores->getDetallesJugadores($id);
        if (!$jugador) {
            $this->viewJugadores->response('el jugador con el id ' . $id . ' no existe');
        } 
         return  $this->viewJugadores->response($jugador);
    }

   

    public function delete($req, $res)
    {
        $id = $req->params->id;

        $jugador=$this->modelJugadores->getDetallesJugadores($id);

        if(!$jugador){
          $this->viewJugadores->response('el jugador con id ' . $id . ' no existe', 404);
        } 
         $this->modelJugadores->remove($id);
         $this->viewJugadores->response('el jugador con id ' . $id . ' fue eliminado');
    }
}
