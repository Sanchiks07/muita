<x-layout>
    <x-slot:title>
        Add Document
    </x-slot:title>

    <div class="container">
        <div class="create-container">
            <h2>Add Document</h2><br>

            <form method="POST" action="{{ route('documents.store') }}" class="create-form document" enctype="multipart/form-data">
                @csrf

                <div style="margin-bottom:5px;">
                    <label for="api_id">Document ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "doc-000001"</span>
                    </div>
                </div>
                <input type="text" id="api_id" name="api_id" required><br>

                <div style="margin-bottom:5px;">
                    <label for="case_id">Case ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "case-000001"</span>
                    </div>
                </div>
                <input type="text" id="case_id" name="case_id" required><br>

                <label for="document">Document File</label>
                <input type="file" id="document" name="document" required><br>

                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="coo">COO</option>
                    <option value="invoice">Invoice</option>
                    <option value="packing_list">Packing List</option>
                    <option value="cmr">CMR</option>
                    <option value="other">Other</option>
                </select><br>

                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" min="0" required><br>

                <div style="margin-bottom:5px;">
                    <label for="uploaded_by">Uploaded By</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "user1"</span>
                    </div>
                </div>
                <input type="text" id="uploaded_by" name="uploaded_by" required><br><br>

                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>
</x-layout>
