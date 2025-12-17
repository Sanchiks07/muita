<x-layout>
    <x-slot:title>
        Add Document
    </x-slot:title>

    <div class="container">
        <div class="document-container">
            <h2>Add Document</h2><br>
        
            <form method="POST" action="{{ route('documents.store') }}" class="document-form">
                @csrf

                <label for="api_id">Document ID</label>
                <input type="text" id="api_id" name="api_id" required><br>

                <label for="case_id">Case ID</label>
                <input type="text" id="case_id" name="case_id" required><br>

                <label for="filename">Filename</label>
                <input type="text" id="filename" name="filename" required><br>

                <label for="mime_type">MIME Type</label>
                <input type="text" id="mime_type" name="mime_type" required><br>

                <label for="category">Category</label>
                <input type="text" id="category" name="category" required><br>

                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" required><br>

                <label for="uploaded_by">Uploaded By</label>
                <input type="text" id="uploaded_by" name="uploaded_by" required><br><br>

                <button type="submit" class="save-btn">Save</button>
            <form>
        </div>
    </div>
</x-layout>