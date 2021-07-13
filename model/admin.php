<?php

header("Content-type: application/json");

#Argumentos mysqli($host = null, $username = null, $passwd = null, $dbname = null, $port = null, $socket = null)
$connection = new mysqli('localhost', 'root', 'root', 'database_animal');

if ($connection->connect_error) {
    die("Conexion fallida" . $connection->connect_error);
}

$res = array('error' => false);
$action = '';

#Obtiene el tipo de request
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

#if si el request es leer los historicos
if ($action == 'readHistory') {

    #Realiza la Consulta SQL SELECT
    $sql = $connection->query(
        "SELECT au.id_auditoria AS consecutivo, us.nombres AS nombres, us.apellidos AS apellidos, 
            au.fecha AS fecha, au.proceso AS proceso, au.detalle AS detalle 
            FROM auditoria AS au INNER JOIN usuario AS us ON au.fk_usuario = us.id_usuario
            ORDER BY consecutivo DESC"
    );

    #Guarda la consulta en un Array
    $history = array();
    while ($row = $sql->fetch_assoc()) {
        array_push($history, $row);
    }

    #Agrega la consulta en el response
    $res['history'] = $history;
}

#if si el request es leer los usuarios
if ($action == 'readUsers') {

    #Realiza la Consulta SQL SELECT
    $sql = $connection->query(
        "SELECT documento_identidad, nombres, apellidos, email, estado
            FROM usuario"
    );

    #Guarda la consulta en un Array
    $users = array();
    while ($row = $sql->fetch_assoc()) {
        array_push($users, $row);
    }

    #Agrega la consulta en el response
    $res['users'] = $users;
}

#if si el request es leer los roles
if ($action == 'readRols') {

    #Realiza la consulta SQL SELECT
    $sql = $connection->query(
        "SELECT id_rol, descripcion 
            FROM rol"
    );

    #Guarda la consulta en un Array
    $rols = array();
    while ($row = $sql->fetch_assoc()) {
        array_push($rols, $row);
    }

    #Agrega la consulta en el response
    $res['rols'] = $rols;
}

#if si el request es leer los tipos de documentos
if ($action == 'readDocumentType') {

    #Realiza la consulta SQL SELECT
    $sql = $connection->query(
        "SELECT id_tipo_documento, descripcion
            FROM tipo_documento"
    );

    #Guarda la consulta en un Array
    $documents_types = array();
    while ($row = $sql->fetch_assoc()) {
        array_push($documents_types, $row);
    }

    #Agrega la consutla en el response
    $res['document_types'] = $documents_types;
}

#if si el request es leer un crypto
if ($action == 'readCrypto') {

    #Obtiene los campos necesarios para buscar el registro
    $descripcion = $_POST['text'];

    #Los datos del Request deben de venir definidos
    if (empty($descripcion)) {
        $res['error'] = true;
    } else {
        #Realiza la consulta SQL SELECT
        $sql = $connection->query(
            "SELECT id_crypto, llave, descripcion
            FROM crypto
            WHERE descripcion = '$descripcion'"
        );

        #Guarda la consulta en un Array
        $crypto = array();
        while ($row = $sql->fetch_assoc()) {
            array_push($crypto, $row);
        }

        #Agrega la consutla en el response
        $res['crypto'] = $crypto;
    }
}

#if si el request es leer un User
if ($action == 'readUser') {

    #Obtiene los campos necesarios para buscar el registro
    $document_number = $_POST['document_number'];

    #Los datos del Request deben de venir definidos
    if (empty($document_number)) {
        $res['error'] = true;
    } else {
        #Realiza la consulta SQL SELECT
        $sql = $connection->query(
            "SELECT id_usuario AS id_user, fk_tipo_documento AS document_type, fk_rol AS user_rol, login AS user_name, password, nombres AS first_name, apellidos AS last_name, documento_identidad AS document_number, email, telefono AS telephone_number, estado AS state
            FROM usuario
            WHERE documento_identidad = '$document_number'"
        );

        #Guarda la consulta en un Array
        $user = array();
        while ($row = $sql->fetch_assoc()) {
            array_push($user, $row);
        }

        #Agrega la consutla en el response
        $res['user'] = $user;
    }
}

#if si el request es crear un usuario
if ($action == 'createHistory') {

    #Obtiene los campos necesarios para crear el usuario
    $fk_user = $_POST['user'];
    $process = $_POST['process'];
    $detail = $_POST['detail'];

    #Los datos del Request deben de venir definidos
    if (empty($fk_user) and empty($process) and empty($detail)) {
        $res['error'] = true;
    } else {
        # Realiza la consulta SQL Inset into
        $sql = $connection->query(
            "INSERT INTO auditoria(fk_usuario, proceso, detalle) 
        VALUES ('086','$process','$detail')"
        );

        # Usuario creado satisfactoriamente si el sql es == True, de lo contrario envia un error
        if ($sql) {
            $res['error']   = false;
            $res['message'] = "Registro Auditoria creado exitosamente!";
        } else {
            $res['error']   = true;
            $res['message'] = "Error, registro Auditoria no agregado" . $connection->error;
        }
    }
}

#if si el request es crear un usuario
if ($action == 'createUser') {

    #Obtiene los campos necesarios para crear el usuario
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $document_type = $_POST['document_type'];
    $document_number = $_POST['document_number'];
    $user_rol = $_POST['user_rol'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $telephone_number = $_POST['telephone_number'];
    $password = $_POST['password'];

    #Los datos del Request deben de venir definidos
    if (
        empty($first_name) and empty($last_name) and empty($document_type) and empty($document_number)
        and empty($user_rol) and empty($user_name) and empty($email) and empty($telephone_number) and empty($password)
    ) {
        $res['error'] = true;
    } else {
        $user_type = '';

        #De acuerdo al rol que desempeñe el usuario el sistema clasifica en dos tipos A = Administrativo, U = Usuario
        if ($user_rol == '01') {
            $user_type = 'A';
        } else {
            $user_type = 'U';
        }

        # Realiza la consulta SQL INSERT INTO
        $sql = $connection->query(
            "INSERT INTO usuario (fk_tipo_documento, fk_rol, login, password, nombres, apellidos, documento_identidad, email, telefono, tipo_user) 
            VALUES ('$document_type','$user_rol','$user_name','$password','$first_name','$last_name','$document_number', '$email', '$telephone_number','$user_type')"
        );

        # Usuario creado satisfactoriamente si el sql es == True, de lo contrario envia un error
        if ($sql) {
            $res['error']   = false;
            $res['message'] = "Usuario creado exitosamente!";
        } else {
            $res['error']   = true;
            $res['message'] = "Error, Usuario no agregado" . $connection->error;
        }
    }
}

#if si el request es crear un crypto
if ($action == 'createCrypto') {

    #Obtiene los campos necesarios para crear el crypto
    $key = $_POST['key'];
    $text = $_POST['text'];

    #Los datos del Request deben de venir definidos
    if (empty($key) and empty($text)) {
        $res['error'] = true;
    } else {
        # Realiza la consulta SQL Inset into
        $sql = $connection->query(
            "INSERT INTO crypto (llave, descripcion) 
        VALUES ('$key','$text')"
        );

        # Usuario creado satisfactoriamente si el sql es == True, de lo contrario envia un error
        if ($sql) {
            $res['message'] = "Crypto creado exitosamente!";
        } else {
            $res['error']   = true;
            $res['message'] = "Error, Crypto no agregado" . $connection->error;
        }
    }
}

#if si el request es actualizar un usuario
if ($action == 'updateUser') {

    #Obtiene los campos necesarios para actualizar el usuario
    $id_user = $_POST['id_user'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $document_type = $_POST['document_type'];
    $document_number = $_POST['document_number'];
    $user_rol = $_POST['user_rol'];
    $email = $_POST['email'];
    $telephone_number = $_POST['telephone_number'];
    $password = $_POST['password'];
    $state = $_POST['state'];

    #Los datos del Request deben de venir definidos
    if (
        empty($id_user) and empty($first_name) and empty($last_name) and empty($document_type) and empty($document_number)
        and empty($user_rol) and empty($email) and empty($telephone_number) and empty($password) and empty($state)
    ) {
        $res['error'] = true;
    } else {
        $user_type = '';

        #De acuerdo al rol que desempeñe el usuario el sistema clasifica en dos tipos A = Administrativo, U = Usuario
        if ($user_rol == '01') {
            $user_type = 'A';
        } else {
            $user_type = 'U';
        }

        # Realiza la consulta SQL UPDATE
        $sql = $connection->query(
            "UPDATE usuario
        SET fk_tipo_documento = $document_type, fk_rol = $user_rol, password = '$password', nombres = '$first_name', apellidos = '$last_name', 
        documento_identidad = '$document_number', email = '$email', telefono = '$telephone_number', tipo_user = '$user_type', estado = '$state'
        WHERE id_usuario = $id_user"

        );

        # Usuario creado satisfactoriamente si el sql es == True, de lo contrario envia un error
        if ($sql) {
            $res['error']   = false;
            $res['message'] = "Usuario actualizado exitosamente!";
        } else {
            $res['error']   = true;
            $res['message'] = "Error, Usuario no actualizado" . $connection->error;
        }
    }
}

#if si el request es eliminar un registro de Crypto
if ($action == 'deleteCrypto') {

    #Obtiene los campos necesarios para buscar el registro
    $descripcion = $_POST['text'];

    #Los datos del Request deben de venir definidos
    if (empty($descripcion)) {
        $res['error'] = true;
    } else {
        #Realiza la consulta SQL DELETE FROM
        $sql = $connection->query(
            "DELETE FROM crypto
            WHERE descripcion = '$descripcion'"
        );

        # Usuario creado satisfactoriamente si el sql es == True, de lo contrario envia un error
        if ($sql) {
            $res['error']   = false;
            $res['message'] = "Crypto Eliminado exitosamente!";
        } else {
            $res['error']   = true;
            $res['message'] = "Error, Crypto no eliminado" . $connection->error;
        }
    }
}

#Se cierra la conexion 
$connection->close();

#Envia el response
echo json_encode($res);
die();
