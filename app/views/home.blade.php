<!doctype html>
<html lang="en">
<head>

	<style>
		body {
		  padding-top: 50px;
		}
		.starter-template {
		  padding: 40px 15px;
		  text-align: center;
		}
	</style>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bible Planner</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.min.css">

	

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>



	<div class="starter-template">
        <h1>Bible Planner</h1>
        <p class="lead">Here is your customized reading plan.</p>
        {{ Form::open(['method' => 'get']) }}
	      <div class="form-group">
	      	{{ Form::text('num_days', Input::get('num_days',365), ['class'=>'form-control bfh-number', 'data-min'=>1, 'data-max'=>365]); }}
	     </div>

	     <div class="form-group">
	     	{{ Form::select('version', $versions, Input::get('version','eng-KJVA'),['class'=>'form-control']) }}
	     </div>
	     <div class="form-group">
	     	{{ Form::submit('Change settings!', ['class'=>'form-control btn btn-danger']) }}
	     </div>
	    {{ Form::close() }}
        @foreach ($days as $day)
	    		<div class="list-group-item active">
	        		<div class="list-grou-text">
	        			Day {{ $day->i }}
	        		</div>
	        	</div>
	    	<div class="list-group">

		        	 @foreach ($day->headings as $heading)
			        	<div class="list-group-item">
			        		<div class="list-grou-text">
			        			<strong>{{ $heading->name }} {{ $heading->start_chapter }}:{{ $heading->start_verse }} to {{ $heading->end_chapter }}:{{ $heading->end_verse }} </strong>: {{ $heading->heading_text }}
			        		</div>
			        	</div>
		        	@endforeach

        @endforeach
        
     </div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/js/bootstrap-formhelpers.min.js"></script>
</body>
</html>
