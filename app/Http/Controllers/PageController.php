<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Movie;
use App\Models\Project;
use App\Models\Projectstep;
use App\Models\Projectsteptag;
use App\Models\Set;
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

    /**
     * Display the selected categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($category){
        //can pass through an id or an url
        if (ctype_digit($category)){
            $category = Category::where('id','=',$category)->first();
        } else {
            $category = Category::where('name','=',$category)->first();
        }

        //when bad url is passed
        if (empty($category)) {
            //want to go to 404 page 
            abort(404);
        }  

        $steps = new Projectstep;
        $steps = $steps->select('projectsteps.*')->join('projects','projects.id','=','projectsteps.project_id')->where('projects.category_id','=',$category->id)->orderBy('projectsteps.completed_at','desc')->get();

        return  view('pages.index')
        ->with('steps',$steps);
    }   
    
     /**
     * Display the selected projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function project($project)
    {
        //can pass through an id or an url
        if (ctype_digit($project)){
            $project = Project::where('id','=',$project)->first();
        } else {
            $project = Project::where('url','=',$project)->first();
        }

        //when bad url is passed
        if (empty($project)) {
            //want to go to 404 page 
            abort(404);
        }  


        $steps = Projectstep::where('project_id','=',$project->id)->orderBy('completed_at','DESC')->get();

       // $projects = Category::all();

        return  view('pages.index')
        ->with('project',$project)
        ->with('steps',$steps);
    }   

    /////specific pages   
    /**
     * Movie List
     *
     * @return \Illuminate\Http\Response
     */
    public function movies(){
        $movies = Movie::orderBy('time','desc')->get();

        return  view('pages.movies')
        ->with('movies',$movies);
    }  

    /**
     * Pokemon cards
     *
     * @return \Illuminate\Http\Response
     */
    public function pokemoncards(){
        $sets = Set::orderBy('id','asc')->get();

        return  view('pages.pokemoncards')
        ->with('sets',$sets);
    }  

}
