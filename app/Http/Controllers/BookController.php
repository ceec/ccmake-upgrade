<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Group;
use App\Models\Type;

class BookController extends Controller {

    /**
     * Books
     *
     * @return \Illuminate\Http\Response
     */
    public function books(){
        $books = Book::where('type_id','=',0)->orderBy('created_at','desc')->get();
        $types = Type::all();

        return  view('pages.books')
        ->with('types',$types)
        ->with('books',$books);
    }

    /**
     * Book types
     *
     * @return \Illuminate\Http\Response
     */
    public function types($type_name){
        //get the id from the type, I keep using this function, should generalize it?
        $type = Type::where('url','=',$type_name)->first();

        $books = Book::where('type_id','=',$type->id)->orderBy('created_at','desc')->get();
        $types = Type::all();

        return  view('pages.books')
        ->with('types',$types)
        ->with('books',$books);
    }  

    /**
     * Book groups
     *
     * @return \Illuminate\Http\Response
     */
    public function groups($group_name){
        $group = Group::where('url','=',$group_name)->first();

        $books = Book::where('group_id','=',$group->id)->orderBy('created_at','desc')->get();
        $types = Type::all();

        return  view('pages.books')
        ->with('types',$types)
        ->with('books',$books);
    } 

}
