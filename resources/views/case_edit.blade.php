<x-layout>
    <x-slot:title>
        Edit Case
    </x-slot:title>

    <div class="container">
        <!-- error messages -->
        @if ($errors->any())
            <div class="error-messages">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- the case edit -->
        <div class="create-container">
            <h2>Edit {{ $case->api_id }}</h2><br>

            <form method="POST" action="{{ route('cases.update', $case->api_id) }}" class="create-form case">
                @csrf
                @method('PUT')

                <div class="input-grid">
                    <div class="input-group-1">
                        <div class="input-flex">
                            <label for="api_id">Case ID</label>
                            <input type="text" id="api_id" name="api_id" value="{{ $case->api_id }}" style="color:#ccc;" disabled><br>

                            <div style="margin-bottom:5px;">
                                <label for="external_ref">External Reference</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">External reference number.<br>e.g. "CM-2025-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="external_ref" name="external_ref" value="{{ $case->external_ref }}" required><br>

                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="new" {{ $case->status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="screening" {{ $case->status === 'screening' ? 'selected' : '' }}>Screening</option>
                                <option value="in_inspection" {{ $case->status === 'in_inspection' ? 'selected' : '' }}>In Inspection</option>
                                <option value="on_hold" {{ $case->status === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                <option value="released" {{ $case->status === 'released' ? 'selected' : '' }}>Released</option>
                                <option value="closed" {{ $case->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select><br>

                            <label for="priority">Priority</label>
                            <select id="priority" name="priority" required>
                                <option value="low" {{ $case->priority === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $case->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $case->priority === 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ $case->priority === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select><br>

                            <label for="arrival_ts">Arrival Date & Time</label>
                            <input type="datetime-local" id="arrival_ts" name="arrival_ts" value="{{ str_replace(' ', 'T', substr($case->arrival_ts, 0, 16)) }}" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="checkpoint_id">Checkpoint ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">e.g. "chk-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="checkpoint_id" name="checkpoint_id" value="{{ $case->checkpoint_id }}" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="origin_country">Origin Country</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">ISO alpha-2 code.<br>e.g. LV, US</span>
                                </div>
                            </div>
                            <input type="text" id="origin_country" name="origin_country" value="{{ $case->origin_country }}" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="destination_country">Destination Country</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">ISO alpha-2 code.<br>e.g. LV, US</span>
                                </div>
                            </div>
                            <input type="text" id="destination_country" name="destination_country" value="{{ $case->destination_country }}" required>
                        </div>
                    </div>

                    <div class="input-group-2">
                        <div class="input-flex">
                            <div style="margin-bottom:5px;">
                                <label for="risk_flags">Risk Flags (JSON format)</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">e.g. ["flag1", "flag2"]</span>
                                </div>
                            </div>
                            <textarea id="risk_flags" name="risk_flags">{{ $case->risk_flags }}</textarea><br>

                            <div style="margin-bottom:5px;">
                                <label for="declarant_id">Declarant ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">Company declaring the goods.<br>e.g. "pty-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="declarant_id" name="declarant_id" value="{{ $case->declarant_id }}" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="consignee_id">Consignee ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">Goods recipient company.<br>e.g. "pty-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="consignee_id" name="consignee_id" value="{{ $case->consignee_id }}" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="vehicle_id">Vehicle ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">e.g. "veh-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="vehicle_id" name="vehicle_id" value="{{ $case->vehicle_id }}" required>
                        </div>
                    </div>

                    <div class="actions">
                        <button type="submit" class="save-btn">Save</button>
                        <a href="{{ route('dashboard') }}" class="cancel-btn">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
