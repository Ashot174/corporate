<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class IndexController extends AdminController {
    //

    public function __construct() {

        parent::__construct();

        $this->template = env('THEME').'.admin.index';
    }

    public function index(){
        //dd(Auth::user());
        $this->title = 'Панель администратора';

        return $this->renderOutput();
    }
}
