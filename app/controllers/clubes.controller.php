<?php
include_once 'app/models/clubes.model.php';
include_once 'app/view/json.view.php';
/*class clubController
{

    private $modelClubes;
    private $modelJugadores;
    private $viewClubes;

    function __construct()
    {

        // instancio las clases en model y view para utilizar sus metodos dentro de la clase
        $this->modelClubes = new clubModel();
        $this->modelJugadores = new jugadorModel();
        $this->viewClubes = new JsonView();
    }
    function showClubes()
    {
        $clubes = $this->modelClubes->getAll();
        $this->viewClubes->response($clubes);
    }



    function getAll()
    {
        $clubes = $this->modelClubes->getAll();
        return $clubes;
    }
    function addClub()
    {
        if (!empty($_POST['liga']) && !empty($_POST['club'])) {
            $liga = $_POST['liga'];
            $club = $_POST['club'];
        } else {
            $this->viewClubes->response();
            die();
        }

        $id = $this->modelClubes->insert($liga, $club);

        if ($id) {
            header('Location: ' . BASE_URL . 'clubes');
        } else {
            echo "No se pudo agregar el parcial!";
        }
    }

    function removeClub($id)
    {
        $jugadoresByClub = $this->modelJugadores->getJugadoresByClub($id);

        if (count($jugadoresByClub) > 0) {
            echo 'No se puede eliminar el club porque tiene jugadores asociados';
        } else {
            $this->modelClubes->remove($id);
            header('Location: ' . BASE_URL . 'clubes');
        }
    }

    function editarClub($id)
    {
        if (!empty($_POST['editLiga']) && !empty($_POST['editClub'])) {
            $clubEditado = $_POST['editLiga'];
            $ligaEditada = $_POST['editClub'];


            $this->modelClubes->editClub($ligaEditada, $clubEditado, $id);

            header('Location: ' . BASE_URL . 'clubes');
            exit;
        } else {
            $this->viewClubes->showError();
        }
    }
}*/
