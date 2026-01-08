<x-layout>
    <x-slot:title>
        Add Document
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

        <!-- the document create form -->
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
                <input type="text" id="api_id" name="api_id" value="{{ old('api_id') }}" required><br>

                <div style="margin-bottom:5px;">
                    <label for="case_id">Case ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "case-000001"</span>
                    </div>
                </div>
                <input type="text" id="case_id" name="case_id" value="{{ old('case_id') }}" required><br>

                <label for="document">Document File</label>
                <input type="file" id="document" name="document" value="{{ old('document') }}" required><br>

                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="" disabled selected {{ old('category') === null ? 'selected' : '' }}>Select a category</option>
                    <option value="coo" {{ old('category') === 'coo' ? 'selected' : '' }}>COO</option>
                    <option value="invoice" {{ old('category') === 'invoice' ? 'selected' : '' }}>Invoice</option>
                    <option value="packing_list" {{ old('category') === 'packing_list' ? 'selected' : '' }}>Packing List</option>
                    <option value="cmr" {{ old('category') === 'cmr' ? 'selected' : '' }}>CMR</option>
                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                </select><br>

                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" min="0" value="{{ old('pages') }}" required><br>

                <div style="margin-bottom:5px;">
                    <label for="uploaded_by">Uploaded By</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "user1"</span>
                    </div>
                </div>
                <input type="text" id="uploaded_by" name="uploaded_by" value="{{ old('uploaded_by') }}" required><br><br>

                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>
</x-layout>
