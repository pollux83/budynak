@extends('auth.layouts.layouts')

@section('content')
    <body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form role="form" method="POST" action="{{ secure_url('/login') }}">
                        {{ csrf_field() }}
                        <h1>Login Form</h1>
                        <div>
                            <!--<input type="text" class="form-control" placeholder="Username" required="" />-->
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   placeholder="email" required="" autofocus/>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div>
                            <!--<input type="password" class="form-control" placeholder="Password" required="" />-->
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                   required=""/>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Remember Me
                            </label>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-default submit">
                                Login
                            </button>
                            <a class="btn btn-link" href="{{ secure_url('/password/reset') }}">
                                Forgot Your Password?
                            </a>
                            <!--<a class="btn btn-default submit" href="index.html">Log in</a>
                            <a class="reset_pass" href="#">Lost your password?</a>-->
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">New to site?
                                <a href="#signup" class="to_register"> Create Account </a>
                            </p>

                            <div class="clearfix"></div>
                            <br/>

                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and
                                    Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <form role="form" method="POST" action="{{ secure_url('/register') }}">
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
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="#signin" class="to_register"> Log in </a>
                            </p>

                            <div class="clearfix"></div>
                            <br/>

                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and
                                    Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    </body>
@endsection
