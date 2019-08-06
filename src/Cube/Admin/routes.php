<?php

use Cube\Cube;

return function(Cube $app){
    $app->get('/admin', 'Cube\Admin\Controller\PageController::indexAction');
};