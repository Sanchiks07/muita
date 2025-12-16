<nav class="navigation">
    @auth
        @if(auth()->user()->role == 'inspector' || auth()->user()->role == 'analyst')
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            </ul>
        @endif

        @if(auth()->user()->role == 'broker')
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('document_create') }}">Add New Document</a></li>
            </ul>
        @endif

        @if(auth()->user()->role == 'admin')
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('user_create') }}">Add New User</a></li>
            </ul>
        @endif

        <form method="GET" action="{{ route('dashboard') }}">
            <div>
                <div class="search-tooltip">
                    ⓘ
                    <span class="search-tooltip-text">Case sensitive!</span>
                </div>
                <input type="text" name="search" class="searchbar" placeholder="Search..." value="{{ request('search') }}" />
            </div>
            <button type="submit" class="search-btn">Search</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    @endauth
</nav>