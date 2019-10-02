<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
Route::middleware(['firm.valid' ])->group(function () {


    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    Route::group(['namespace' => 'Api\v1\Common', 'prefix' => 'common'], function () {

        Route::group(['prefix' => 'country'], function () {
            Route::post('/list', 'ApiCountryController@list');
        });
        Route::group(['prefix' => 'state'], function () {
            Route::post('/list', 'ApiCountryController@state_list');
        });
        Route::group(['prefix' => 'city'], function () {
            Route::post('/list', 'ApiCountryController@city_list');
        });

        Route::post('/log', 'ApiCommonController@log');

        Route::group(['prefix' => 'mission'], function () {
            Route::post('/status/list', 'ApiMissionController@mission_status_list');
            Route::post('/priority/list', 'ApiTaskController@mission_priority_list');
        });
        Route::group(['prefix' => 'task'], function () {
            Route::post('/type/list', 'ApiTaskController@task_type_list');
        });
    });



    Route::group(['namespace' => 'Api\v1\Employee', 'prefix' => 'employee'], function () {
        Route::group(['namespace' => 'Common', 'prefix' => 'common'], function () {

            Route::group(['prefix' => 'country'], function () {
                Route::post('/list', 'ApiCountryController@list');
            });
            Route::group(['prefix' => 'state'], function () {
                Route::post('/list', 'ApiCountryController@state_list');
            });
            Route::group(['prefix' => 'city'], function () {
                Route::post('/nearest', 'ApiCountryController@nearest_city_list');
            });

            Route::group(['prefix' => 'version'], function () {
                Route::post('/check', 'ApiCommonController@mobileVersioncheck');
            });
            Route::group(['prefix' => 'tutorial'], function () {
                Route::post('/list', 'ApiCommonController@tutorial_list');
            });
            Route::post('/log', 'ApiCommonController@log');



        });


        Route::group(['prefix' => 'auth'], function () {
            //Route::post('/signup', 'ApiAuthController@signup'); 
            Route::post('/login', 'ApiAuthController@login');
            //Route::post('/logout', 'ApiAuthController@logout'); 
            Route::post('/forgot_password', 'ApiAuthController@forgotPassword');
            Route::post('/resend_email_verification', 'ApiAuthController@resendEmailVerification');
            Route::post('/signup_facebook', 'ApiAuthController@signupWithFacebook');
            Route::post('/device/set', 'ApiAuthController@setDevice');
        });

        //// Employees
        Route::post('/profile', 'ApiEmployeesController@getInfo');
        Route::post('/profile/update', 'ApiEmployeesController@updateInfo');
        Route::post('/profile/update-status', 'ApiEmployeesController@updateStatus');
        Route::post('/profile/update-location', 'ApiEmployeesController@updateLocation');
        Route::post('/profile/get-location', 'ApiEmployeesController@getLocation');

        //// Clients
        Route::group(['prefix' => 'clients'], function () {
            // Get client
            Route::post('/get', 'ApiClientsController@get');
            // Create client
            Route::post('/create', 'ApiClientsController@create');
            // List clients
            Route::post('/list', 'ApiClientsController@list');
            // Update client
            Route::post('/update', 'ApiClientsController@update');
        });

        //// Client Branches
        Route::group(['prefix' => 'client-branches'], function () {
            // Get Client Branch
            Route::post('/get', 'ApiClientBranchesController@get');
            // List Client Branches
            Route::post('/list', 'ApiClientBranchesController@list');
        });

        //// Client Reps
        Route::group(['prefix' => 'client-reps'], function () {
            // Get Client Rep
            Route::post('/get', 'ApiClientRepsController@get');
            // List Client Reps
            Route::post('/list', 'ApiClientRepsController@list');

        });


        //// Items
        Route::group(['prefix' => 'items'], function () {
            // Get item
            Route::post('/get', 'ApiItemsController@get');
            // List all items per firmId
            Route::post('/list', 'ApiItemsController@list');
            // Create item
            Route::post('/create', 'ApiItemsController@create');
            // Update item
            Route::post('/update', 'ApiItemsController@update');
            // Delete item
            Route::post('/delete', 'ApiItemsController@delete');
        });

        //// Missions
        Route::group(['prefix' => 'missions'], function () {
            // Get mission
            Route::post('/get', 'ApiMissionsController@get');

            Route::post('/list', 'ApiMissionsController@list');
            // Today missions
            Route::post('/list-today', 'ApiMissionsController@list_today');

            // Set Active
            Route::post('/set-active', 'ApiMissionsController@setActive');
            // Set done
            Route::post('/set-done', 'ApiMissionsController@setDone');
            // Set Active
            Route::post('/set-rearrange', 'ApiMissionsController@setRearrange');
        });

        //// Mission Tasks
        Route::group(['prefix' => 'mission-tasks'], function () {
            // Get mission task
            Route::post('/get', 'ApiMissionTasksController@get');
            // Create mission task
            //Route::post('/create', 'ApiMissionTasksController@create');
            // List mission tasks
            Route::post('/list', 'ApiMissionTasksController@list');
            // Update mission task
            //Route::post('/update', 'ApiMissionTasksController@update');
            // Delete mission task
            Route::post('/delete', 'ApiMissionTasksController@delete');
        });

        //// Chat
        Route::group(['prefix' => 'chat'], function () {
            // List clients
            Route::post('/clients', 'ApiChatController@client_list');
        });


        //// Admins
        Route::group(['prefix' => 'admins'], function () {
            // Get Admin
            Route::post('/get', 'ApiAdminsController@get');
            // List Admins
            Route::post('/list', 'ApiAdminsController@list');
            // Create Admin
            Route::post('/create', 'ApiAdminsController@create');
            // Update Admin
            Route::post('/update', 'ApiAdminsController@update');
            // Delete Admin
            Route::post('/delete', 'ApiAdminsController@delete');
        });

        //// Settings
        Route::group(['prefix' => 'settings'], function () {
            // Get Setting
            Route::post('/get', 'ApiSettingsController@get');
            // List Settings
            Route::post('/list', 'ApiSettingsController@list');
            // Create Setting
            Route::post('/create', 'ApiSettingsController@create');
            // Update Setting
            Route::post('/update', 'ApiSettingsController@update');
            // Delete Setting
            Route::post('/delete', 'ApiSettingsController@delete');
        });

        //// Plans
        Route::group(['prefix' => 'plans'], function () {
            // Get plan
            Route::post('/get', 'ApiPlansController@get');
            // List plans
            Route::post('/list', 'ApiPlansController@list');
            // Create plan
            Route::post('/create', 'ApiPlansController@create');
            // Update plan
            Route::post('/update', 'ApiPlansController@update');
            // Delete plan
            Route::post('/delete', 'ApiPlansController@delete');
        });

        //// Firms
        Route::group(['prefix' => 'firms'], function () {
            // Get firm
            Route::post('/get', 'ApiFirmsController@get');
            // List firms
            Route::post('/list', 'ApiFirmsController@list');
            // Create firm
            Route::post('/create', 'ApiFirmsController@create');
            // Update firm
            Route::post('/update', 'ApiFirmsController@update');
            // Delete firm
            Route::post('/delete', 'ApiFirmsController@delete');
        });

        //// Employees
        Route::group(['prefix' => 'employees'], function () {
            // Get employee
            Route::post('/get', 'ApiEmployeesController@get');
            // List employees
            Route::post('/list', 'ApiEmployeesController@list');
            // Create employee
            Route::post('/create', 'ApiEmployeesController@create');
            // Update employee
            Route::post('/update', 'ApiEmployeesController@update');
            // Delete employee
            Route::post('/delete', 'ApiEmployeesController@delete');
            // Verify employee email
            Route::post('/verify-email', 'ApiEmployeesController@verify_email');
            // Verify employee phone
            Route::post('/verify-phone', 'ApiEmployeesController@verify_phone');
            // Update current_location
            Route::post('/', 'ApiEmployeesController@verify_phone');
        });

        //// Employee Devices
        Route::group(['prefix' => 'employee-devices'], function () {
            // Get employee Device
            Route::post('/get', 'ApiEmployeeDevicesController@get');
            // List employee Devices
            Route::post('/list', 'ApiEmployeeDevicesController@list');
            // Create employee Device
            Route::post('/create', 'ApiEmployeeDevicesController@create');
            // Update employee Device
            Route::post('/update', 'ApiEmployeeDevicesController@update');
            // Delete employee Device
            Route::post('/delete', 'ApiEmployeeDevicesController@delete');
        });

        //// Industries
        Route::group(['prefix' => 'industries'], function () {
            // Get industry
            Route::post('/get', 'ApiIndustriesController@get');
            // List industries
            Route::post('/list', 'ApiIndustriesController@list');
            // Create industry
            Route::post('/create', 'ApiIndustriesController@create');
            // Update industry
            Route::post('/update', 'ApiIndustriesController@update');
            // Delete industry
            Route::post('/delete', 'ApiIndustriesController@delete');
        });

        //// Items
        Route::group(['prefix' => 'items'], function () {
            // Get item
            Route::post('/get', 'ApiItemsController@get');
            // List all items per firmId
            Route::post('/list', 'ApiItemsController@list');
            // Create item
            Route::post('/create', 'ApiItemsController@create');
            // Update item
            Route::post('/update', 'ApiItemsController@update');
            // Delete item
            Route::post('/delete', 'ApiItemsController@delete');
        });

        //// Item Custom Fields
        Route::group(['prefix' => 'item-custom-fields'], function () {
            // Get item custom field
            Route::post('/get', 'ApiItemCustomFieldsController@get');
            // List all item custom field per ItemId
            Route::post('/list', 'ApiItemCustomFieldsController@list');
            // Create item custom field
            Route::post('/create', 'ApiItemCustomFieldsController@create');
            // Update item custom field
            Route::post('/update', 'ApiItemCustomFieldsController@update');
            // Delete item custom field
            Route::post('/delete', 'ApiItemCustomFieldsController@delete');
        });

        //// Missions
        Route::group(['prefix' => 'missions'], function () {
            // Get mission
            Route::post('/get', 'ApiMissionsController@get');
            // List missions
            Route::post('/list', 'ApiMissionsController@list');
            // Create mission
            Route::post('/create', 'ApiMissionsController@create');
            // Update mission
            Route::post('/update', 'ApiMissionsController@update');
            // Delete mission
            Route::post('/delete', 'ApiMissionsController@delete');
        });

        //// Mission Tasks
        Route::group(['prefix' => 'mission-tasks'], function () {
            // Get mission task
            Route::post('/get', 'ApiMissionTasksController@get');
            // Create mission task
            Route::post('/create', 'ApiMissionTasksController@create');
            // List mission tasks
            Route::post('/list', 'ApiMissionTasksController@list');
            // Update mission task
            Route::post('/update', 'ApiMissionTasksController@update');
            // Delete mission task
            Route::post('/delete', 'ApiMissionTasksController@delete');
        });

        //// Mission Task Types
        Route::group(['prefix' => 'mission-task-types'], function () {
            // Get mission task type
            Route::post('/get', 'ApiMissionTaskTypesController@get');
            // Create mission task type
            Route::post('/create', 'ApiMissionTaskTypesController@create');
            // List mission task types
            Route::post('/list', 'ApiMissionTaskTypesController@list');
            // Update mission task type
            Route::post('/update', 'ApiMissionTaskTypesController@update');
            // Delete mission task type
            Route::post('/delete', 'ApiMissionTaskTypesController@delete');
        });

        //// Mission Priorities
        Route::group(['prefix' => 'mission-priorities'], function () {
            // Get mission priority
            Route::post('/get', 'ApiMissionPrioritiesController@get');
            // List mission priorities
            Route::post('/list', 'ApiMissionPrioritiesController@list');
            // Create mission priority
            Route::post('/create', 'ApiMissionPrioritiesController@create');
            // Update mission priority
            Route::post('/update', 'ApiMissionPrioritiesController@update');
            // Delete mission priority
            Route::post('/delete', 'ApiMissionPrioritiesController@delete');
        });

        //// Mission Status
        Route::group(['prefix' => 'mission-status'], function () {
            // Get mission status
            Route::post('/get', 'ApiMissionStatusController@get');
            // Create mission status
            Route::post('/create', 'ApiMissionStatusController@create');
            // List mission status
            Route::post('/list', 'ApiMissionStatusController@list');
            // Update mission status
            Route::post('/update', 'ApiMissionStatusController@update');
            // Delete mission status
            Route::post('/delete', 'ApiMissionStatusController@delete');
        });

        //// Mission Occurrences
        Route::group(['prefix' => 'mission-occurrences'], function () {
            // Get mission occurrence
            Route::post('/get', 'ApiMissionOccurrencesController@get');
            // Create mission occurrence
            Route::post('/create', 'ApiMissionOccurrencesController@create');
            // List mission occurrences
            Route::post('/list', 'ApiMissionOccurrencesController@list');
            // Update mission occurrence
            Route::post('/update', 'ApiMissionOccurrencesController@update');
            // Delete mission occurrence
            Route::post('/delete', 'ApiMissionOccurrencesController@delete');
        });

        //// Mission Recurring Exceptions
        Route::group(['prefix' => 'mission-recurring-exceptions'], function () {
            // Get mission recurring exception
            Route::post('/get', 'ApiMissionRecurringExceptionsController@get');
            // Create mission recurring exception
            Route::post('/create', 'ApiMissionRecurringExceptionsController@create');
            // List mission recurring exceptions
            Route::post('/list', 'ApiMissionRecurringExceptionsController@list');
            // Update mission recurring exception
            Route::post('/update', 'ApiMissionRecurringExceptionsController@update');
            // Delete mission recurring exception
            Route::post('/delete', 'ApiMissionRecurringExceptionsController@delete');
        });

        //// Mission Assets
        Route::group(['prefix' => 'mission-assets'], function () {
            // Get mission assets
            Route::post('/get', 'ApiMissionAssetsController@get');
            // Create mission asset
            Route::post('/create', 'ApiMissionAssetsController@create');
            // List mission assets
            Route::post('/list', 'ApiMissionAssetsController@list');
            // Update mission asset
            Route::post('/update', 'ApiMissionAssetsController@update');
            // Delete mission asset
            Route::post('/delete', 'ApiMissionAssetsController@delete');
        });

        //// Mission Task Attachments
        Route::group(['prefix' => 'mission-task-attachments'], function () {
            // Get mission task attachment
            Route::post('/get', 'ApiMissionTaskAttachmentsController@get');
            // Create mission task attachment
            Route::post('/create', 'ApiMissionTaskAttachmentsController@create');
            // List mission task attachments
            Route::post('/list', 'ApiMissionTaskAttachmentsController@list');
            // Update mission task attachment
            Route::post('/update', 'ApiMissionTaskAttachmentsController@update');
            // Delete mission task attachment
            Route::post('/delete', 'ApiMissionTaskAttachmentsController@delete');
        });


        //// Vehicles
        Route::group(['prefix' => 'vehicles'], function () {
            // Get Vehicle
            Route::post('/get', 'ApiVehiclesController@get');
            // List Vehicles
            Route::post('/list', 'ApiVehiclesController@list');
            // Create Vehicle
            Route::post('/create', 'ApiVehiclesController@create');
            // Update Vehicle
            Route::post('/update', 'ApiVehiclesController@update');
            // Delete Vehicle
            Route::post('/delete', 'ApiVehiclesController@delete');
        });


        //// Chats
        Route::group(['prefix' => 'chat'], function () {
            Route::post('/store-message', 'ApiChatsController@storeMessage');
            Route::post('/get-messages', 'ApiChatsController@getMessages');
        });
    });

});