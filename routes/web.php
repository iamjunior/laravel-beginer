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

Route::get('/findWhere', function(){
    $posts = Post::where('user_id',6)->orderBy('id','asc')->take(1)->get(); //chain method
    return $posts;
});

Route::get('/create', function(){
    $post = new Post();
    $post->title = 'Isi Judul Postingan';
    $post->body = 'Isian body dari postingan';
    $post->user_id = Auth::user()->id;

    $post->save();
});

Route::get('/createpost', function(){
    $post = Post::create([
        'title'     => 'Create data dari method create',
        'body'      => 'Kita isi dengan isian post dari create method',
        'user_id'   => Auth::user()->id
    ]);
});

Route::get('/updatepost', function(){
    //$post = Post::find(5);
    $post = Post::where('id',5);
    $post->update([
        'title'     => 'Create data id 5 dari method create',
        'body'      => 'Kita isi dengan id 5isian post dari create method',
        'user_id'   => 5
        ]);
});

Route::get('/deletepost', function(){
    // $post = Post::find(3);
    // $post->delete();

    // Post::destroy([5,6]); //bisa multiple delete dengan array

    $post = Post::where('user_id',6);
    $post->delete();
});

Route::get('/softdelete', function(){
    Post::destroy([11]);
});

Route::get('/trash', function(){
    //$posts = Post::withTrashed()->get();//memanggali semua data dengan data trash
    $posts = Post::onlyTrashed()->get();//memanggali semua data dengan data trash
    
    return $posts;
});

Route::get('/restore', function(){
    $posts = Post::onlyTrashed()->restore();//merestore data yang berada dalam trash
    
    return $posts;
});

Route::get('/forcedelete', function(){
    // $posts = Post::find(12)->forceDelete();//menghapus data langsung tanpa melewati step softdelete
    // $posts = Post::onlyTrashed()->where('id',9)->forceDelete();//force delete berdasarkan id yang dipilih
    $posts = Post::onlyTrashed()->forceDelete();//force delete semua data yang sebelumnya di softdelete
    //dd($posts);//jika menggunakan forceDelete langsung
    return $posts;
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', function(){
    return Auth::user();
});

Route::get('/user','HomeController@user');