<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Projectstep;
use App\Models\Projectsteptag;
use App\Models\Tag;


class PageController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $steps = Projectstep::orderBy('completed_at','desc')->get();

        return  view('pages.index')
        ->with('steps',$steps);
    }
}
