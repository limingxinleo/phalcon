<?php

namespace MyApp\Controllers\Test;

use Endroid\QrCode\QrCode;

class ToolsController extends \Phalcon\Mvc\Controller
{

    public function code2Action()
    {
        return $this->view->render('test/tools', 'code2');
    }

    public function showCode2Action($text = "Life is too short to be generating QR codes")
    {
        $text = $this->request->get('text', null, $text);
        /** composer require endroid/qrcode */
        $qrCode = new QrCode();
        $qrCode
            ->setText($text)
            ->setSize(300)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabel('phalcon-ss')
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        header('Content - Type: ' . $qrCode->getContentType());
        return $qrCode->render();
    }

    public function imgAction()
    {
        return $this->view->render('test/tools', 'img');
    }

}

