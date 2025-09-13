@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>ccmake</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <h4>Blog</h4>
                            <a href="/dashboard/blog/add">Add New Post</a><br>
                            <a href="/dashboard/blog/list">Edit Post</a>        
                        </div>
                        <div class="col-md-3">  
                            <h4> To Do</h4>
                            <a href="/dashboard/tasks">To Do List</a><br>     
                        </div>
                        <div class="col-md-3">  
                            <h4>Project</h4>
                            <a href="/dashboard/project/add">Add New Project</a><br>      
                            <a href="/dashboard/project/list">Edit Projects</a>      
                        </div>   
                        <div class="col-md-3">  
                            <h4>Resource</h4>
                            <a href="/dashboard/resource/add">Add New Resource</a><br>      
                            <a href="/dashboard/resource/list">Edit Resources</a>      
                        </div>                                                
                    </div>
                    <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <h2>Tools</h2>
                                <a href="/dashboard/wordcount">Wordcount</a>
                            </div>
                            <div class="col-md-3">
                                <h2>Rocks</h2>
                                <a href="/dashboard/item/add">Add Item</a><br>
                                <a href="/dashboard/item/list">Edit Item</a><br>
                                <a href="/dashboard/mineral/add">Add Mineral</a><br>
                                <a href="/dashboard/mineral/list">Edit Mineral</a>                                
                            </div>  
                            <div class="col-md-3">
                                <h2>Pages</h2>
                                <a href="/movies">Movies</a><br>
                                <a href="/manga">Manga</a><br>
                                <a href="/counties">Counties</a><br>
                                <a href="/wordcount">Wordcount</a><br>
                            </div>   
                            <div class="col-md-3">
                                <h2>Pages</h2>
                                <a href="/resources">Resources</a><br>
                                <a href="/bookshelf">Bookshelf</a><br>
                                <a href="/rocks">Rocks</a><br>
                                <a href="/books">Books</a><br>
                            </div>  
                            <div class="col-md-3">
                                <h2>Music</h2>
                                <a href="/dashboard/artist/add">Add Artist</a><br>
                                <a href="/dashboard/artist/list">Edit Artist</a><br>
                                <a href="/dashboard/album/add">Add Album</a><br>
                                <a href="/dashboard/album/list">Edit Album</a><br>
                                <a href="/dashboard/song/add">Add Song</a><br>
                                <a href="/dashboard/song/list">Edit Song</a><br>
                            </div>   
                            <div class="col-md-3">
                                <h2>Queue</h2>
                                <a href="/dashboard/queue/add">Add Queue</a><br>
                                <a href="/dashboard/queue/list">Edit Queue</a><br>
                            </div>                                                                                                              
                        </div>
                    <hr>
                    <h2>Database</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <h4>Purchases</h4>
                            <a href="/dashboard/purchase/add">Add New Purchase</a><br>      
                            <a href="/dashboard/purchase/list">Edit Purchase</a>     
                        </div>
                        <div class="col-md-3">
                            <h4>Stores</h4>
                            <a href="/dashboard/store/add">Add New Store</a><br>      
                            <a href="/dashboard/store/list">Edit Store</a>                                 
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-3">
 
                        </div>
                        <div class="col-md-3">
                            <h4>Notes</h4>
                            <a href="/dashboard/note/add">Add New Note</a><br>
                            <a href="/dashboard/note/list">Edit Note</a><br>
                        </div>
                        <div class="col-md-3">
                            <h4>Books</h4>
                            <a href="/dashboard/book/add">Add New Book</a><br>
                            <a href="/dashboard/book/list">Edit Book</a><br>
                        </div>  
                       <div class="col-md-3">
                            <h4>Volumes</h4>
                            <a href="/dashboard/volume/add">Add New Volume</a><br>
                            <a href="/dashboard/volume/list">Edit Volume</a><br>
                        </div>                                                
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h4>Groups</h4>
                            <a href="/dashboard/group/add">Add Group</a><br>
                            <a href="/dashboard/group/list">Edit Group</a><br>
                        </div>  
                        <div class="col-md-3">
                            <h4>Authors</h4>
                            <a href="/dashboard/author/add">Add Author</a><br>
                            <a href="/dashboard/author/list">Edit Author</a><br>
                        </div>  
                        <div class="col-md-3">
                            <h4>Publishers</h4>
                            <a href="/dashboard/publisher/add">Add Publisher</a><br>
                            <a href="/dashboard/publisher/list">Edit Publisher</a><br>
                        </div>        
                        <div class="col-md-3">
                            <h4>Types</h4>
                            <a href="/dashboard/type/add">Add Type</a><br>
                            <a href="/dashboard/type/list">Edit Type</a><br>
                        </div>                                                                                          
                    </div>

                </div>             
            </div>
        </div>
    </div>
</div>
@endsection
