<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        //// Common
        // Country
        $this->app->bind(
            'App\Repositories\Country\CountryRepositoryInterface',
            'App\Repositories\Country\CountryRepository'
        );
        // State
        $this->app->bind(
            'App\Repositories\State\StateRepositoryInterface',
            'App\Repositories\State\StateRepository'
        );
        // City
        $this->app->bind(
            'App\Repositories\City\CityRepositoryInterface',
            'App\Repositories\City\CityRepository'
        );
        // Chats
        $this->app->bind(
            'App\Repositories\Chats\ChatsRepositoryInterface',
            'App\Repositories\Chats\ChatsRepository'
        );

        // Admins
        $this->app->bind(
            'App\Repositories\Admins\AdminsRepositoryInterface',
            'App\Repositories\Admins\AdminsRepository'
        );

        // Settings
        $this->app->bind(
            'App\Repositories\Settings\SettingsRepositoryInterface',
            'App\Repositories\Settings\SettingsRepository'
        );

        // Tutorials
        $this->app->bind(
            'App\Repositories\Tutorials\TutorialsRepositoryInterface',
            'App\Repositories\Tutorials\TutorialsRepository'
        );

        // Plans
        $this->app->bind(
            'App\Repositories\Plans\PlansRepositoryInterface',
            'App\Repositories\Plans\PlansRepository'
        );

        // Firms
        $this->app->bind(
            'App\Repositories\Firms\FirmsRepositoryInterface',
            'App\Repositories\Firms\FirmsRepository'
        );

        // Users
        $this->app->bind(
            'App\Repositories\Users\UsersRepositoryInterface',
            'App\Repositories\Users\UsersRepository'
        );

        // Employees
        $this->app->bind(
            'App\Repositories\Employees\EmployeesRepositoryInterface',
            'App\Repositories\Employees\EmployeesRepository'
        );

        // Employee Devices
        $this->app->bind(
            'App\Repositories\EmployeeDevices\EmployeeDevicesRepositoryInterface',
            'App\Repositories\EmployeeDevices\EmployeeDevicesRepository'
        );

        // Industries
        $this->app->bind(
            'App\Repositories\Industries\IndustriesRepositoryInterface',
            'App\Repositories\Industries\IndustriesRepository'
        );

        // Items
        $this->app->bind(
            'App\Repositories\Items\ItemsRepositoryInterface',
            'App\Repositories\Items\ItemsRepository'
        );

        // Item Templates
        $this->app->bind(
            'App\Repositories\ItemTemplates\ItemTemplatesRepositoryInterface',
            'App\Repositories\ItemTemplates\ItemTemplatesRepository'
        );

        // Item Template Custom Fields
        $this->app->bind(
            'App\Repositories\ItemTemplateCustomFields\ItemTemplateCustomFieldsRepositoryInterface',
            'App\Repositories\ItemTemplateCustomFields\ItemTemplateCustomFieldsRepository'
        );

        // Missions
        $this->app->bind(
            'App\Repositories\Missions\MissionsRepositoryInterface',
            'App\Repositories\Missions\MissionsRepository'
        );

        // Mission Tasks
        $this->app->bind(
            'App\Repositories\MissionTasks\MissionTasksRepositoryInterface',
            'App\Repositories\MissionTasks\MissionTasksRepository'
        );

        // Mission Task Types
        $this->app->bind(
            'App\Repositories\MissionTaskTypes\MissionTaskTypesRepositoryInterface',
            'App\Repositories\MissionTaskTypes\MissionTaskTypesRepository'
        );

        // Mission Priorities
        $this->app->bind(
            'App\Repositories\MissionPriorities\MissionPrioritiesRepositoryInterface',
            'App\Repositories\MissionPriorities\MissionPrioritiesRepository'
        );

        // Mission Status
        $this->app->bind(
            'App\Repositories\MissionStatus\MissionStatusRepositoryInterface',
            'App\Repositories\MissionStatus\MissionStatusRepository'
        );

        // Mission Occurrences
        $this->app->bind(
            'App\Repositories\MissionOccurrences\MissionOccurrencesRepositoryInterface',
            'App\Repositories\MissionOccurrences\MissionOccurrencesRepository'
        );
         // Mission Occurrence task
         $this->app->bind(
            'App\Repositories\MissionOccurrenceTasks\MissionOccurrenceTaskRepositoryInterface',
            'App\Repositories\MissionOccurrenceTasks\MissionOccurrenceTaskRepository'
        );
         // Mission Occurrence rep
         $this->app->bind(
            'App\Repositories\MissionOccurrenceReps\MissionOccurrenceRepRepositoryInterface',
            'App\Repositories\MissionOccurrenceReps\MissionOccurrenceRepRepository'
        );

        // Mission Recurring Exceptions
        $this->app->bind(
            'App\Repositories\MissionRecurringExceptions\MissionRecurringExceptionsRepositoryInterface',
            'App\Repositories\MissionRecurringExceptions\MissionRecurringExceptionsRepository'
        );

        // Mission Assets
        $this->app->bind(
            'App\Repositories\MissionAssets\MissionAssetsRepositoryInterface',
            'App\Repositories\MissionAssets\MissionAssetsRepository'
        );

        // Mission Task Attachments
        $this->app->bind(
            'App\Repositories\MissionTaskAttachments\MissionTaskAttachmentsRepositoryInterface',
            'App\Repositories\MissionTaskAttachments\MissionTaskAttachmentsRepository'
        );


          // Incident Missions
          $this->app->bind(
            'App\Repositories\IncidentMissions\IncidentMissionsRepositoryInterface',
            'App\Repositories\IncidentMissions\IncidentMissionsRepository'
        );

        // Incident Mission Tasks
        $this->app->bind(
            'App\Repositories\IncidentMissionTasks\IncidentMissionTasksRepositoryInterface',
            'App\Repositories\IncidentMissionTasks\IncidentMissionTasksRepository'
        );
        // Clients
        $this->app->bind(
            'App\Repositories\Clients\ClientsRepositoryInterface',
            'App\Repositories\Clients\ClientsRepository'
        );

        // Client Branches
        $this->app->bind(
            'App\Repositories\ClientBranches\ClientBranchesRepositoryInterface',
            'App\Repositories\ClientBranches\ClientBranchesRepository'
        );

        // Client Reps
        $this->app->bind(
            'App\Repositories\ClientReps\ClientRepsRepositoryInterface',
            'App\Repositories\ClientReps\ClientRepsRepository'
        );

        // Vehicles
        $this->app->bind(
            'App\Repositories\Vehicles\VehiclesRepositoryInterface',
            'App\Repositories\Vehicles\VehiclesRepository'
        );

         // Devices
         $this->app->bind(
            'App\Repositories\Devices\DevicesRepositoryInterface',
            'App\Repositories\Devices\DevicesRepository'
        );

        // Announcements
        $this->app->bind(
            'App\Repositories\Announcements\AnnouncementsRepositoryInterface',
            'App\Repositories\Announcements\AnnouncementsRepository'
        );
    }
}