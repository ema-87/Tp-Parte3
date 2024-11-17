    <?php
    include_once 'app/models/clubes.model.php';
    include_once 'app/view/json.view.php';
    class clubApiController
    {

        private $modelClubes;
        private $view;

        function __construct()
        {
            $this->modelClubes = new clubModel();
            $this->view = new JsonView();
        }

            public function getAll($req, $res){
                $liga = null;
                
                if(isset($req->query->liga)){
                    $liga = $req->query->liga;
                }
        
                $orderBy = false;
                
                if(isset($req->query->orderBy)){
                    $orderBy = $req->query->orderBy;
                }
        
                $orderCamp = false;
        
                if(isset($req->query->orderCamp)){
                    $orderCamp = $req->query->orderCamp;
                }
                
                $clubes = $this->modelClubes->getAll($liga, $orderBy, $orderCamp);
        
                $this->view->response($clubes);
                }
        


        public function create($req, $res) {

            // valido los datos
            if (empty($req->body->club) || empty($req->body->liga)) {
                return $this->view->response('Faltan completar datos', 400);
            }

            // obtengo los datos
            $club = $req->body->club;       
            $liga = $req->body->liga;       
        
            // inserto los datos
            $id = $this->modelClubes->insert($club, $liga);

            if (!$id) {
                return $this->view->response("Error al insertar el club", 500);
            }

            // buena práctica es devolver el recurso insertado
            $club = $this->modelClubes->getClub($id);
            return $this->view->response($club, 201);
        }


        public function update($req, $res) {
            $id = $req->params->id;

            // verifico que exista
            $club = $this->modelClubes->getClub($id);
            if (!$club) {
                return $this->view->response("el club con el id=$id no existe", 404);
            }

            // valido los datos
            if (empty($req->body->club) || empty($req->body->liga)) {
                return $this->view->response('Faltan completar datos', 400);
            }

            // obtengo los datos             
            $clubId = $req->body->club;  
            $liga = $req->body->liga;  
            

            // actualiza la tarea
            $this->modelClubes->editClub( $clubId, $liga, $id);

            // obtengo la tarea modificada y la devuelvo en la respuesta
            $club = $this->modelClubes->getClub($id);
            $this->view->response($club, 200);
        }


        function get($req, $res)
        {
            $id = $req->params->id;
            $club = $this->modelClubes->getClub($id);
            if (!$club) {
                $this->view->response('el club con el id ' . $id . ' no existe');
            } 
            return  $this->view->response($club);
        }   

    
            public function delete($req, $res)
            {
                $id = $req->params->id;

                $club=$this->modelClubes->getClub($id);

                if(!$club){
                $this->view->response('el club con id ' . $id . ' no existe', 404);
                } 
                $this->modelClubes->remove($id);
                $this->view->response('el club con id ' . $id . ' fue eliminado');
            }
        }     
