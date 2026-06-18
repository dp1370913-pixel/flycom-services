<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    // Afficher la page d'index de la documentation (Image 2)
    public function index()
    {
        return view('admin.documentation.index');
    }
}