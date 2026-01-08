<x-layout>
    <x:slot:title>
        Create Inspection
    </x:slot:title>

    <div class="container">
        <!-- error messages -->
        @if ($errors->any())
            <div class="error-messages">
                <ul style="margin:0; padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- the inspection create -->
        <div class="create-container">
            <h2>Create New Inspection</h2><br>

            <form method="POST" action="{{ route('inspections.store') }}" class="create-form inspection">
                @csrf

                <div style="margin-bottom:5px;">
                    <label for="api_id">Inspection ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "insp-000001"</span>
                    </div>
                </div>
                <input type="text" id="api_id" name="api_id" value="{{ old('api_id') }}" required><br>

                <div style="margin-bottom:5px;">
                    <label for="case_id">Case ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "case-000001"</span>
                    </div>
                </div>
                <input type="text" id="case_id" name="case_id" value="{{ old('case_id') }}" required><br>

                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="" disabled selected>Select inspection type</option>
                    <option value="document" {{ old('type') === 'document' ? 'selected' : '' }}>Document</option>
                    <option value="xray" {{ old('type') === 'xray' ? 'selected' : '' }}>X-ray</option>
                    <option value="physical" {{ old('type') === 'physical' ? 'selected' : '' }}>Physical</option>
                </select><br>

                <label for="requested_by">Requested By</label>
                <select id="requested_by" name="requested_by" required>
                    <option value="" disabled selected>Select requested by</option>
                    <option value="inspector" {{ old('requested_by') === 'inspector' ? 'selected' : '' }}>Inspector</option>
                    <option value="risk-engine" {{ old('requested_by') === 'risk-engine' ? 'selected' : '' }}>Risk Engine</option>
                    <option value="system" {{ old('requested_by') === 'system' ? 'selected' : '' }}>System</option>
                </select><br>

                <label for="start_ts">Start Time</label>
                <input type="datetime-local" id="start_ts" name="start_ts" value="{{ old('start_ts') }}" required><br>

                <div style="margin-bottom:5px;">
                    <label for="location">Location</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "RIX-CP-01 | Box 1"</span>
                    </div>
                </div>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required><br>

                <p style="margin-bottom:5px;">Checks</p>
                @php
                    $checks = [
                        ['name' => 'Dokumentu pārbaude', 'result' => old('checks.0.result', 'pending')],
                        ['name' => 'Rendgena skenēšana', 'result' => old('checks.1.result', 'pending')],
                    ];
                @endphp

                @foreach ($checks as $index => $check)
                    <div style="margin-bottom:10px; display:flex; flex-direction: row; align-items:center; gap:10px;">
                        <label>{{ $check['name'] }}</label>
                        <input type="hidden" name="checks[{{ $index }}][name]" value="{{ $check['name'] }}">

                        <select name="checks[{{ $index }}][result]" style="width:30%;" required>
                            <option value="pending" {{ $check['result'] === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="finding" {{ $check['result'] === 'finding' ? 'selected' : '' }}>Finding</option>
                            <option value="ok" {{ $check['result'] === 'ok' ? 'selected' : '' }}>OK</option>
                        </select>
                    </div>
                @endforeach

                <div style="margin-bottom:5px;">
                    <label for="assigned_to">Assigned To</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "user1"</span>
                    </div>
                </div>
                <input type="text" id="assigned_to" name="assigned_to" value="{{ old('assigned_to') }}" required><br><br>

                <div class="actions">
                    <button type="submit" class="save-btn">Save</button>
                    <a href="{{ route('inspections.index') }}" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>