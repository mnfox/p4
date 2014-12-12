@extends('master')

@section('title')
    Register
@stop

@section('content')
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Register</h2>
                    <h3 class="section-subheading text-muted">Please fill out the following form to join our society</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ Form::open() }}
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    {{ Form::text('name', $value = null , $attributes =[
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'placeholder' => 'Your Name *',
                                        'id' => 'name',
                                    ])}};  
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    {{ Form::text('email', $value = null , $attributes =[
                                        'type' => 'email',
                                        'class' => 'form-control',
                                        'placeholder' => 'Your Email *',
                                        'id' => 'username',
                                    ])}};  
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    {{ Form::text('password', $value = null, $attributes =[
                                        'type' => 'password',
                                        'class' => 'form-control',
                                        'placeholder' => 'Your Password *',
                                        'id' => 'password',
                                    ])}}
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <h5 class="bright">
                                    {{ $errors->first('name') }}
                                    {{ $errors->first('email') }}
                                    {{ $errors->first('password') }}
                                    {{ $errors->first('unique') }}
                                </h5>
                            </div>
                            <div class="col-lg-12 text-center">
                                {{ Form::submit('Register', ['class' => 'btn btn-xl']) }}
                                <a href="{{ URL::route('showlogin') }}"><h3 class="section-subheading text-muted">Already have an account? Log in here.</h3></a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@stop
