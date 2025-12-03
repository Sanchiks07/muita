<nav class="navigation">
    @auth
        @if(auth()->user()->role == 'admin')
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="">Add user</a></li>
            </ul>
        @endif

        <form method="GET" action="{{ route('dashboard') }}">
            <input type="text" name="search" placeholder="Search..." />
            <button type="submit">Search</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    @endauth
</nav>