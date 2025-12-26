<x-layout>
    <x-slot:title>
        Case Register
    </x-slot:title>

    <div class="container">
        <div class="create-container">
            <h2>Case Register</h2><br>

            <form method="POST" action="{{ route('cases.store') }}" class="create-form case">
                @csrf

                <div class="input-grid">
                    <div class="input-group-1">
                        <div class="input-flex">
                            <div style="margin-bottom:5px;">
                                <label for="api_id">Case ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">e.g. "case-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="api_id" name="api_id" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="external_ref">External Reference</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">External reference number.</span>
                                </div>
                            </div>
                            <input type="text" id="external_ref" name="external_ref" required><br>

                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="" disabled selected>Select the status</option>
                                <option value="new">New</option>
                                <option value="screening">Screening</option>
                                <option value="in_inspection">In Inspection</option>
                                <option value="on_hold">On Hold</option>
                                <option value="released">Released</option>
                                <option value="closed">Closed</option>
                            </select><br>

                            <label for="priority">Priority</label>
                            <select id="priority" name="priority" required>
                                <option value="" disabled selected>Select the priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="critical">Critical</option>
                            </select><br>

                            <div style="margin-bottom:5px;">
                                <label for="arrival_ts">Arrival Date & Time</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">e.g. "2025-11-18 10:30"</span>
                                </div>
                            </div>
                            <input type="datetime-local" id="arrival_ts" name="arrival_ts" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="checkpoint_id">Checkpoint ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">e.g. "RIX-CP-01"</span>
                                </div>
                            </div>
                            <input type="text" id="checkpoint_id" name="checkpoint_id" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="origin_country">Origin Country</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">ISO alpha-2 code<br>e.g. LV, US</span>
                                </div>
                            </div>
                            <input type="text" id="origin_country" name="origin_country" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="destination_country">Destination Country</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">ISO alpha-2 code<br>e.g. LV, US</span>
                                </div>
                            </div>
                            <input type="text" id="destination_country" name="destination_country" required>
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
                            <textarea id="risk_flags" name="risk_flags" placeholder="[]"></textarea><br>

                            <div style="margin-bottom:5px;">
                                <label for="declarant_id">Declarant ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">Company declaring the goods.<br>e.g. "pty-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="declarant_id" name="declarant_id" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="consignee_id">Consignee ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">Goods recipient company.<br>e.g. "pty-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="consignee_id" name="consignee_id" required><br>

                            <div style="margin-bottom:5px;">
                                <label for="vehicle_id">Vehicle ID</label>
                                <div class="tooltip">
                                    ⓘ
                                    <span class="tooltip-text">e.g. "veh-000001"</span>
                                </div>
                            </div>
                            <input type="text" id="vehicle_id" name="vehicle_id" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="register-btn">Register</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
