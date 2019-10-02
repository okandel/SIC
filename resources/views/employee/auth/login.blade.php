@extends('employee.layout.anonymous_master')

@section('content') 
    <form  id="loginform"  class="col-lg-12" id="sign_in" method="POST" action="{{ route('employee.auth.login') }}">
        <h5 class="title">Sign in to your Account</h5>
        {{ csrf_field() }}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('returnUrl'))
            <input type="hidden" name="returnUrl" value="{{ session('returnUrl') }}"/>
        @endif
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="email" required>
                <label class="form-label">Email</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" class="form-control" name="password" required>
                <label class="form-label">Password</label>
            </div>
        </div>
        <div>
            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-cyan">
            <label for="rememberme">Remember Me</label>
        </div>   
        <div class="col-lg-12"> 
            <button class="btn btn-raised btn-primary waves-effect" type="submit">Log In</button> 
        </div>                     
    </form> 
    <div class="col-lg-12 m-t-20">
        <a class="" href="{{ route('employee.auth.forgot-password') }}">Forgot Password?</a>
    </div> 
@stop

@section('scripts')

<script>
   
</script>

@stop
 