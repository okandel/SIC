@extends('beautymail::templates.sic')

@section('content')

@include ('beautymail::templates.sic.heading' , [
        'heading' => 'Verify  Email',
        'level' => 'h1',
    ])
    
@include('beautymail::templates.sic.contentStart')

<p> Dear {{ $firmLogin->first_name }} {{ $firmLogin->last_name }},</p>
<p>Please click below to confirm your email.<span style="color: #999;"> or copy and paste this link in your browser:</span></p>

<a href="#" style="color: #666; text-decoration: none;">
	{{ URL::to('firm/auth/verifyemail', array($token)) }} 
</a>


@include('beautymail::templates.sic.contentEnd')

@include('beautymail::templates.sic.button', [
'title' => 'Confirm Email',
'link' =>  URL::to('firm/auth/verifyemail', array($token)) 
])





 

@stop

 


