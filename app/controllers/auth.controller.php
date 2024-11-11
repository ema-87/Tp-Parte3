<?php

// Coordinador entre vista y modelo
require_once 'app/models/user.model.php';
require_once 'app/views/auth.view.php';

class authController
{

    private $modelUser;
    private $viewAuth;

    function __construct()
    {

        // instancio las clases en model y view para utilizar sus metodos dentro de la clase
        $this->modelUser = new userModel();
        $this->viewAuth = new authView();
    }

    function showLogin()
    {
        $this->viewAuth->showLogin();
    }

    function login()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            // Obtener el usuario desde la base de datos
            $userFromDB = $this->modelUser->getUserByName($usuario);
            if ($userFromDB) {
                if (password_verify($password, $userFromDB->contrasena)) {
                    $_SESSION['ID_USER'] = $userFromDB->id;
                    $_SESSION['USER'] = $userFromDB->nombre;
                    $_SESSION['LAST_ACTIVITY'] = time();

                    header('Location: ' . BASE_URL); // Redirigir al home o dashboard
                } else {
                    return $this->viewAuth->showError('Contraseña incorrecta');
                }
            } else {
                return $this->viewAuth->showError('Usuario no encontrado');
            }
        }
    }

    function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();

        header('Location: ' . BASE_URL . 'IniciarSesion');
        exit();
    }
}
