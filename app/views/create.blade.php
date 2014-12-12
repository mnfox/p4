@extends('master')

@section('title')
    Create Event
@stop

@section('content')
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">New Event</h2>
                    <h3 class="section-subheading text-muted">Please fill out the following form to create a new event</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ Form::open() }}
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    {{ Form::select('type', array('id' => 'Berry Identification Event', 'pick' => 'Berry Picking Event', 'grow' => 'Berry Growing Event')) }};
                                </div>
                                <div class="form-group">
                                     {{ Form::text('location', $value = null, $attributes =[
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'placeholder' => 'Event Location *',
                                        'id' => 'location',
                                    ])}}
                                </div>
                                <div class="form-group">
                                     {{ Form::text('time', $value = null, $attributes =[
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'placeholder' => 'Event Date and Time *',
                                        'id' => 'time',
                                    ])}}
                                </div>
                                <div class="form-group">
                                    {{ Form::text('description', $value = null, $attributes =[
                                        'type' => 'text',
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter a brief event description *',
                                        'id' => 'description',
                                    ])}}
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <h5 class="bright">
                                    {{ $errors->first('location') }}
                                    {{ $errors->first('date') }}
                                    {{ $errors->first('description') }}
                                </h5>
                            </div>
                            <div class="col-lg-12 text-center">
                                {{ Form::submit('Create', ['class' => 'btn btn-xl']) }}
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@stop
