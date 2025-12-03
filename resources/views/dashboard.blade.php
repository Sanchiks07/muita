<x-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="container">
        @switch(auth()->user()->role)
            @case('inspector')
                <div>inspector nam nam</div>
                @break

            @case('analyst')
                <div>analyst nam nam</div>
                @break

            @case('broker')
                <div>broker nam nam</div>
                @break

            @case('admin')
                <div>admin nam nam</div>
                @break

            @default
                <p>Nothing to see here.</p>
        @endswitch
    </div>
</x-layout>