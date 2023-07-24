<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-lg position-fixed w-100 pt-3 pb-3">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/" style="color: #e1bc6c;"><i class="fa-solid fa-paw fa-lg" style="color: #e1bc6c;"></i> KucingKu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/') && !request('type') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
        </li>
				<li class="nav-item">
          <a class="nav-link {{ request('type')=='cat' ? 'active' : '' }}" aria-current="page" href="/?type=cat">Cat</a>
        </li>
				<li class="nav-item">
          <a class="nav-link {{ request('type')=='food' ? 'active' : '' }}" aria-current="page" href="/?type=food">Food</a>
        </li>
				<li class="nav-item">
          <a class="nav-link {{ request('type')=='Shampoo' ? 'active' : '' }}" aria-current="page" href="/?type=Shampoo">Shampoo</a>
        </li>
				<li class="nav-item">
          <a class="nav-link {{ request('type')=='accessories' ? 'active' : '' }}" aria-current="page" href="/?type=accessories">Accessories</a>
        </li>
        	<li class="nav-item">
          <a class="nav-link {{ request('type')=='cage' ? 'active' : '' }}" aria-current="page" href="/?type=cage">Cage</a>
        </li>
      </ul>
   
      @auth

	  <a href="/cart" class="me-3 text-decoration-none {{ Request::is('cart') ? 'text-dark' : 'text-muted' }}"><i class="fas fa-shopping-cart "></i></a>
		<a href="/transaction" class="me-3 text-decoration-none {{ Request::is('transaction') ? 'text-dark' : 'text-muted' }}"><i class="fa-solid fa-basket-shopping"></i></a>
    
<div class="dropdown d-inline-block">
    <a href="/" class="me-3 dropdown-toggle text-decoration-none text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user me-2"></i> {{ auth()->user()->username }}</a>
  <ul class="dropdown-menu">
    <li>      
      <form action="/logout" method="post">
        @csrf
        <button type="submit" class="btn btn-danger dropdown-item">Logout <i class="fa-solid fa-right-from-bracket"></i></button>
      </form>
     </li>
  </ul>
</div>
      @else
    <a href="/cart" class="me-3 text-decoration-none {{ Request::is('cart') ? 'text-dark' : 'text-muted' }}"><i class="fas fa-shopping-cart "></i></a>
		<a href="/login" class="me-3 text-decoration-none {{ Request::is('login') ? 'text-dark' : 'text-primary' }}">Login <i class="fa-solid fa-right-to-bracket"></i></a>
      @endauth
    </div>
  </div>
</nav>