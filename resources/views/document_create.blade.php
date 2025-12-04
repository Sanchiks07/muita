<x-layout>
    <x-slot:title>
        Add New Document
    </x-slot:title>

    <div class="container">
        <form merhod="POST" action="{{ route('documents.store') }}">
            @csrf

            <label for="api_id">Document ID</label>
            <input type="text" id="api_id" name="api_id" required>

            <label for="case_id">Case ID</label>
            <input type="text" id="case_id" name="case_id" required>

            <label for="filename">Filename</label>
            <input type="text" id="filename" name="filename" required>

            <label for="mime_type">MIME Type</label>
            <input type="text" id="mime_type" name="mime_type" required>

            <label for="category">Category</label>
            <input type="text" id="category" name="category" required>

            <label for="pages">Pages</label>
            <input type="number" id="pages" name="pages" required>

            <label for="uploaded_by">Uploaded By</label>
            <input type="text" id="uploaded_by" name="uploaded_by" required>

            <button type="submit">Save</button>
        <form>
    </div>
</x-layout>