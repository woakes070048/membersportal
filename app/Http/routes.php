<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// ================= User and Admin Access ================= //

// Auth
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Users
Route::get('/', 'UsersController@index');
Route::get('users/{user}/edit', 'UsersController@edit');
Route::put('users/{user}', 'UsersController@update');

// Companies
Route::get('companies/search', 'CompaniesController@getSearchedCompanies');
Route::get('companies/{company}', 'CompaniesController@show');
Route::get('search', 'CompaniesController@searchMembers');
Route::get('companies/{company}/edit', 'CompaniesController@edit');
Route::put('companies/{company}', 'CompaniesController@update');
Route::get('companies/{company}/dashboard', 'CompaniesController@dashboard');
Route::get('companies/{company}/connections', 'CompaniesController@viewConnections');

// Contacts
Route::get('contacts/{contact}/edit', 'ContactsController@edit');
Route::put('contacts/{contact}', 'ContactsController@update');

// Connections
Route::post('connections/{user}', 'ConnectionsController@store');

// Events
Route::resource('events', 'EventsController');

// Leaders
Route::resource('leaders', 'LeadersController');

// RFPs
Route::resource('rfps', 'RFPsController');

// ================= Admin Only ================= //

// Users
Route::get('/admin/users/create', 'UsersController@create');
Route::post('/admin/users/store', 'UsersController@store');
Route::delete('/admin/users/{user}', 'UsersController@destroy');
Route::get('/admin/dashboard', 'UsersController@getAdminDashboard');
Route::get('/admin/users/edit', 'UsersController@editUsers');

// Companies
Route::get('/admin/companies/create', 'CompaniesController@create');
Route::post('/admin/companies/store', 'CompaniesController@store');
Route::get('/admin/companies/{company}/edit', 'CompaniesController@edit');
Route::put('/admin/companies/{company}', 'CompaniesController@update');
Route::delete('/admin/companies/{company}', 'CompaniesController@destroy');

// Contacts
Route::get('/admin/contacts/create', 'ContactsController@create');
Route::post('/admin/contacts/store', 'ContactsController@store');
Route::get('/admin/contacts/{company}/edit', 'ContactsController@edit');
Route::put('/admin/contacts/{company}', 'ContactsController@update');
Route::delete('/admin/contacts/{contact}', 'ContactsController@destroy');

// Events
Route::get('/admin/events/create', 'EventsController@create');
Route::get('/admin/events/{event}/edit', 'EventsController@edit');

// Carousels
Route::get('/admin/carousels/create', 'CarouselsController@create');
Route::get('/admin/carousels/{carousel}/edit', 'CarouselsController@edit');
Route::put('/admin/carousels/{carousel}', 'CarouselsController@update');
Route::delete('/admin/carousels/{carousel}', 'CarouselsController@destroy');
Route::post('/admin/carousels', 'CarouselsController@store');