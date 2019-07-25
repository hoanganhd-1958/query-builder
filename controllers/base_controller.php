<?php
/**
 *
 */
class BaseController
{
    protected $folder;

    public function render($file, $data = [])
    {
        $view_file = 'views/' . $this->folder . '/' . $file . '.php';
        if (isset($view_file)) {
            extract($data);
            ob_start();
            require_once($view_file);
            $content = ob_get_clean();
            require_once('views/layouts/application.php');
        } else {
            header('Location: ./pages/error');
        }
    }
}
