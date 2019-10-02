<div class="menu">
    <ul class="list">
        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ (request()->is('/') || request()->is('firm')) ? 'active' : '' }}">
            <a href="{!! url('/') !!}"><span><i class="fa fa-home"></i> Live Dashboard</span> </a>
        </li>
        <li class="{{ (request()->is('firm/users*')) ? 'active' : '' }}">
            <a href="{!! url('firm/users/index') !!}"><span><i class="fa fa-users"></i> Users</span> </a>
        </li>
        <li class="{{ (request()->is('firm/employees*')) ? 'active' : '' }}">
            <a href="{!! url('firm/employees/index') !!}"><span><i class="fa fa-user-tie"></i> Employees</span> </a>
        </li>
        <li class="{{ (request()->is('firm/client*')) ? 'active' : '' }}">
            <a href="{!! url('firm/clients/index') !!}"><span><i class="fa fa-user-shield"></i> Clients</span> </a>
        </li>
        <li class="{{ (request()->is('firm/missions*') || request()->is('firm/mission/'.request()->route('MissionId').'/task*')) ? 'active' : '' }}">
            <a href="{!! url('firm/missions/index') !!}"><span><i class="fa fa-project-diagram"></i> Missions</span> </a>
        </li>
        <li class="{{ (request()->is('firm/items*')) ? 'active' : '' }}">
            <a href="{!! url('firm/items/index') !!}"><span><i class="fa fa-th"></i> Items</span> </a>
        </li>
        <li class="{{ (request()->is('firm/vehicles*')) ? 'active' : '' }}">
            <a href="{!! url('firm/vehicles/index') !!}"><span><i class="fa fa-car"></i> Vehicles</span> </a>
        </li>
        <li class="{{ (request()->is('firm/devices*')) ? 'active' : '' }}">
            <a href="{!! url('firm/devices/index') !!}"><span><i class="fa fa-mobile-alt"></i> Devices</span> </a>
        </li>
        <li class="{{ (request()->is('firm/announcements*')) ? 'active' : '' }}">
            <a href="{!! url('firm/announcements/create') !!}"><span><i class="fa fa-bullhorn"></i> Announcements</span> </a>
        </li>
        <li class="{{ (request()->is('firm/chats*')) ? 'active' : '' }}">
            <a href="{!! url('firm/chats/index') !!}"><span><i class="fa fa-comments"></i> Chats</span> </a>
        </li>
        <li @if(request()->is('firm/mission-priorities*')
                || request()->is('firm/mission-status*')
                || request()->is('firm/mission-recurring-exceptions*')
                || request()->is('firm/mission-task-types*')
                || request()->is('firm/item-template*')
                || request()->is('firm/tutorials*')
                || request()->is('firm/settings*')
                ) class="active open" @else class="" @endif><a href="javascript:void(0);" class="menu-toggle"><span><i class="fa fa-cogs"></i> Configuration</span></a>
            <ul class="ml-menu">
                <li class="{{ (request()->is('firm/mission-priorities*')) ? 'active' : '' }}">
                    <a href="{!! url('firm/mission-priorities/index') !!}"><span><i class="fa fa-list-ol"></i> Mission Priorities</span></a>
                </li>
                <li class="{{ (request()->is('firm/mission-status*')) ? 'active' : '' }}">
                    <a href="{!! url('firm/mission-status/index') !!}"><span><i class="fa fa-battery-half"></i> Mission Status</span></a>
                </li>
                <li class="{{ (request()->is('firm/mission-recurring-exceptions*')) ? 'active' : '' }}">
                    <a href="{!! url('firm/mission-recurring-exceptions/index') !!}"><span><i class="fa fa-exclamation-triangle"></i> Vacations & Holidays</span></a>
                </li>
                <li class="{{ (request()->is('firm/mission-task-types*')) ? 'active' : '' }}">
                    <a href="{!! url('firm/mission-task-types/index') !!}"><span><i class="fa fa-stream"></i> Mission Task Types</span></a>
                </li>
                <li class="{{ (request()->is('firm/item-template*')) ? 'active' : '' }}">
                    <a href="{!! url('firm/item-templates/index') !!}"><span><i class="fa fa-file-alt"></i> Item Templates</span> </a>
                </li>
                <li class="{{ (request()->is('firm/tutorials*')) ? 'active' : '' }}">
                    <a href="{!! url('firm/tutorials/index') !!}"><span><i class="fa fa-images"></i> Tutorials</span></a>
                </li>
                <li class="{{ (request()->is('firm/settings')) ? 'active' : '' }}">
                    <a href="{!! url('firm/settings') !!}"><span><i class="fa fa-cog"></i> Settings</span></a>
                </li>
            </ul>
        </li>
    </ul>
</div>