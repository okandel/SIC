@extends('layouts.anonymous_master')

@section('content')


<div class="login-branding">
    <a href="#"><img src="/assets/images/logo-full.png" alt="logo"></a>
</div>
<div class="login-container" id="login">
    <h3 class="intro-text text-center">RESET PASSWORD</h3>
	<p class="input-instruction">Enter your new password to reset<p>		
    <hr>
   

    {!! Form::open(['url' => 'business/password/reset', 'method' => 'post', 'role' => 'form']) !!}	

    @if(session()->has('error') || ($errors!= null && $errors->all() != null))
    @include('partials/alert_message', ['type' => 'danger', 
    'message' => session('error'),
    'errors' =>$errors->all()
    ])
    @endif
    @if(session()->has('success'))
    @include('partials/alert_message', ['type' => 'success', 'message' => session('success')])
    @endif

         
        {!! Form::hidden('token', $token) !!}


       
<?php            //<input type="email" name="email" value="{{ old('email') }}"  required class="form-control floatlabel" placeholder="Enter Email">-->
?>
       
            <input type="password" name="password" required class="form-control floatlabel" placeholder="Enter Password">

            <input type="password" name="password_confirmation" required class="form-control floatlabel" placeholder="Confirm Password">
        
		<button type="submit" id="" class="btn btn-primary ">Send</button>  


      
    

    {!! Form::close() !!}
    <!-- END LOGIN FORM --> 


</div>

@stop

@section('scripts')

<script>
   
</script>

@stop