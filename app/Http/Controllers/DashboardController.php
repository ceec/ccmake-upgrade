<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Group;
use App\Models\Type;

class DashboardController extends Controller {

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    /**
     * Books
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(){
        $books = Book::where('type_id','=',0)->orderBy('created_at','desc')->get();
        $types = Type::all();

        return  view('pages.books')
        ->with('types',$types)
        ->with('books',$books);
    }

  

}
