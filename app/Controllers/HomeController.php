<?php
class HomeController {
    public function main($req, $res) {
        $res->send(render('home'));
    }
}