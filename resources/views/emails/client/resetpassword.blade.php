@extends('beautymail::templates.phlog')

@section('content')

@include ('beautymail::templates.phlog.heading' , [
        'heading' => 'Reset Password',
        'level' => 'h1',
    ])
    
@include('beautymail::templates.phlog.contentStart')

<p> Dear {{ $photographer->full_name }},</p>
<p>Please click below to reset your password.<span style="color: #999;"> or copy and paste this link in your browser:</span></p>

<a href="#" style="color: #666; text-decoration: none;">
	{{ URL::to('photographer/password/reset', array($token)) }} 
</a>


@include('beautymail::templates.phlog.contentEnd')

@include('beautymail::templates.phlog.button', [
'title' => 'Reset password',
'link' =>  URL::to('photographer/password/reset', array($token)) 
])





 

@stop

 


