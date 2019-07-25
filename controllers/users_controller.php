<?php
require_once('controllers/base_controller.php');
require_once('models/Users.php');
/**
 * User controler
 */
class UsersController extends BaseController
{
    public function __construct()
    {
        $this->folder = 'users';
    }
    public function index()
    {
        $users = UsersModel::all();
        // echo $users;
        return $this->render('index', $users);
    }

    public function getCreate()
    {
        return $this->render('create');
    }

    public function postCreate()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $date     =  date("Y/m/d");
        if ($_POST && trim($name) != '' && trim($email) != '' && trim($password) != '') {
            $frompost=[
                'username' => $name,
                'email' => $email,
                'password' => $password,
                'created_at' => $date,
                'status' => 1,
            ];
            $user = UsersModel::create($frompost);
            return header('location: ./index.php');
        }
        return $this->render('create');
    }

    public function getEdit()
    {
        $id   = $_GET['id'];
        $user = UsersModel::find($id);
        $user = (array) $user;
        return $this->render('edit', $user);
    }

    public function postEdit()
    {
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $date     =  date("Y/m/d");
        $id       = $_POST['id'];
        if ($_POST && trim($name)!='' && trim($email)!='' && trim($password)!='') {
            $frompost=[
                'username'  =>$name,
                'email'     =>$email,
                'password'  =>$password,
                'created_at' =>$date,
                'status'    =>1
            ];
            $user = UsersModel::edit($id, $frompost);
            return header('location: ./index.php');
        }
        return $this->render('edit');
    }

    public function delete()
    {
        $id   = $_GET['id'];
        $user = UsersModel::delete($id);
        echo $user;
    }

    public function changeStatus()
    {
        $id   = $_GET['id'];
        $user = UsersModel::status($id);
        echo $user;
    }
}
