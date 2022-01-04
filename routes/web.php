<?php

use Illuminate\Support\Facades\Route;
use Spatie\WelcomeNotification\WelcomesNewUsers;
use App\Http\Controllers\Auth\WelcomeController;
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
Route::get('/qualifiers', 'Sync\QualifierController@fetch');
Route::post('/qualifier/store', 'Sync\QualifierController@store');
// Route::get('/schools', 'Sync\SchoolController@fetch');
Route::get('/export', 'HomeController@export');
Route::get('/import', 'HomeController@view');
Route::post('/importExcel', 'HomeController@import')->name('importExcel');

Auth::routes(['register' => false]);

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [WelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [WelcomeController::class, 'savePassword']);
});

Route::prefix('request')->group(function(){

    Route::post('/user/password', 'HomeController@password');
    Route::get('/expenditures', 'HomeController@expenditures');
    Route::get('/expenses', 'HomeController@expenses');
    Route::get('/dropdown/{classification}/{type}/{keyword}', 'DropdownController@index');
    Route::get('/dropdowns/{classification}/{type}', 'DropdownController@lists');
    Route::get('/dropdowncount/{classification}/{type}', 'DropdownController@count');
    Route::post('/dropdown/store', 'DropdownController@store');

    Route::prefix('admin')->group(function(){
        Route::get('/users/{key}/{counts}', 'UserController@lists');
        Route::post('/user/store', 'UserController@store');
        Route::get('/user/logs/{key}/{counts}', 'UserController@myLogs');

        Route::get('/expenses/{keyword}/{count}', 'Lists\ExpenseController@index');
        Route::get('/expenses', 'Lists\ExpenseController@lists');
        Route::post('/expense/store', 'Lists\ExpenseController@store');
    });

    Route::post('/scholar/store', 'iScholarController@store');
    Route::get('/scholars/{status}/{category}/{counts}/{year}/{key}', 'iScholarController@lists');
    Route::get('/scholar/{id}', 'iScholarController@view');

    Route::get('/schools/{counts}/{term}/{grade}/{class}/{key}', 'SchoolController@index');
    // Route::post('/scholar/status', 'ScholarController@status');
    // Route::get('/scholars/{status}/{category}/{counts}/{key}', 'ScholarController@lists');
    // Route::get('/scholar/{id}', 'ScholarController@view');

    // Route::get('/information/{type}/{id}/{count}', 'TracerController@index');
    // Route::post('/history/store', 'TracerController@store');

    // Route::post('/financial/store', 'FinancialController@store');
    // Route::get('/financials/{id}/{counts}', 'FinancialController@index');
    // Route::get('/financial/stipend/{id}', 'FinancialController@stipend');
    // Route::get('/financial/breakdown/{id}', 'FinancialController@breakdown');

    // Route::post('/allotment/store', 'AllotmentController@store');
    // Route::get('/allotments/{key}/{counts}', 'AllotmentController@index');
    // Route::get('/allotment/{id}', 'AllotmentController@view');
    // Route::post('/allotment/list/store', 'AllotmentController@storeList');

    // Route::post('/disbursement/store', 'DisbursementController@store');
    // Route::get('/disbursements/{key}/{counts}', 'DisbursementController@index');

    Route::get('/courses/{key}/{counts}', 'CourseController@index');
    Route::post('/course/store', 'CourseController@store');

    Route::get('/agencies/{key}/{counts}', 'AgencyController@index');
    Route::post('/agency/store', 'AgencyController@store');


    Route::get('/qualifiers/{count}/{category}/{year}/{keyword}', 'QualifierController@index');

});

Route::prefix('lists')->group(function(){
    Route::get('/regions', 'Lists\ListController@regions');
    Route::get('/provinces/{code}', 'Lists\ListController@provinces');
    Route::get('/municipalities/{code}', 'Lists\ListController@municipalities');

    Route::get('/courses/{key}/{count}', 'Lists\ListController@courses');
    Route::get('/agencies/{key}/{count}', 'Lists\ListController@agencies');
    Route::get('/schools/{key}/{count}', 'Lists\ListController@schools');
    
    Route::post('/schools', 'ListController@schools');
    Route::post('/courses', 'ListController@courses');
});

Route::prefix('sync')->group(function(){
    Route::get('/locations', 'Sync\SyncController@locations');
    Route::get('/lists', 'Sync\SyncController@lists');
});

Route::get('/{any?}', 'HomeController@home')->where('any', '[\/\w\.-]*');

// Route::get('/{any?}', function() {
//     return view('home');
// });


