    <?php
    include_once 'app/models/clubes.model.php';
    include_once 'app/view/json.view.php';
    class clubApiController
    {

        private $modelClubes;
        private $viewClubes;

        function __construct()
        {
            $this->modelClubes = new clubModel();
            $this->viewClubes = new JsonView();
        }


        function getAll($req, $res)
        {
            $orderBy= false;
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }

            $club = $this->modelClubes->getAll($orderBy);
        return $this->viewClubes->response($club);
        }


        public function create($req, $res) {

            // valido los datos
            if (empty($req->body->club) || empty($req->body->liga)) {
                return $this->viewClubes->response('Faltan completar datos', 400);
            }

            // obtengo los datos
            $club = $req->body->club;       
            $liga = $req->body->liga;       
        
            // inserto los datos
            $id = $this->modelClubes->insert($club, $liga);

            if (!$id) {
                return $this->viewClubes->response("Error al insertar el club", 500);
            }

            // buena práctica es devolver el recurso insertado
            $club = $this->modelClubes->getClub($id);
            return $this->viewClubes->response($club, 201);
        }


        public function update($req, $res) {
            $id = $req->params->id;

            // verifico que exista
            $club = $this->modelClubes->getClub($id);
            if (!$club) {
                return $this->viewClubes->response("el club con el id=$id no existe", 404);
            }

            // valido los datos
            if (empty($req->body->club) || empty($req->body->liga)) {
                return $this->viewClubes->response('Faltan completar datos', 400);
            }

            // obtengo los datos             
            $clubId = $req->body->club;  
            $liga = $req->body->liga;  
            

            // actualiza la tarea
            $this->modelClubes->editClub( $clubId, $liga, $id);

            // obtengo la tarea modificada y la devuelvo en la respuesta
            $club = $this->modelClubes->getClub($id);
            $this->viewClubes->response($club, 200);
        }


        function get($req, $res)
        {
            $id = $req->params->id;
            $club = $this->modelClubes->getClub($id);
            if (!$club) {
                $this->viewClubes->response('el club con el id ' . $id . ' no existe');
            } 
            return  $this->viewClubes->response($club);
        }   

    
            public function delete($req, $res)
            {
                $id = $req->params->id;

                $club=$this->modelClubes->getClub($id);

                if(!$club){
                $this->viewClubes->response('el club con id ' . $id . ' no existe', 404);
                } 
                $this->modelClubes->remove($id);
                $this->viewClubes->response('el club con id ' . $id . ' fue eliminado');
            }
        }     
