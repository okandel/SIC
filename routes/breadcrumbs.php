<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', url('/firm'));
});

//***************************************************************
// Home > Users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', url('/firm/users/index'));
});

// Home > Users > Create
Breadcrumbs::for('users-create', function ($trail) {
    $trail->parent('users');
    $trail->push('Create', url('/firm/users/create'));
});

// Home > Users > Edit
Breadcrumbs::for('users-edit', function ($trail) {
    $trail->parent('users');
    $trail->push('Edit', url('/firm/users/edit'));
});

// Home > Users > Profile
Breadcrumbs::for('users-profile', function ($trail) {
    $trail->parent('users');
    $trail->push('Profile', url('/firm/users/profile'));
});

//***************************************************************
// Home > Employees
Breadcrumbs::for('employees', function ($trail) {
    $trail->parent('home');
    $trail->push('Employees', url('/firm/employees/index'));
});

// Home > Employees > Create
Breadcrumbs::for('employees-create', function ($trail) {
    $trail->parent('employees');
    $trail->push('Create', url('/firm/employees/create'));
});

// Home > Employees > Edit
Breadcrumbs::for('employees-edit', function ($trail) {
    $trail->parent('employees');
    $trail->push('Edit', url('/firm/employees/edit'));
});

// Home > Employees > Profile
Breadcrumbs::for('employees-profile', function ($trail) {
    $trail->parent('employees');
    $trail->push('Profile', url('/firm/employees/profile'));
});

//***************************************************************
// Home > Clients
Breadcrumbs::for('clients', function ($trail) {
    $trail->parent('home');
    $trail->push('Clients', url('/firm/clients/index'));
});

// Home > Clients > Create
Breadcrumbs::for('clients-create', function ($trail) {
    $trail->parent('clients');
    $trail->push('Create', url('/firm/clients/create'));
});

// Home > Clients > Edit
Breadcrumbs::for('clients-edit', function ($trail) {
    $trail->parent('clients');
    $trail->push('Edit', url('/firm/clients/edit'));
});

// Home > Clients > Profile
Breadcrumbs::for('clients-profile', function ($trail) {
    $trail->parent('clients');
    $trail->push('Profile', url('/firm/clients/profile'));
});

//// Client Reps
// Home > Client > Reps
Breadcrumbs::for('client-reps', function ($trail, $client) {
    $trail->parent('clients');
    $trail->push($client->contact_person.' - Reps', url('/firm/client/'.$client->id.'/reps'));
});

// Home > Client > Reps > Create
Breadcrumbs::for('client-reps-create', function ($trail, $client) {
    $trail->parent('client-reps', $client);
    $trail->push('Create Rep', url('/firm/client/'.$client->id.'/reps/create'));
});

// Home > Client > Reps > Edit
Breadcrumbs::for('client-reps-edit', function ($trail, $client, $rep) {
    $trail->parent('client-reps', $client);
    $trail->push('Edit Rep', url('/firm/client/'.$client->id.'/reps/'.$rep->id));
});

//// Client Branches
// Home > Client > Branches
Breadcrumbs::for('client-branches', function ($trail, $client) {
    $trail->parent('clients');
    $trail->push($client->contact_person.' - Branches', url('/firm/client/'.$client->id.'/branches'));
});

// Home > Client > Branches > Create
Breadcrumbs::for('client-branches-create', function ($trail, $client) {
    $trail->parent('client-branches', $client);
    $trail->push('Create Branch', url('/firm/client/'.$client->id.'/branches/create'));
});

// Home > Client > Branches > Edit
Breadcrumbs::for('client-branches-edit', function ($trail, $client, $branch) {
    $trail->parent('client-branches', $client);
    $trail->push('Edit Branch', url('/firm/client/'.$client->id.'/branches/'.$branch->id));
});

//***************************************************************
// Home > Missions
Breadcrumbs::for('missions', function ($trail) {
    $trail->parent('home');
    $trail->push('Missions', url('/firm/missions/index'));
});

// Home > Missions > Create
Breadcrumbs::for('missions-create', function ($trail) {
    $trail->parent('missions');
    $trail->push('Create', url('/firm/missions/create'));
});

// Home > Missions > Edit
Breadcrumbs::for('missions-edit', function ($trail) {
    $trail->parent('missions');
    $trail->push('Edit', url('/firm/missions/edit'));
});

// Home > Missions > Details
Breadcrumbs::for('missions-details', function ($trail) {
    $trail->parent('missions');
    $trail->push('Details', url('/firm/missions/details'));
});

// Home > Mission Status
Breadcrumbs::for('missions-status', function ($trail, $mission) {
    $trail->parent('missions');
    $trail->push($mission->title.' Status', url('/firm/missions/'.$mission->id.'/status'));
});

// Home > Mission Occurrences
Breadcrumbs::for('missions-occurrences', function ($trail, $mission) {
    $trail->parent('missions');
    $trail->push($mission->title.' Occurrences', url('/firm/missions/'.$mission->id.'/occurrences'));
});

//// Mission Tasks
// Home > Mission > Tasks
Breadcrumbs::for('mission-tasks', function ($trail, $mission) {
    $trail->parent('missions');
    $trail->push($mission->title.' - Tasks', url('/firm/mission/'.$mission->id.'/tasks'));
});

// Home > Mission > Tasks > Create
Breadcrumbs::for('mission-tasks-create', function ($trail, $mission) {
    $trail->parent('mission-tasks', $mission);
    $trail->push('Create Task', url('/firm/mission/'.$mission->id.'/tasks/create'));
});

// Home > Mission > Tasks > Edit
Breadcrumbs::for('mission-tasks-edit', function ($trail, $mission, $task) {
    $trail->parent('mission-tasks', $mission);
    $trail->push('Edit Task', url('/firm/mission/'.$mission->id.'/tasks/'.$task->id));
});

//***************************************************************
// Home > Items
Breadcrumbs::for('items', function ($trail) {
    $trail->parent('home');
    $trail->push('Items', url('/firm/items/index'));
});

// Home > Items > Create
Breadcrumbs::for('items-create', function ($trail) {
    $trail->parent('items');
    $trail->push('Create', url('/firm/items/create'));
});

// Home > Items > Edit
Breadcrumbs::for('items-edit', function ($trail) {
    $trail->parent('items');
    $trail->push('Edit', url('/firm/items/edit'));
});

//***************************************************************
// Home > Vehicles
Breadcrumbs::for('vehicles', function ($trail) {
    $trail->parent('home');
    $trail->push('Vehicles', url('/firm/vehicles/index'));
});

// Home > Vehicles > Create
Breadcrumbs::for('vehicles-create', function ($trail) {
    $trail->parent('vehicles');
    $trail->push('Create', url('/firm/vehicles/create'));
});

// Home > Vehicles > Edit
Breadcrumbs::for('vehicles-edit', function ($trail) {
    $trail->parent('vehicles');
    $trail->push('Edit', url('/firm/vehicles/edit'));
});

//***************************************************************
// Home > Devices
Breadcrumbs::for('devices', function ($trail) {
    $trail->parent('home');
    $trail->push('Devices', url('/firm/devices/index'));
});

// Home > Devices > Create
Breadcrumbs::for('devices-create', function ($trail) {
    $trail->parent('devices');
    $trail->push('Create', url('/firm/devices/create'));
});

// Home > Devices > Edit
Breadcrumbs::for('devices-edit', function ($trail) {
    $trail->parent('devices');
    $trail->push('Edit', url('/firm/devices/edit'));
});

///////////////////
//Configuration
///////////////////

//***************************************************************
// Home > Mission Priorities
Breadcrumbs::for('mission-priorities', function ($trail) {
    $trail->parent('home');
    $trail->push('Mission Priorities', url('/firm/mission-priorities/index'));
});

// Home > Mission Priorities > Create
Breadcrumbs::for('mission-priorities-create', function ($trail) {
    $trail->parent('mission-priorities');
    $trail->push('Create', url('/firm/mission-priorities/create'));
});

// Home > Mission Priorities > Edit
Breadcrumbs::for('mission-priorities-edit', function ($trail) {
    $trail->parent('mission-priorities');
    $trail->push('Edit', url('/firm/mission-priorities/edit'));
});

//***************************************************************
// Home > Mission Status
Breadcrumbs::for('mission-status', function ($trail) {
    $trail->parent('home');
    $trail->push('Mission Status', url('/firm/mission-status/index'));
});

// Home > Mission Status > Create
Breadcrumbs::for('mission-status-create', function ($trail) {
    $trail->parent('mission-status');
    $trail->push('Create', url('/firm/mission-status/create'));
});

// Home > Mission Status > Edit
Breadcrumbs::for('mission-status-edit', function ($trail) {
    $trail->parent('mission-status');
    $trail->push('Edit', url('/firm/mission-status/edit'));
});

//***************************************************************
// Home > Mission Recurring Exceptions
Breadcrumbs::for('mission-recurring-exceptions', function ($trail) {
    $trail->parent('home');
    $trail->push('Vacations & Holidays', url('/firm/mission-recurring-exceptions/index'));
});

// Home > Mission Recurring Exceptions > Create
Breadcrumbs::for('mission-recurring-exceptions-create', function ($trail) {
    $trail->parent('mission-recurring-exceptions');
    $trail->push('Create', url('/firm/mission-recurring-exceptions/create'));
});

// Home > Mission Recurring Exceptions > Edit
Breadcrumbs::for('mission-recurring-exceptions-edit', function ($trail) {
    $trail->parent('mission-recurring-exceptions');
    $trail->push('Edit', url('/firm/mission-recurring-exceptions/edit'));
});

//***************************************************************
// Home > Mission Task Types
Breadcrumbs::for('mission-task-types', function ($trail) {
    $trail->parent('home');
    $trail->push('Mission Task Types', url('/firm/mission-task-types/index'));
});

// Home > Mission Task Types > Create
Breadcrumbs::for('mission-task-types-create', function ($trail) {
    $trail->parent('mission-task-types');
    $trail->push('Create', url('/firm/mission-task-types/create'));
});

// Home > Mission Task Types > Edit
Breadcrumbs::for('mission-task-types-edit', function ($trail) {
    $trail->parent('mission-task-types');
    $trail->push('Edit', url('/firm/mission-task-types/edit'));
});

//***************************************************************
// Home > Item Templates
Breadcrumbs::for('item-templates', function ($trail) {
    $trail->parent('home');
    $trail->push('Item Templates', url('/firm/item-templates/index'));
});

// Home > Item Templates > Create
Breadcrumbs::for('item-templates-create', function ($trail) {
    $trail->parent('item-templates');
    $trail->push('Create', url('/firm/item-templates/create'));
});

// Home > Item Templates > Edit
Breadcrumbs::for('item-templates-edit', function ($trail) {
    $trail->parent('item-templates');
    $trail->push('Edit', url('/firm/item-templates/edit'));
});

//// Mission Tasks
// Home > Item Template > Fields
Breadcrumbs::for('item-template-fields', function ($trail, $template) {
    $trail->parent('item-templates');
    $trail->push($template->display_name.' - Fields', url('/firm/item-template/'.$template->id.'/custom-fields'));
});

// Home > Item Template > Fields > Create
Breadcrumbs::for('item-template-fields-create', function ($trail, $template) {
    $trail->parent('item-template-fields', $template);
    $trail->push('Create Field', url('/firm/item-template/'.$template->id.'/custom-fields/create'));
});

// Home > Item Template > Fields > Edit
Breadcrumbs::for('item-template-fields-edit', function ($trail, $template, $field) {
    $trail->parent('item-template-fields', $template);
    $trail->push('Edit Field', url('/firm/item-template/'.$template->id.'/custom-fields/'.$field->id));
});

//***************************************************************
// Home > Tutorials
Breadcrumbs::for('tutorials', function ($trail) {
    $trail->parent('home');
    $trail->push('Tutorials', url('/firm/tutorials/index'));
});

// Home > Tutorials > Create
Breadcrumbs::for('tutorials-create', function ($trail) {
    $trail->parent('tutorials');
    $trail->push('Create', url('/firm/tutorials/create'));
});

// Home > Tutorials > Edit
Breadcrumbs::for('tutorials-edit', function ($trail) {
    $trail->parent('tutorials');
    $trail->push('Edit', url('/firm/tutorials/edit'));
});

//***************************************************************
// Home > Settings
Breadcrumbs::for('settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Settings', url('/firm/settings/index'));
});

// Home > Settings > Edit
Breadcrumbs::for('settings-edit', function ($trail) {
    $trail->parent('settings');
    $trail->push('Edit', url('/firm/settings/edit'));
});


//***************************************************************
// Home > Announcements
Breadcrumbs::for('announcements', function ($trail) {
    $trail->parent('home');
    $trail->push('Announcements', url('/firm/announcements/index'));
});

// Home > Announcements > Create
Breadcrumbs::for('announcements-create', function ($trail) {
    $trail->parent('announcements');
    $trail->push('Create', url('/firm/announcements/create'));
});

// Home > Announcements > Edit
Breadcrumbs::for('announcements-edit', function ($trail) {
    $trail->parent('announcements');
    $trail->push('Edit', url('/firm/announcements/edit'));
});

//***************************************************************
// Home > Chats
Breadcrumbs::for('chats', function ($trail) {
    $trail->parent('home');
    $trail->push('Chats', url('/firm/chats/index'));
});
