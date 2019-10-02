 
 

<div class="container-fluid mt-2">
    <div class="row clearfix mt-0">
        <div class="col-sm-12">
            <div class="card">
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#missions">Mission Details</a></li>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#employee">Employee</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tasks">Mission Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#vehicles">Vehicles</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#devices">Devices</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        {{--Mission Details--}}
                        <div role="tabpanel" class="tab-pane active" id="missions">
                            <div class="row " >
                                <div class="col-sm-12">
                                    <h4><i class="fa fa-tag"></i> {{$mission->title}}</h4>
                                </div>
                                
                            </div>
                        <div class="row">
                                            <div class="col-sm-12">
                                                
                                                <div class="row " >
                                                    <div class="col-sm-6">
                                                        <p><span class="text-primary"><i class="fa fa-map-marked-alt"></i>   </span> 
                                                        {{$mission->client_branch->client->contact_person}}
                                                        <br/>
                                                        {{$mission->client_branch->display_name}}</p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <p><span class="text-primary"><i class="fa fa-sort-amount-up-alt"></i>  </span> {{$mission->priority->name}}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row" style="margin-top: 25px; margin-bottom: -20px">
                                                    <div class="col-sm-6">
                                                        <p><span class="text-primary"><i class="fa fa-calendar"></i></span> {{$mission->start_date? $mission->start_date : "Not defined"}}</p>
                                                    </div> 
                                                </div>
                                                <hr>
                                                <p>{{ $mission->description }}</p>
                                            </div>
                                            <div class="col-sm-1">
                                                <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: 10px auto"></div>
                                            </div>
                                             
                                        </div>
                        </div>

                        {{--Employee--}}
                        
                        <div role="tabpanel" class="tab-pane" id="employee">
                           
                            <div class="row " >
                                
                                <div class="col-sm-12">
                                    <a href="{{url('/firm/employees/'.$mission->employee->id.'/profile')}}">
                                    <img src="{{$mission->employee->image}}" width="32px" height="32px"/></a>
                                
                                    <a href="{{url('/firm/employees/'.$mission->employee->id.'/profile')}}">
                                    {{$mission->employee->first_name}} {{$mission->employee->last_name}}</a>
                                    

                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="row">
                                                <?php 
                                                 $statistics = $mission->employee->getStatistics();
                                                ?>
                                                    <div class="col-auto text-center">
                                                        <div class="body">
                                                            <p>All Missions</p>
                                                            <h2 class="text-center badge badge-pill badge-default" style="font-size: 25px">{{$statistics["total_tasks"]}}</h2>
                                                        </div>
                                                    </div> 
                                                        <div class="col-auto text-center">
                                                            <div class="body">
                                                                <p>Scheduled</p>
                                                                <h2 class="text-center badge badge-pill badge-success" style="font-size: 25px">{{$statistics["new_tasks"]}}</h2>
                                                            </div>
                                                        </div> 
                                                        <div class="col-auto text-center">
                                                            <div class="body">
                                                                <p>Done</p>
                                                                <h2 class="text-center badge badge-pill badge-primary" style="font-size: 25px">{{$statistics["done_tasks"]}}</h2>
                                                            </div>
                                                        </div> 
                                                        <div class="col-auto text-center">
                                                            <div class="body">
                                                                <p>Re-arranged</p>
                                                                <h2 class="text-center badge badge-pill badge-info" style="font-size: 25px">{{$statistics["Rearranged_tasks"]}}</h2>
                                                            </div>
                                                        </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    
                                </div>
                            </div>
                        </div>


                        {{--Tasks--}}
                        <div role="tabpanel" class="tab-pane" id="tasks">
                            @if(count($mission->tasks) > 0)
                                @foreach($mission->tasks as $task)
                                    <div class="card" style="border: 1px solid #eeeeee">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-4">
                                                    <span class="phone">
                                                        <span class="text-primary"><i class="fa fa-th"></i> Item: </span> {{$task->item ? $task->item->name : 'No item'}}
                                                    </span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="phone">
                                                        <span class="text-primary"><i class="fa fa-stream"></i> Type: </span> {{$task->type->name}}
                                                    </span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            {{--Branche Reps--}}
                                            <section class="contact">
                                                <div class="container-fluid">
                                                    <ul class="list-unstyled">
                                                        <div class="row">
                                                            <div class="col-sm-3 text-center">
                                                                <h6>The Task Attachments</h6>
                                                                @if(count($task->attachments) > 0)
                                                                    @foreach($task->attachments as $attachment)
                                                                        <li class="c_list">
                                                                            <div class="row">
                                                                                <div class="avatar text-center" style="margin-left: 38%">
                                                                                    @if($attachment->mime_type == 'image/png' || $attachment->mime_type == 'image/jpg' || $attachment->mime_type == 'image/jpeg')
                                                                                        <img src="{{'/'.$attachment->attachment_url}}" alt="" />
                                                                                    @else
                                                                                        <img src="{{'/uploads/defaults/attachment.png'}}" alt="" />
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <hr>
                                                                    @endforeach
                                                                @else
                                                                    <p style=" margin-bottom: -20px">No attachments</p>
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: 10px auto"></div>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <h6>The Task Item</h6>
                                                                @if($task->item)
                                                                    <div class="row" style="margin-left: 1px; margin-bottom: -15px">
                                                                        <div class="col-sm-6">
                                                                            <label for="name">Item Name</label>
                                                                            <p id="name">{{ $task->item ? $task->item->name : 'No item'}}</p>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <li class="c_list">
                                                                                <div class="row">
                                                                                    <div class="avatar text-center" style="margin-left: 38%">
                                                                                        @if($task->item->image)
                                                                                            <img src="{{$task->item->image}}" class="" alt="" />
                                                                                        @else
                                                                                            <img src="{{'/uploads/defaults/item.png'}}" class="rounded-circle" alt="" />
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                    <hr style="width: 96%">
                                                                    @if($task->item->item_payload)
                                                                        @include('firm.items._template',['fields' => $task->item->itemTemplate->customFields, 'item' => $task->item,
                                                                         'item_payload' =>  json_decode($task->item->item_payload, true),
                                                                         'readonly' => true
                                                                        ])
                                                                    @endif
                                                                @else
                                                                    <p>No item</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center">No tasks yet!</p>
                            @endif
                        </div>


                        
                        {{--Vehicles--}}
                        <div role="tabpanel" class="tab-pane" id="vehicles">
                        @if(count($vehicles) > 0)
                                        @foreach($vehicles as $vehicle)
                                            <div class="card" style="border: 1px solid #eeeeee">
                                                <div class="card-header">
                                                    <h5>{{$vehicle->type}}</h5>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <span class="phone">
                                                                <span class="text-primary"><i class="fa fa-car"></i> Brand: </span> {{$vehicle->brand}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="phone">
                                                                <span class="text-primary"><i class="fa fa-calendar"></i> Year: </span> {{$vehicle->year}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="email">
                                                                <span class="text-primary"><i class="fa fa-hashtag"></i> Passengers: </span> {{$vehicle->no_of_passengers}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="email">
                                                                <span class="text-primary"><i class="fa fa-info"></i> Body type: </span> {{$vehicle->body_type}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">No vehicles yet!</p>
                                    @endif
                        </div>




                        {{--Devices--}}
                        <div role="tabpanel" class="tab-pane" id="devices">
                        @if(count($devices) > 0)
                                        @foreach($devices as $device)
                                            <div class="card" style="border: 1px solid #eeeeee">
                                                <div class="card-body">
                                                    <h5>{{$device->display_name}}</h5>
                                                    <p>{{$device->os_type}}</p> 
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">No devices yet!</p>
                                    @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<script>
    
    // var contentString = '<div id="content">'+
    //     '<div id="siteNotice">'+
    //     '</div>'+
    //     '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
    //     '<div id="bodyContent">'+
    //     '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
    //     'sandstone rock formation in the southern part of the '+
    //     'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
    //     'south west of the nearest large town, Alice Springs; 450&#160;km '+
    //     '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
    //     'features of the Uluru - Kata Tjuta National Park. Uluru is '+
    //     'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
    //     'Aboriginal people of the area. It has many springs, waterholes, '+
    //     'rock caves and ancient paintings. Uluru is listed as a World '+
    //     'Heritage Site.</p>'+
    //     '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
    //     'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
    //     '(last visited June 22, 2009).</p>'+
    //     '</div>'+
    //     '</div>';
</script>