<x-layout>
    <x-slot:title>
        Edit Document
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

        <!-- the document edit form -->
        <div class="create-container">
            <h2>Edit Document</h2><br>

            <form method="POST" action="{{ route('documents.update', $document->api_id) }}" class="create-form document" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <label for="api_id">Document ID</label>
                <input type="text" id="api_id" name="api_id" value="{{ $document->api_id }}" style="color:#ccc;" disabled><br>

                <div style="margin-bottom:5px;">
                    <label for="case_id">Case ID</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "case-000001"</span>
                    </div>
                </div>
                <input type="text" id="case_id" name="case_id" value="{{ $document->case_id }}" required><br>

                <div style="margin-bottom:5px;">
                    <label for="document">Document File</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">Upload the same document file if you aren't changing it.</span>
                    </div>
                </div>
                <input type="file" id="document" name="document"><br>

                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="coo" {{ $document->category === 'coo' ? 'selected' : '' }}>COO</option>
                    <option value="invoice" {{ $document->category === 'invoice' ? 'selected' : '' }}>Invoice</option>
                    <option value="packing_list" {{ $document->category === 'packing_list' ? 'selected' : '' }}>Packing List</option>
                    <option value="cmr" {{ $document->category === 'cmr' ? 'selected' : '' }}>CMR</option>
                    <option value="other" {{ $document->category === 'other' ? 'selected' : '' }}>Other</option>
                </select><br>

                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" value="{{ $document->pages }}" min="0" required><br>

                <div style="margin-bottom:5px;">
                    <label for="uploaded_by">Uploaded By</label>
                    <div class="tooltip">
                        ⓘ
                        <span class="tooltip-text">e.g. "user1"</span>
                    </div>
                </div>
                <input type="text" id="uploaded_by" name="uploaded_by" value="{{ $document->uploaded_by }}" required><br><br>

                <div class="actions">
                    <button type="submit" class="save-btn">Save</button>
                    <a href="{{ route('dashboard') }}" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
