<?php
use App\Post;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function(){
    return "Hi, This about Page";
});

Route::get('/blog', 'PostController@index');
// Route::get('/post/create', 'PostController@create');
// Route::post('/post/store', 'PostController@store');

// Route::get('/post/{id}',['as' => 'post.detail',function($id){
//     echo "Post $id";
//     echo "<br/>";
//     echo "Body Post In ID $id";
// }]);

Route::resource('post','PostController');


Route::get('/insert', function(){
    // DB::insert('insert into posts(title, body, user_id) values (?,?,?)',['Belajar laravel 55','Laravel the best framework','1']);
    $data = [
        'title' => 'Disini Isian Title',
        'body'  => 'Disini Untuk Isian Body',
        'user_id'   => 6
    ];
    DB::table('posts')->insert($data);
    echo "Data berhasil ditambah";
});

Route::get('/read', function(){
    // $query = DB::select('select * from posts where id = ?',[1]);
    $query = DB::table('posts')->select('title','body')->where('id',1)->get();
    return var_dump($query);
});

Route::get('/update', function(){
    //$update = DB::update('update posts set title = "Update field title" where id = ?',[1]);
    $data = [
        'title' => 'Isian Title',
        'body'  => 'Isian Body baru'
    ];
    $update = DB::table('posts')->where('id',1)->update($data);
    return $update;
});

Route::get('/delete', function(){
    // $delete = DB::delete('delete from posts where id = ?', [1]);
    $delete = DB::table('posts')->where('id',2)->delete();
    return $delete;
});

Route::get('/posts', function(){
    $posts = Post::all();
    return $posts;
});

Route::get('/find', function(){
    $find = Post::find(5);
    return $find;
});