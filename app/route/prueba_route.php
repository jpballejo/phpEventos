<?php
$app->group('/coso/',function(){

	$this->get('prueba', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('anda');
});});


