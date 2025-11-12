<x-layout>
    <div class="login">
        <h2>Login</h2>
        <form action="/login" method="POST">
            @csrf
            <input name="email" id="username" type="email" placeholder="Username"/>
            <input name="password" id="password" type="password" placeholder="Password"/>
            <button class="login-btn">Login</button>
        </form>
    </div>
</x-layout>
