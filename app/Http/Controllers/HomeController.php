<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Group;
use App\Models\Type;

class HomeController extends Controller {

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
