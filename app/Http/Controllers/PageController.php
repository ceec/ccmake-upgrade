<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use App\Models\Book;
use App\Models\Category;
use App\Models\Group;
use App\Models\Item;
use App\Models\Mineral;
use App\Models\Movie;
use App\Models\Onepieceset;
use App\Models\Pokemonset;
use App\Models\Project;
use App\Models\Projectstep;
use App\Models\Projectsteptag;
use App\Models\Resource;
use App\Models\Song;
use App\Models\Tag;
use App\Models\Volume;

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

        return  view('pages.projectsall')
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
     * One piece cards
     *
     * @return \Illuminate\Http\Response
     */
    public function onepiece(){
        $sets = Onepieceset::get();

        return  view('pages.onepiece')
            ->with('sets',$sets);
    }  

    /**
     * Pokemon cards
     *
     * @return \Illuminate\Http\Response
     */
    public function pokemoncards(){
        $vintage = Pokemonset::where('generation_id','=',0)->orderBy('release_date','asc')->get();

        $five = Pokemonset::where('generation_id','=','5')->get();
        $six = Pokemonset::where('generation_id','=','6')->get();

        $modern = Pokemonset::where('generation_id','=',8)->orWhere('generation_id','=',9)->orderBy('release_date','asc')->get();

        return  view('pages.pokemoncards')
            ->with('vintage',$vintage)
            ->with('five',$five)
            ->with('six',$six)
            ->with('modern',$modern);
    }  

    ///travel
     /**
     * counites
     *
     * @return \Illuminate\Http\Response
     */
    public function counties(){
        return view('pages.counties');
    }

    /**
     * Chelsea Doujin List
     *
     * @return \Illuminate\Http\Response
     */
    public function chelsea(){
        $volumes = Volume::where('user_id','=',2)->get();
       

        return  view('pages.chelsea')
            ->with('volumes',$volumes);
    }      

    /**
     * Manga
     *
     * @return \Illuminate\Http\Response
     */
    public function manga(){
        $mangas = Group::where('type_id','=',1)->get();

        $artbooks = Group::where('type_id','=',2)->get();
        return view('pages.manga')
            ->with('mangas',$mangas)
            ->with('artbooks',$artbooks);
    }


     /**
     * projects
     *
     * @return \Illuminate\Http\Response
     */
    public function projects(){
        //$projects = Project::all();
        //$projects = DB::select('SELECT *, (SELECT MAX(projectsteps.updated_at) FROM projectsteps WHERE projectsteps.project_id = projects.id) AS last_step_updated_at FROM projects ORDER BY (SELECT MAX(projectsteps.updated_at) FROM projectsteps WHERE projectsteps.project_id = projects.id ) DESC');

        // $projects = Project::where(function ($subquery){
        //     $subquery->select('updated_at')->from('projectsteps')->where('proj')
        // });

        $projects = Project::select('projects.*')->selectSub('MAX(`projectsteps`.`updated_at`)', 'lastUpdated')->join('projectsteps','projects.id','=','projectsteps.project_id')->groupBy('projects.id')->orderBY('lastUpdated','desc')->get();

        //dd($projects);
         //$projects = Project::select('projects.*')->join('projectsteps','projects.id','=','projectsteps.project_id')->orderBy('projectsteps.updated_at','desc')->get();
         //2018-10-05 18:33
         //leaving this for now, they arent unique per project which i need to figure out
        
        // SELECT * FROM `projectsteps` WHERE project_id IN (
        //     SELECT DISTINCT(project.

        // SELECT *
        // FROM some_table 
        // WHERE relevant_field IN
        // (
        //     SELECT relevant_field
        //     FROM some_table
        //     GROUP BY relevant_field
        //     HAVING COUNT(*) > 1
        // )
        return view('pages.projects')
        ->with('projects',$projects);
    }    

    ///writing
     /**
     * writing
     *
     * @return \Illuminate\Http\Response
     */
    public function wordcount(){
        //get the total wordcount per story.
       //so just want last one from each story, then add those all up

        //https://stackoverflow.com/questions/5554075/mysql-get-last-distinct-set-of-records
        //SELECT * FROM wordcounts WHERE id IN (SELECT MAX(id) FROM wordcounts GROUP BY document_id)
        
        $total = DB::select('SELECT sum(count) as total FROM wordcounts WHERE id IN (SELECT MAX(id) FROM wordcounts GROUP BY document_id)');

        $total = $total[0]->total;


        return view('pages.wordcount')
        ->with('total',$total);
    }

    /**
     * Resources
     *
     * @return \Illuminate\Http\Response
     */
    public function resources(){
        $resources = Resource::all();
       

        return  view('pages.resources')
            ->with('resources',$resources);
    }    

    /**
     * Bookshelf
     *
     * @return \Illuminate\Http\Response
     */
    public function bookshelf(){
        $books = Book::where('read','=',0)->orderBy('created_at','desc')->get();
        $bookjson = json_encode($books);

        return  view('pages.bookshelf')
        ->with('bookjson',$bookjson)
        ->with('books',$books);
    }  

     /**
     * Time - cause its hard
     *
     * @return \Illuminate\Http\Response
     */
    public function time(){
        return  view('pages.time');
    }  
    
    /**
     * Rocks
     *
     * @return \Illuminate\Http\Response
     */
    public function rocks()
    {
        //get all the minerals
        $minerals = Mineral::orderBy('name','asc')->paginate(50);

        //get a picture
        foreach ($minerals as $min) {
            $image = Item::where('mineral_id','=',$min->id)->pluck('image')->toArray();
            if (isset($image[0])) {
                $test = $image[0];
            } else {
                $test = 'example.jpg';
            }
            
            $min->image = $test;
        }   

        return view('pages.minerals')
        ->with('minerals',$minerals);
    }

    /**
     * show each rock
     *
     * @return \Illuminate\Http\Response
     */    
    public function showMinerals($mineral_name)
    {

        //get the mineral id
        $m = Mineral::where('name','=',$mineral_name)->first();

        //get all the items
        $items = Item::where('mineral_id','=',$m->id)->paginate(18);

        return view('pages.rocks')
        ->with('items',$items);
    }

}
