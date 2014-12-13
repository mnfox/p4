@extends('master')

@section('title')
    Berry Appreciation Society
@stop

@section('navcontent')
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            <li class="hidden">
                <a href="#page-top"></a>
            </li>
            <li>
                <a class="page-scroll" href="#services">About</a>
            </li>
            <li>
                <a class="page-scroll" href="#portfolio">Events</a>
            </li>
            <li>
                <a class="page-scroll" href="#about">History</a>
            </li>
            <li>
                <a class="page-scroll" href="#team">Berries</a>
            </li>
            <li>
                <a class="page-scroll" href="#contact">Contact</a>
            </li>
            <li>
                <a href="{{ URL::route('logout') }}">Log Out</a>
            </li>
        </ul>
    </div>
@stop

@section('content')
      <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome {{{ Auth::user()->username }}}</div>
                <div class="intro-heading">A place to enjoy berries</div>
                <a href="#services" class="page-scroll btn btn-xl">Tell Me More</a>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">About</h2>
                    <h3 class="section-subheading text-muted">We are an international society dedicated to the appreciation of common berries. We believe that they are delicious fruits, and deserve to be recognised as such. We run three main types of events, as described below.</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-question fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Berry Identification Events</h4>
                    <p class="text-muted">Spotted an unusual berry on your travels? Bring a sample (if possible), or a photo along to a Berry Identification Event to help you figure out what kind of berry it is. Please be sure not to sample berries unless you know what they are, as they can often be poisonous. Berry Appreciation is a dangerous hobby, please be careful!</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-tree fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Berry Picking Events</h4>
                    <p class="text-muted">Join our teams of expert berry connoisseurs as they guide you through different environments to help you pick berries right from the source. Popular themes include 'Urban Berry Exploration' (finding berries in typically built up areas), and 'Don't Judge A Berry By Its Cover' (berries tyhpically found growing on weeds, or menacing plants).</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-leaf fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Berry Growing Events</h4>
                    <p class="text-muted">Attend these to meet up with a myriad of like minded, good ol' fashioned, berry appreciators, who want nothing more than to grow their own little slice of heaven right at home. At these events you can purchase berry growing starter packs, as well as seek out advice and tips to make the most out of your very own berry patch.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Grid Section -->
    <section id="portfolio" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Events</h2>
                    <h3 class="section-subheading text-muted">Here you'll find a list of upcoming events around the world. <a href="{{ URL::route('create') }}">Please click here to create your own event.</a?</h3>
                </div>
            </div>
            <div class="row">
            @if (count($events))
                @foreach($events as $event)
                    <div class="col-md-4 col-sm-6 portfolio-item">
                        <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                            <img src="img/portfolio/{{ $event->type }}.png" class="img-responsive" alt="">
                        </a>
                        <div class="portfolio-caption">
                            <h4>{{ $event->location }}</h4>
                            <h6>{{ $event->date }}</h6>
                            <p class="text-muted">{{ $event->description }}</p>
                            {{ Form::open() }}
                            {{ Form::hidden('hidden', $event->id) }} 
                            @if (Gathering::user_gathering($event->id))
                                {{ Form::submit('Unjoin', ['name' => 'unjoin', 'class' => 'btn btn-primary']) }}                                
                            @else
                                {{ Form::submit('Join', ['name' => 'join', 'class' => 'btn btn-primary']) }}
                            @endif                         
                            @if (Auth::check())
                                @if ($event->createdby == Auth::user()->id)
                                    {{ Form::submit('Edit', ['name' => 'edit', 'class' => 'btn btn-primary']) }}
                                @endif
                            @endif
                            {{ Form::close() }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-lg-12 text-center">
                    <p>No Events Exist. Why not create one?</p>
                </div>
            @endif
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">History</h2>
                    <h3 class="section-subheading text-muted">Here you'll find a history of our humble organisation. Enjoy!</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/mixed.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>12054 BC</h4>
                                    <h4 class="subheading">The Dawn of Berries</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">In this monumental year, Berries were discovered and became an instant fixture on tastebuds everywhere. We, as humans, share our prolific love of berries with so many other creatures in the animal kingdom, and to this day, we can all bond over that fact.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/dead.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>548 AD</h4>
                                    <h4 class="subheading">Worldwide Berry Shortage</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">After a veritable golden age of berry consumption, berry production all but came to a halt in the early 500's. This was followed by the great tragedy we berry lovers call the 'Great Berry Shortage'. We consider this a great blight on the history of berries, and strive to never let it happen again.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/icecream.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>1890</h4>
                                    <h4 class="subheading">The Berry Boom</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Berries found thesmelf in a second golden age in the late 1800's, when all their joys were once again realised. Due to advancements in technology, berries were able to be incorporated into products as never seen before. We can thank this era for berries in ice cream, cakes, and even soap.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/pineberries.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>2014</h4>
                                    <h4 class="subheading">A New Age of Berries</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">The future holds a wealth of exciting new advances for berries. Scientists are working on creating the next varieties of berries, by mixing berries in ways never before possible, and revitalising extinct berries. Pictured is the Pineberry, which was saved by Dutch scientists and farmers.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <h4>Be Part
                                    <br>Of Our
                                    <br>Story!</h4>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Berries We Appreciate</h2>
                    <h3 class="section-subheading text-muted">While here at the Berry Appreciation Society, we love all types of berries, the simple facts are that some are more common than others. Here are the three most common berries:</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/strawberries.jpg" class="img-responsive img-circle" alt="">
                        <h4>Strawberries</h4>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/blueberries.jpg" class="img-responsive img-circle" alt="">
                        <h4>Blueberries</h4>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/raspberries.jpg" class="img-responsive img-circle" alt="">
                        <h4>Raspberries</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contact Us</h2>
                    <h3 class="section-subheading text-muted">Please send any berry related enquiries our way!</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" class="btn btn-xl">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

