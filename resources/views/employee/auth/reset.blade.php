@extends('employee.layout.anonymous_master')

@section('content') 
    <form  id="loginform"  class="col-lg-12" id="sign_in" method="POST" action="{{ url('employee/auth/password/reset') }}">
        <h5 class="title">RESET PASSWORD</h5>
	    <p class="input-instruction">Enter your new password to reset<p>
        {{ csrf_field() }} 
        {!! Form::hidden('token', $token) !!}

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
                <input type="password" name="password" required class="form-control">
             <label class="form-label">Password</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" name="password_confirmation" required class="form-control" >
             <label class="form-label">Password Confirmation</label>
            </div>
        </div>
        <div>
            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-cyan">
            <label for="rememberme">Remember Me</label>
        </div>   
        <div class="col-lg-12"> 
            <button class="btn btn-raised btn-primary waves-effect" type="submit">Submit</button> 
        </div>                     
    </form> 
    <div class="col-lg-12 m-t-20">
        <a class="" href="{{ url('employee/auth/login') }}">Login</a>
    </div> 
@stop

@section('scripts')

<script>
   
</script>

@stop
 