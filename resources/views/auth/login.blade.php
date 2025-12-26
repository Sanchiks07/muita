<x-layout>
    <x-slot:title>
        Login
    </x-slot:title>

    <div class="container">
        <div class="login">
            <div class="login-mode-btn">
                <button onclick="lightAndDark()" class="mode-btn"><img src="/moon.png" alt="Moon Icon">Dark Mode</button>
            </div>

            <h2>Login</h2><br>

            <form action="{{ route('login') }}" method="POST" class="login-form">
                @csrf
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="inspector">Inspector</option>
                    <option value="analyst">Analyst</option>
                    <option value="broker">Broker</option>
                    <option value="admin">Admin</option>
                </select><br>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>

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
</x-layout>

