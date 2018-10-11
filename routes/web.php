<?php

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

Auth::routes();


//==================TEST===================
use App\Menu;
Route::get('menu/add', function() {
    exit;
//    Menu::create(['name' => 'Manage User', 'menu_id' => 0, 'permission_id' => null, 'menu_order' => 0, 'status' => '1', 'created_by' => 1]);

    Menu::create(['name' => 'List User', 'menu_id' => 1, 'permission_id' => 5, 'menu_order' => 0, 'status' => '1', 'created_by' => 1]);
    Menu::create(['name' => 'Add New User', 'menu_id' => 1, 'permission_id' => 6, 'menu_order' => 0, 'status' => '1', 'created_by' => 1]);
});

Route::get('menu/list', function() {
    $abilities = [
        'view'      => 'index',
        'add'       => 'create',
        'edit'      => 'edit',
        'delete'    => 'destroy'
    ];

});

//=========================================


/*
 * Admin login
 */
Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

//    Route::get('/home', 'Admin\AdminController@index')->name('admin.home');
});

/*
 * Admin routes for authenticated user only
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'languages:admin', 'menu:admin']], function() {
    Route::resource('dashboard', 'DashboardController');
    Route::resource('admins', 'AdminController');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('languages', 'LanguageController');
    Route::resource('states', 'StateController');
    Route::resource('city', 'CityController');
    Route::resource('activities', 'ActivityController');
    Route::resource('teams', 'TeamController');
    Route::resource('nutritions', 'NutritionController');
    Route::resource('menus', 'MenuController');

});

/*
 * Non-authenticated routes
 */
//Route::get('/home', 'HomeController@index')->name('home');








/*
 * Testing routes
 */
//use App\Language;
//Route::get('/lang/test', function() {
//    $lang   = Language::getAllLanguage();
//    dd($lang);
//});
//
//
//use App\State;
//Route::get('/state/create', function() {
//    $state = new State();
//    $state->status = '1';
//    $state->created_by = '1';
//    $state->save();
//
//    foreach (['en', 'hi'] as $locale) {
//        $state->translateOrNew($locale)->name = "Title {$locale}";
//    }
//
//    $state->save();
//
//    echo 'State created with translations!';
//
//});
//
//Route::get('{locale}/state/get', function($locale) {
////    $locale = 'en';
////    $locale = 'hi';
//    app()->setLocale($locale);
//
//    $states = State::where('status', '1')->get();
//    $result = array();
//    foreach($states as $state) {
//        $result[] = $state->name;
//    }
//
//    return $result;
//
//
//
//    exit;
//
//    $article = new Article();
//    $article->online = true;
//    $article->save();
//
//    foreach (['en', 'nl', 'fr', 'de'] as $locale) {
//        $article->translateOrNew($locale)->name = "Title {$locale}";
//        $article->translateOrNew($locale)->text = "Text {$locale}";
//    }
//
//    $article->save();
//
//    echo 'Created an article with some translations!';
//    exit;
//
//
//
////    $data = [
////        'en'    => ['name' => 'Amit', 'added_by' => '1', 'updated_by' => '1'],
////        'hi'    => ['name' => 'अमित',  'added_by' => '1', 'updated_by' => '1'],
////    ];
////    $nutrition = \App\Nutrition::create($data);
//
////    assertSame('French fries', $nutrition->getTranslation('en')->name);
////    assertSame('Chips', $nutrition->getTranslation('en-GB')->name);
//
//    $nutrition = new \App\Nutrition();
//    $nutrition->status = '1';
//    $nutrition->save();
//
//    foreach (config('translatable.locales') as $locale) {
//        $nutrition->translateOrNew($locale)->name = "अमित {$locale}";
//        $nutrition->translateOrNew($locale)->added_by = 1;
//        $nutrition->translateOrNew($locale)->updated_by = 1;
//    }
//    $nutrition->save();
//
//    return 'nutrition created';
//});
//
//Route::get('{locale}', function($locale) {
//    app()->setLocale($locale);
//    $nutrition  = \App\Nutrition::first();
//
//    return $nutrition;
////    return view('nutrition')->with(compact('nutrition'));
//});
//
//Route::group(['middleware' => ['locale']], function() {
//    Route::get('{locale}/langtest', 'Admin\NutritionController@index');
//});
