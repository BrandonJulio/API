<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Allow: GET, POST, PUT, DELETE');
    header('content-type: application/json; charset=utf-8');
    require_once 'productsModel.php';
    $productsModel = new productsModel();
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
            $respuesta = $productsModel->getProducts();
            echo json_encode($respuesta);
        break;
        case 'POST':
            $_POST = json_decode (file_get_contents('php://input', true));
            if(!isset($_POST->name) || is_null($_POST->name) || empty(trim($_POST->name)) || strlen($_POST->name)>80){
                $respuesta =['error','El nombre del producto esta vacio y no debe de exceder los 80 caracteres'];
            }
            else if(!isset($_POST -> description)|| is_null($_POST->description) || empty(trim($_POST->description))|| strlen($_POST->description)>150){
                $respuesta = ['error','La descripcion del producto esta vacia y no debe de exceder los 150 caracteres'];
            }
            else if(!isset($_POST->price) || is_null($_POST->price) || empty(trim($_POST->price))|| !is_numeric($_POST->price)|| strlen($_POST->price)>20){
                $respuesta = ['error','El precio del producto esta vacio, debe de ser tipo numérico y no tener más de 20 caracteres'];
            }
            else{
                $respuesta = $productsModel->saveProducts($_POST->name,$_POST->description,$_POST->price);
            }
            echo json_encode($respuesta);
            break;
        case 'PUT':
            $_PUT = json_decode(file_get_contents('php://input'));
            if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
                $respuesta =['error','El ID del producto esta vacio'];
            }
            else if(!isset($_PUT->name) || is_null($_PUT->name) || empty(trim($_PUT->name))|| strlen($_PUT->name)>80){
                $respuesta =['error','El nombre del producto esta vacio y no debe de exceder los 80 caracteres'];
                }
            else if(!isset($_PUT -> description)|| is_null($_PUT->description) || empty(trim($_PUT->description))|| strlen($_PUT->description)>150){
                $respuesta = ['error','La descripcion del producto esta vacia y no debe de exceder los 150 caracteres'];
            }
                else if(!isset($_PUT->price) || is_null($_PUT->price) || empty(trim($_PUT->price))|| !is_numeric($_PUT->price)|| strlen($_PUT->price)>20){
                $respuesta = ['error','El precio del producto esta vacio, debe de ser tipo numérico y no tener más de 20 caracteres'];
            }
            else{
                $respuesta = $productsModel->updateProducts($_PUT->id,$_PUT->name,$_PUT->description,$_PUT->price);
            }
            echo json_encode($respuesta);
            break;
        case 'DELETE':
            $_DELETE = json_decode(file_get_contents('php://input',true));
            if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
                $respuesta =['error','El id del producto esta vacio'];
            }
            else{
                $respuesta = $productsModel->deleteProducts($_DELETE->id);
            }
            echo json_encode($respuesta); 
            break;
    }
?>
