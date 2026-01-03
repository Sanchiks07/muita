<nav class="navigation">
    @auth
        @if(auth()->user()->role == 'inspector' || auth()->user()->role == 'analyst')
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('risk.scan') }}">Risk Scan</a></li>
                <li><a href="{{ route('cases.create') }}">Case Register</a></li>
            </ul>
        @endif

        @if(auth()->user()->role == 'broker')
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('documents.create') }}">Add Document</a></li>
            </ul>
        @endif

        @if(auth()->user()->role == 'admin')
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('risk.scan') }}">Risk Scan</a></li>
                <li><a href="{{ route('users.create') }}">Add New User</a></li>
            </ul>
        @endif

        <form method="GET" action="{{ route('dashboard') }}">
            <div>
                <div class="search-tooltip">
                    ⓘ
                    <span class="search-tooltip-text">Case-sensitive!</span>
                </div>
                <input type="text" name="search" class="searchbar" placeholder="Search..." value="{{ request('search') }}" />
            </div>
            <button type="submit" class="search-btn">Search</button>
        </form>

        <div class="nav-right">
            <ul>
                <li><button onclick="lightAndDark()" class="mode-btn"><img src="/moon.png" alt="Moon Icon">Dark Mode</button></li>
            </ul>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        <div>
    @endauth
</nav>

<script>
    // applies saved mode immediately before page renders to prevent flicker
    (function() {
        const savedMode = localStorage.getItem("mode");
        if (savedMode === "dark") {
            document.documentElement.classList.add("dark-mode");
        }
    })();

    function lightAndDark() {
    const element = document.documentElement;
    const button = document.querySelector(".mode-btn");
    
    element.classList.toggle("dark-mode");
    
    // saglabā the mode preference to localStorage
    if (element.classList.contains("dark-mode")) {
        localStorage.setItem("mode", "dark");
        button.innerHTML = '<img src="/sun.png" alt="Sun Icon">Light Mode';
    } else {
        localStorage.setItem("mode", "light");
        button.innerHTML = '<img src="/moon.png" alt="Moon Icon">Dark Mode';
    }
    }

    // ielādē saglabāto mode preference on page load
    document.addEventListener("DOMContentLoaded", function() {
        const savedMode = localStorage.getItem("mode");
        const button = document.querySelector(".mode-btn");
        
        if (savedMode === "dark") {
            document.documentElement.classList.add("dark-mode");
            button.innerHTML = '<img src="/sun.png" alt="Sun Icon">Light Mode';
        } else {
            button.innerHTML = '<img src="/moon.png" alt="Moon Icon">Dark Mode';
        }
    });
</script>