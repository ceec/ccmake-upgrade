<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Boy;
use App\Models\Skill;
use App\Models\Minievent;
use App\Models\Minieventchoice;
use App\Models\Event;

use App\Models\Cardtag;
use App\Models\Tag;
use App\Models\Unit;

use App\Models\Story;
use App\Models\Chapter;
use App\Models\Slide;

use App\Models\Blog;
use App\Models\Projectstep;
use App\Models\Project;

use Auth;

class BlogController extends Controller {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Add card  UI
     *
     * @return \Illuminate\Http\Response
     */
    public function addDisplay() {
            //get list of projects to choose what one to work with
            $projects = Project::orderBy('name','ASC')->pluck('name','id');


            return view('dashboard.blogAdd')
                ->with('projects',$projects);
    } 

    /**
     * Add blog post 
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request) {

        $this->validate($request, [
            'name' => 'required',
        
        ]);

        $b = new Projectstep;
        $b->project_id = $request->input('project_id');
        $b->name = $request->input('name');
        $b->text = $request->input('text');
        $b->started_at = $request->input('started_at');
        $b->completed_at = $request->input('completed_at');
        $b->complete = 0;
        $b->updated_by = Auth::id();  
        $b->save();


        return redirect('/dashboard');          
    } 


    /**
     * List blog posts for eiting
     *
     * @return \Illuminate\Http\Response
     */
    public function listDisplay() {
            $blogs = Projectstep::orderBy('created_at','DESC')->get();

            return view('dashboard.blogList')
            ->with('blogs',$blogs);
    } 

    /**
     * UI for eding
     *
     * @return \Illuminate\Http\Response
     */
    public function editDisplay($blog_id) {
            $blog = Projectstep::find($blog_id);
            $projects = Project::pluck('name','id');

            return view('dashboard.blogEdit')
            ->with('blog',$blog)
            ->with('projects',$projects);
    } 


    /**
     * Edit blog post 
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {
        $blog_id = $request->input('blog_id');

        $up = Projectstep::find($blog_id);
        $up->project_id = $request->input('project_id');
        $up->name = $request->input('name');
        $up->text = $request->input('text');
        $up->started_at = $request->input('started_at');
        $up->completed_at = $request->input('completed_at');        
        $up->updated_by = Auth::id();  
        $up->save();
   
        return redirect('/dashboard/blog/edit/'.$blog_id);       
    } 


}
