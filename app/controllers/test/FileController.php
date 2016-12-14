<?php

namespace MyApp\Controllers\Test;

use limx\func\Encoder;

class FileController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        return $this->view->render('test/file', 'index');
    }

    public function uploadAction()
    {
        $data = $this->request->get('data');
        if (preg_match('/^data:(.*);base64,/', $data, $result)) {
            if (!empty($result[0])) {
                // 匹配到数据 保存数据
                $data = str_replace($result[0], '', $data);
                $data = base64_decode($data);

                $path = 'uploads/file';
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $file = $path . '/' . uniqid() . '.test';
                if (file_put_contents($file, $data)) {
                    return success($file);
                }
            }
        }
        return success($data);
    }

}

