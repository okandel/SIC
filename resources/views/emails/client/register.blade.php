@extends('beautymail::templates.phlog')

@section('content')

@include ('beautymail::templates.phlog.heading' , [
        'heading' => 'Verify  Email',
        'level' => 'h1',
    ])
    
@include('beautymail::templates.phlog.contentStart')

<p> Dear {{ $photographer->full_name }},</p>
<p>Please click below to confirm your email.<span style="color: #999;"> or copy and paste this link in your browser:</span></p>

<a href="#" style="color: #666; text-decoration: none;">
	{{ URL::to('photographer/verifyemail', array($token)) }} 
</a>


@include('beautymail::templates.phlog.contentEnd')

@include('beautymail::templates.phlog.button', [
'title' => 'Confirm Email',
'link' =>  URL::to('photographer/verifyemail', array($token)) 
])





 

@stop

 


