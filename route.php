->  Available Router Methods :


Route::match(['get', 'post'], '/', function () {		// if match with get or post
    
});


____________


Route::any('foo', function () {					// if match with any
    
});


____________


Route::get('uri', 'controller@method');


____________


->  Route with parameter :


    Route::get('/home/{id}',function(){

	return view('abc');
		
    });   

   // http://localhost/practise_laravel/home
   
   
 
____________


->  make uri route with validation :



   Route::get('home/{name}/{id}', function () 

   {
	echo "hello world ";
   })

   ->where(['id' => '[0-9]+', 'name' => '[A-Za-z]+']); 


____________


-> Named Routes :	


Route::get('user/profile', 'UserController@showProfile')->name('profile');


Controller :

class UserController extends Controller{

    public function showProfile(){
    
    	echo route('profile');
    	echo url('user/profile');
	
    }
}





____________


-> GROUP & PREFIX :

   Route::prefix('admin')->group(function () {
   
     Route::get('users', function () {

        echo "ok";

      });  
      
   });
   

hit url : http://localhost/admin/users


____________



->   Namespace :  					// folder location of controller


Route::namespace('Admin')->group(function () {				
    
    Route::get('user/profile', 'UserController@showProfile')->name('profile');
    
});



____________


->   Namespace  Group  Prefix :

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

   Route::get('user/profile', 'UserController@showProfile');

});




____________



-> compact :


   Route::get('home/{name}',function($name){

	$array_data = array('12','23','34'); 
 	
 	return view('abc',compact('array_data'));

   });



  in view.php

  <?php
  
	print_r($array_data);

  ?>



____________


-> WITH :


   return view('abc')->with('var1','data1');


  <?php
  
	echo $var1;

  ?>





____________



-> customize 404 error


Route::get('error',function(){

  abort(404);

});


create file :

view -> errors -> 404.blade.php




__________



MIDDLEWARE :

  1. middleware is a guard for route.
  2. create register then apply in route
  3. For multi auth create multiple middleware


->  create middleware :


php artisan make:middleware MiddlewareName


  // in MiddlewareName.php check session 
  
  public function handle($request, Closure $next){

	session_start();
	
        if(!isset($_SESSION['admin1']) || $_SESSION['admin1'] != "admin1"){
	
            return redirect('/');	// if not exist
	    
        }
	
        return $next($request);		// if exist proceed to next step

  }



-> register middleware

   App\http\karnel.php



   add protected $routeMiddleware (for hit specific group request):

   'Middlewarename' => \App\Http\Middleware\Middlewarename::class,
  
   or (not preferable)
   
   add protected middleware (for hit all request):
   
   \App\Http\Middleware\MiddlewareName::class,




route :

Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>'Middlewarename'], function () {

    Route::get('user/profile', 'UserController@showProfile');
    
});
