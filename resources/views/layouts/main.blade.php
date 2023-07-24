<!doctype html>
<html lang="en">
	<head>
 @include('partials.head')
   </head>
  <body>
  
		@include('partials.navbar')

    <div class="container mt-4">
			@yield('container')
		</div>

		@include('partials.footer')
  
  </body>
</html>