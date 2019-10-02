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
 
Route::middleware(['firm.valid' ])->group(function () {

    Route::group(['namespace' => 'Web'], function () {
        // Route::group(['namespace' => 'Employee','prefix' => 'employee'], function () { 

        //     Route::get('/verifyemail/{token}', 'AuthController@verify_email');

        //     Route::get('/password/reset/{token}', 'PasswordController@reset');
        //     Route::post('/password/reset', 'PasswordController@post_reset');

        // });

        Route::get('/', 'Firm\DashboardController@index');
        Route::get('/test', 'Firm\DashboardController@index2');
        Route::get('/chat', 'Firm\DashboardController@chat');
        Route::get('/send-location', 'Firm\DashboardController@send_location');
        Route::get('/get-location', 'Firm\DashboardController@get_location');
        Route::group(['namespace' => 'Firm', 'prefix' => 'firm'], function () {

            Route::get('/', 'DashboardController@index');

            Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {

                Route::get('/login', 'AuthController@index');
                Route::post('login', 'AuthController@login')->name('firm.auth.login');
                Route::get('logout', 'AuthController@logout')->name('firm.auth.logout');


                Route::get('forgot-password', 'PasswordController@forgot_password')->name('firm.auth.forgot-password');
                Route::post('forgot-password', 'PasswordController@postforgot_password')->name('firm.auth.forgot-password.post');

                Route::get('/verifyemail/{token}', 'AuthController@verify_email');

                Route::get('/password/reset/{token}', 'PasswordController@reset');
                Route::post('/password/reset', 'PasswordController@post_reset');

            });

            //// Users
            Route::group(['prefix' => 'users'], function () {
                Route::get('/index', 'UsersController@index');
                Route::get('/{id}/profile', 'UsersController@get');
                Route::post('/get-users-data', 'UsersController@getUsers');
                Route::get('/create', 'UsersController@create');
                Route::post('/store', 'UsersController@store');
                Route::get('/{id}/edit', 'UsersController@edit');
                Route::post('/{id}/update', 'UsersController@update');
                Route::get('/delete/{id}', 'UsersController@destroy');
            });

            //// Employees
            Route::group(['prefix' => 'employees'], function () {
                Route::get('/index', 'EmployeesController@index');
                Route::get('/{id}/profile', 'EmployeesController@get');
                Route::post('/get-employees-data', 'EmployeesController@getEmployees');
                Route::get('/create', 'EmployeesController@create');
                Route::post('/store', 'EmployeesController@store');
                Route::get('/{id}/edit', 'EmployeesController@edit');
                Route::post('/{id}/update', 'EmployeesController@update');
                Route::get('/delete/{id}', 'EmployeesController@destroy');
                Route::post('/{id}/check-has-relations', 'EmployeesController@checkRelations');
                Route::get('/vehicles/{id}', 'EmployeesController@vehicles');
                Route::post('/vehicles/{id}', 'EmployeesController@save_vehicles');
                Route::get('/devices/{id}', 'EmployeesController@devices');
                Route::post('/devices/{id}', 'EmployeesController@save_devices');
            });

            //// Clients
            Route::group(['prefix' => 'clients'], function () {
                Route::get('/index', 'ClientsController@index');
                Route::get('/{id}/profile', 'ClientsController@get');
                Route::post('/get-clients-data', 'ClientsController@getClients');
                Route::get('/create', 'ClientsController@create');
                Route::post('/store', 'ClientsController@store');
                Route::get('/{id}/edit', 'ClientsController@edit');
                Route::post('/{id}/update', 'ClientsController@update');
                Route::get('/delete/{id}', 'ClientsController@destroy');
                Route::any('/{id}/check-has-relations', 'ClientsController@checkRelations');
                Route::post('/get-missions-data/{id}', 'ClientsController@getMissions');
            });

            //// Client Reps
            Route::group(['prefix' => 'client/{ClientId}/reps'], function () {
                Route::get('/', 'ClientRepsController@index');
                Route::post('/get-reps-data', 'ClientRepsController@getReps');
                Route::get('/create', 'ClientRepsController@create');
                Route::post('/store', 'ClientRepsController@store');
                Route::get('/{id}/edit', 'ClientRepsController@edit');
                Route::post('/{id}/update', 'ClientRepsController@update');
                Route::get('/{id}/delete', 'ClientRepsController@destroy');
            });

            //// Client Branches
            Route::group(['prefix' => 'client/{ClientId}/branches'], function () {
                Route::get('/', 'ClientBranchesController@index');
                Route::post('/get-branches-data', 'ClientBranchesController@getBranches');
                Route::get('/create', 'ClientBranchesController@create');
                Route::post('/store', 'ClientBranchesController@store');
                Route::get('/{id}/edit', 'ClientBranchesController@edit');
                Route::post('/{id}/update', 'ClientBranchesController@update');
                Route::get('/{id}/delete', 'ClientBranchesController@destroy');
            });

            //// Vehicles
            Route::group(['prefix' => 'vehicles'], function () {
                Route::get('/index', 'VehiclesController@index');
                Route::post('/get-vehicles-data', 'VehiclesController@getVehicles');
                Route::get('/create', 'VehiclesController@create');
                Route::post('/store', 'VehiclesController@store');
                Route::get('/{id}/edit', 'VehiclesController@edit');
                Route::post('/{id}/update', 'VehiclesController@update');
                Route::get('/delete/{id}', 'VehiclesController@destroy');
            });

            //// Devices
            Route::group(['prefix' => 'devices'], function () {
                Route::get('/index', 'DevicesController@index');
                Route::post('/get-devices-data', 'DevicesController@getDevices');
                Route::get('/create', 'DevicesController@create');
                Route::post('/store', 'DevicesController@store');
                Route::get('/{id}/edit', 'DevicesController@edit');
                Route::post('/{id}/update', 'DevicesController@update');
                Route::get('/delete/{id}', 'DevicesController@destroy');
            });

            //// Announcements
            Route::group(['prefix' => 'announcements'], function () {
                Route::get('/index', 'AnnouncementsController@index');
                Route::post('/get-announcements-data', 'AnnouncementsController@getAnnouncements');
                Route::get('/create', 'AnnouncementsController@create');
                Route::post('/store', 'AnnouncementsController@store');
                Route::get('/{id}/edit', 'AnnouncementsController@edit');
                Route::post('/{id}/update', 'AnnouncementsController@update');
                Route::get('/delete/{id}', 'AnnouncementsController@destroy');
            });

            //// Items
            Route::group(['prefix' => 'items'], function () {
                Route::get('/index', 'ItemsController@index');
                Route::post('/get-items-data', 'ItemsController@getItems');
                Route::get('/create', 'ItemsController@create');
                Route::post('/store', 'ItemsController@store');
                Route::get('/{id}/edit', 'ItemsController@edit');
                Route::post('/{id}/update', 'ItemsController@update');
                Route::get('/delete/{id}', 'ItemsController@destroy');
                Route::post('/{id}/check-has-relations', 'ItemsController@checkRelations');
                Route::get('/item-templates/{id}/{ItemId?}', 'ItemsController@templates');
            });

            //// Item Templates
            Route::group(['prefix' => 'item-templates'], function () {
                Route::get('/index', 'ItemTemplatesController@index');
                Route::post('/get-templates-data', 'ItemTemplatesController@getTemplates');
                Route::get('/create', 'ItemTemplatesController@create');
                Route::post('/store', 'ItemTemplatesController@store');
                Route::get('/{id}/edit', 'ItemTemplatesController@edit');
                Route::post('/{id}/update', 'ItemTemplatesController@update');
                Route::get('/delete/{id}', 'ItemTemplatesController@destroy');
                Route::post('/{id}/check-has-relations', 'ItemTemplatesController@checkRelations');
            });

            //// Item Template Custom Fields
            Route::group(['prefix' => 'item-template/{TemplateId}/custom-fields'], function () {
                Route::get('/', 'ItemTemplateCustomFieldsController@index');
                Route::post('/get-fields-data', 'ItemTemplateCustomFieldsController@getFields');
                Route::get('/create', 'ItemTemplateCustomFieldsController@create');
                Route::post('/store', 'ItemTemplateCustomFieldsController@store');
                Route::get('/{id}/edit', 'ItemTemplateCustomFieldsController@edit');
                Route::post('/{id}/update', 'ItemTemplateCustomFieldsController@update');
                Route::get('/{id}/delete', 'ItemTemplateCustomFieldsController@destroy');
            });

            //// Missions
            Route::group(['prefix' => 'missions'], function () {
                Route::get('/index', 'MissionsController@index');
                Route::get('/{id}/details', 'MissionsController@get');
                Route::get('/{id}/occurance', 'MissionsController@getMissionOccurance');
                Route::post('/get-missions-data', 'MissionsController@getMissions');
                Route::get('/pop-up/{id}', 'MissionsController@getMissionPopup');
                Route::get('/create', 'MissionsController@create');
                Route::post('/store', 'MissionsController@store');
                Route::get('/{id}/edit', 'MissionsController@edit');
                Route::post('/{id}/update', 'MissionsController@update');
                Route::get('/delete/{id}', 'MissionsController@destroy');
                Route::post('/{id}/check-has-relations', 'MissionsController@checkRelations');
                Route::get('/client-branches/{id}/{mission_id?}', 'MissionsController@branches');
                Route::get('/vehicles/{id}', 'MissionsController@vehicles');
                Route::post('/vehicles/{id}', 'MissionsController@save_vehicles');
                Route::get('/devices/{id}', 'MissionsController@devices');
                Route::post('/devices/{id}', 'MissionsController@save_devices');
                Route::post('/attachments', 'MissionsController@addAttachments');
                Route::post('/{id}/attachments/get-attachments-data', 'MissionsController@getAttachments');
                Route::get('/{id}/attachments/{AttachmentId}/delete', 'MissionsController@deleteAttachments');
                Route::get('/{id}/status', 'MissionsController@statusInfo');
                Route::get('/{id}/occurrences', 'MissionsController@occurrencesInfo');
            });

            //// Mission Tasks
            Route::group(['prefix' => 'mission/{MissionId}/tasks'], function () {
                Route::get('/', 'MissionTasksController@index');
                Route::post('/get-tasks-data', 'MissionTasksController@getTasks');
                Route::get('/create', 'MissionTasksController@create');
                Route::post('/store', 'MissionTasksController@store');
                Route::get('/{TaskId}/edit', 'MissionTasksController@edit');
                Route::post('/{TaskId}/update', 'MissionTasksController@update');
                Route::get('/{TaskId}/delete', 'MissionTasksController@destroy');
                Route::post('/attachments', 'MissionTasksController@addAttachments');
                Route::post('/{TaskId}/attachments/get-attachments-data', 'MissionTasksController@getAttachments');
                Route::get('/{TaskId}/attachments/{AttachmentId}/delete', 'MissionTasksController@deleteAttachments');
            });

            ////// === Configurations
            //// Mission Priorities
            Route::group(['prefix' => 'mission-priorities'], function () {
                Route::get('/index', 'MissionPrioritiesController@index');
                Route::post('/get-priorities-data', 'MissionPrioritiesController@getPriorities');
                Route::get('/create', 'MissionPrioritiesController@create');
                Route::post('/store', 'MissionPrioritiesController@store');
                Route::get('/{id}/edit', 'MissionPrioritiesController@edit');
                Route::post('/{id}/update', 'MissionPrioritiesController@update');
                Route::get('/delete/{id}', 'MissionPrioritiesController@destroy');
            });

            //// Mission Status
            Route::group(['prefix' => 'mission-status'], function () {
                Route::get('/index', 'MissionStatusController@index');
                Route::post('/get-status-data', 'MissionStatusController@getStatus');
                Route::get('/create', 'MissionStatusController@create');
                Route::post('/store', 'MissionStatusController@store');
                Route::get('/{id}/edit', 'MissionStatusController@edit');
                Route::post('/{id}/update', 'MissionStatusController@update');
                Route::get('/delete/{id}', 'MissionStatusController@destroy');
            });

            //// Mission recurring exceptions
            Route::group(['prefix' => 'mission-recurring-exceptions'], function () {
                Route::get('/index/{MissionId?}', 'MissionRecurringExceptionsController@index');
                Route::post('/get-exceptions-data/{MissionId?}', 'MissionRecurringExceptionsController@getExceptions');
                Route::get('/create/{MissionId?}', 'MissionRecurringExceptionsController@create');
                Route::post('/store', 'MissionRecurringExceptionsController@store');
                Route::get('/{id}/edit/{MissionId?}', 'MissionRecurringExceptionsController@edit');
                Route::post('/{id}/update', 'MissionRecurringExceptionsController@update');
                Route::get('/delete/{id}', 'MissionRecurringExceptionsController@destroy');
            });

            //// Mission Task Types
            Route::group(['prefix' => 'mission-task-types'], function () {
                Route::get('/index', 'MissionTaskTypesController@index');
                Route::post('/get-types-data', 'MissionTaskTypesController@getTypes');
                Route::get('/create', 'MissionTaskTypesController@create');
                Route::post('/store', 'MissionTaskTypesController@store');
                Route::get('/{id}/edit', 'MissionTaskTypesController@edit');
                Route::post('/{id}/update', 'MissionTaskTypesController@update');
                Route::get('/delete/{id}', 'MissionTaskTypesController@destroy');
            });

            //// Tutorials
            Route::group(['prefix' => 'tutorials'], function () {
                Route::get('/index', 'TutorialsController@index');
                Route::post('/get-tutorials-data', 'TutorialsController@getTutorials');
                Route::get('/create', 'TutorialsController@create');
                Route::post('/store', 'TutorialsController@store');
                Route::get('/{id}/edit', 'TutorialsController@edit');
                Route::post('/{id}/update', 'TutorialsController@update');
                Route::get('/delete/{id}', 'TutorialsController@destroy');
            });

            Route::resource('settings', 'SettingsController');

            //// Chats
            Route::group(['prefix' => 'chats'], function () {
                Route::get('/index', 'ChatsController@index');

            });

        });

        Route::group(['namespace' => 'Employee', 'prefix' => 'employee'], function () {

            Route::get('/', 'DashboardController@index');

            Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {

                Route::get('/login', 'AuthController@index');
                Route::post('login', 'AuthController@login')->name('employee.auth.login');
                Route::get('logout', 'AuthController@logout')->name('employee.auth.logout');


                Route::get('forgot-password', 'PasswordController@forgot_password')->name('employee.auth.forgot-password');
                Route::post('forgot-password', 'PasswordController@postforgot_password')->name('employee.auth.forgot-password.post');

                Route::get('/verifyemail/{token}', 'AuthController@verify_email');

                Route::get('/password/reset/{token}', 'PasswordController@reset');
                Route::post('/password/reset', 'PasswordController@post_reset');

            });
        });

    });
});