
@if ( Request::is('/') || Request::is('learn') || Request::is('register') || Request::is('signin')  )
	<div class="hug hug-footerOut">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<ul class="list-inline list-style-none">
						<li><a href="/about">About Ribbbon</a></li>
						<li><a href="/faq">FAQ</a></li>
					</ul>				
				</div>
				<div class="col-xs-12 col-md-6">
					<ul class="list-inline list-style-none pull-right">					
						<li>Developed with<a target="_blank" href="http://laravel.com/"> Laravel</a> by <a target="_blank" href="http://www.punyweblab.com/"> Jefry Cruz.</a></li>
					</ul>				
				</div>
			</div>
		</div>
	</div>
@else
	<!-- <div class="hug hug-footerIn">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<ul class="list-inline list-style-none">
						<li><a href="/about">About Ribbbon</a></li>
						<li><a href="/faq">FAQ</a></li>
					</ul>				
				</div>
				<div class="col-xs-12 col-md-6">
					<ul class="list-inline list-style-none pull-right">					
						<li>Developed with<a target="_blank" href="http://laravel.com/"> Laravel</a> by <a target="_blank" href="http://www.punyweblab.com/"> Jefry Cruz.</a></li>
					</ul>				
				</div>
			</div>
		</div>
	</div> -->
@endif


<!-- js -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>