<?php
    $controllers = [
        'pages' => ['index', 'error'],
        'users' => ['index', 'getCreate', 'postCreate', 'getEdit', 'postEdit', 'delete', 'changeStatus']
    ]; // Các controllers trong hệ thống và các action có thể gọi ra từ controller đó.

    // Nếu các tham số nhận được từ URL không hợp lệ (không thuộc list controller và action có thể gọi
    // thì trang báo lỗi sẽ được gọi ra.
    if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
        $controller = 'pages';
        $action = 'error';
    }

    // Nhúng file định nghĩa controller vào để có thể dùng được class định nghĩa trong file đó
    require_once('controllers/'.$controller.'_controller.php');
    $klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
    $controller = new $klass;
    $controller->$action();
