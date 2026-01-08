<x-layout>
    <x-slot:title>
        Edit Inspection
    </x-slot:title>

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

        <!-- the inspection edit -->
        <div class="create-container">
            <form method="POST" action="{{ route('inspections.update', $inspection->api_id) }}" class="create-form inspection">
                @method('PUT')
                @csrf

                <label for="api_id">Inspection ID</label>
                <input type="text" id="api_id" name="api_id" value="{{ $inspection->api_id }}" style="color:#ccc;" disabled><br>

                <div style="margin-bottom:5px;">
                    <label for="case_id">Case ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "case-000001"</span>
                    </div>
                </div>
                <input type="text" id="case_id" name="case_id" value="{{ $inspection->case_id }}" required><br>

                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="document" {{ $inspection->type === 'document' ? 'selected' : '' }}>Document</option>
                    <option value="xray" {{ $inspection->type === 'xray' ? 'selected' : '' }}>X-ray</option>
                    <option value="physical" {{ $inspection->type === 'physical' ? 'selected' : '' }}>Physical</option>
                </select><br>

                <label for="requested_by">Requested By</label>
                <select id="requested_by" name="requested_by" required>
                    <option value="inspector" {{ $inspection->requested_by === 'inspector' ? 'selected' : '' }}>Inspector</option>
                    <option value="risk-engine" {{ $inspection->requested_by === 'risk-engine' ? 'selected' : '' }}>Risk Engine</option>
                    <option value="system" {{ $inspection->requested_by === 'system' ? 'selected' : '' }}>System</option>
                </select><br>

                <label for="start_ts">Start Time</label>
                <input type="datetime-local" id="start_ts" name="start_ts" value="{{ str_replace(' ', 'T', substr($inspection->start_ts, 0, 16)) }}" required><br>

                <div style="margin-bottom:5px;">
                    <label for="location">Location</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "RIX-CP-01 | Box 1"</span>
                    </div>
                </div>
                <input type="text" id="location" name="location" value="{{ $inspection->location }}"><br>

                <p style="margin-bottom:5px;">Checks</p>
                @php
                    $checks = json_decode($inspection->checks, true) ?? [];
                @endphp

                @foreach ($checks as $index => $check)
                    <div style="margin-bottom:10px; display:flex; flex-direction: row; align-items:center; gap:10px;">
                        <label for="checks">{{ $check['name'] }}</label>
                        <input type="hidden" name="checks[{{ $index }}][name]" value="{{ $check['name'] }}">

                        <select name="checks[{{ $index }}][result]" id="checks" style="width:30%;" required>
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
                <input type="text" id="assigned_to" name="assigned_to" value="{{ $inspection->assigned_to }}"><br><br>

                <div class="actions">
                    <button type="submit" class="save-btn">Save</button>
                    <a href="{{ route('inspections.index') }}" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>