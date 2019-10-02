@extends('employee.layout.anonymous_master')

@section('content')

 
    <form  id="loginform"  class="col-lg-12" id="sign_in" method="POST" action="{{ route('employee.auth.forgot-password.post') }}">

        <h5 class="title">Forgot Password?</h5>
        {{ csrf_field() }}
        <small class="msg">Enter your e-mail address below to reset your password.</small>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif 

        @if(session()->has('error'))
            @include('partials/alert_message', ['type' => 'danger', 'message' => session('error')])
        @endif
        @if(session()->has('success'))
            @include('partials/alert_message', ['type' => 'success', 'message' => session('success')])
        @endif 
        <div class="form-group form-float">
                <div class="form-line">
                    <input type="email" name="email" value="{{ old('email') }}" required 
                    class="form-control"> 
                    <label class="form-label">Email</label>
                </div>
            </div>
            <div class="col-lg-12"> 
                <button class="btn btn-raised btn-primary waves-effect" type="submit">Reset my password</button>  
            </div>
    </form>
    
    <div class="col-lg-12 m-t-20">
        <a href="{{ url('employee/auth/login') }}" title="">Sign In!</a>
    </div>
          
 
 

@stop