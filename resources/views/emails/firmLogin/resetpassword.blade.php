@extends('beautymail::templates.sic')

@section('content')

@include ('beautymail::templates.sic.heading' , [
        'heading' => 'Reset Password',
        'level' => 'h1',
    ])
    
@include('beautymail::templates.sic.contentStart')

<p> Dear {{ $firmLogin->first_name }} {{ $firmLogin->last_name }},</p>
<p>Please click below to reset your password.<span style="color: #999;"> or copy and paste this link in your browser:</span></p>

<a href="#" style="color: #666; text-decoration: none;">
	{{ URL::to('firm/auth/password/reset', array($token)) }} 
</a>


@include('beautymail::templates.sic.contentEnd')

@include('beautymail::templates.sic.button', [
'title' => 'Reset password',
'link' =>  URL::to('firm/auth/password/reset', array($token)) 
])





 

@stop

 


