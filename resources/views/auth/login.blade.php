<x-layout>
    <x-slot:title>
        Login
    </x-slot:title>

    <div class="container">
        <div class="login">
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
</x-layout>