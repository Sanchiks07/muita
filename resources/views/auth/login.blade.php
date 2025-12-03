<x-layout>
    <x-slot:title>
        Login
    </x-slot:title>

    <div class="login-container">
        <h2>Login</h2><br>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <select name="role" id="role" required>
                <option value="" disabled selected>Select your role</option>
                <option value="inspector">Inspector</option>
                <option value="analyst">Analyst</option>
                <option value="broker">Broker</option>
                <option value="admin">Admin</option>
            </select><br>
            
            <input type="password" id="password" name="password" placeholder="Password" required><br>

            <button type="submit" class="login_btn">Login</button>
        </form>
    </div>
</x-layout>