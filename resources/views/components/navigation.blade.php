<nav>
    @auth
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