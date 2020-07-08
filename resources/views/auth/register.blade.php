@extends('auth.layouts.layouts')

@section('content')
    <body class="login">
    <div class="login_wrapper">
        <div id="register">
            <section class="login_content">
                <form role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <h1>Create Account</h1>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <!--<input type="text" class="form-control" placeholder="Username" required="" />-->
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                               placeholder="Username" required="" autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div>
                        <!--<input type="email" class="form-control" placeholder="Email" required="" />-->
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                               placeholder="Email" required=""/>

                        @if ($errors->has('email'))
                            <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <!--<input type="password" class="form-control" placeholder="Password" required="" />-->
                        <input type="password" class="form-control" name="password" placeholder="Password" required=""/>

                        @if ($errors->has('password'))
                            <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password"
                               name="password_confirmation" required>
                    </div>
                    <div>
                        <!--<a class="btn btn-default submit" href="index.html">Submit</a>-->
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                    <div class="separator">
                        <p class="change_link">Already a member ?
                            <a href="login#signin" class="to_register"> Log in </a>
                        </p>

                        <div class="clearfix"></div>
                        <br/>

                        <div>
                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and
                                    Terms</p>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
    </body>
@endsection
