@section('class')
    <div class="container-fluid overflow-auto p-0">
        <div class="container h-100">
            <div class="card h-100">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active fw-medium text-secondary" id="tab1" data-toggle="tab"
                                href="#content1">Classworks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium text-secondary" id="tab2" data-toggle="tab"
                                href="#content2">Students</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content h-100">
                    <div class="tab-pane fade show active h-100" id="content1">
                        <!-- Content for Tab 1 -->
                        <div class="row gx-3 m-0 p-3 lh-1">
                            <div class="class_head col-md-12 rounded p-4 pb-3 shadow">
                                @php
                                    // Assuming $selectedClass is a collection of Classroom models
                                    if ($selectedClass->count() > 0) {
                                        $classroom = $selectedClass->first(); // Get the first item in the collection
                                        $subjectValue = $classroom->subject;
                                        $yearsecValue = $classroom->yearsec;
                                    } else {
                                        // Handle the case where no matching record was found
                                        $subjectValue = 'No matching record found';
                                        $yearsecValue = '';
                                    }
                                @endphp

                                <h2 class="card-title mt-4">{{ $subjectValue }}</h2>
                                <p class="card-text">{{ $yearsecValue }}</p>
                            </div>

                            {{-- Post Announcement --}}
                            <div class="card col-md-6 rounded mt-3 p-3 shadow">
                                <div class="form">
                                    <div class="form-floating">
                                        <textarea class="form-control mb-3" placeholder="Write your announcement here." id="floatingTextarea2"
                                            style="height: 250px;"></textarea>
                                        <label for="floatingTextarea2">Write your announcement here.</label>
                                    </div>

                                    <!-- Display a temporary preview of the selected file -->
                                    <div id="filePreviewContainer" class="card mb-3"
                                        style="display: none; flex-direction: row; align-items: center;">
                                        <img id="filePreview" class="file_preview rounded-start" src=""
                                            height="60" width="90">
                                        <div id="fileInfo" class="fw-bold ps-2" style="text-align: start;">
                                            <samp id="fileName"></samp>
                                            <br>
                                            <samp id="fileType"></samp>
                                        </div>
                                    </div>

                                    <!-- Grouped attachment for file input and link input -->
                                    <div class="d-flex justify-content-between align-items-center" style="width:100%">

                                        <!-- File input section -->
                                        <div class="d-flex align-items-center">
                                            <div class="ms-3">
                                                <i class="fa-solid fa-arrow-up-from-bracket fa-lg"
                                                    onclick="document.getElementById('fileInput').click()"></i>
                                                <input type="file" id="fileInput"
                                                    accept=".pdf, .doc, .docx, .jpeg, .png, .jpg" style="display: none;">
                                                <!-- Hidden input for the selected file -->
                                                <input type="hidden" id="selectedFile" name="selectedFile" value="">
                                            </div>
                                        </div>

                                        <!-- Post button -->
                                        <input type="submit" class="btn btn-primary ml-auto" value="Post"
                                            style="width: 15vh">

                                    </div>
                                </div>
                            </div>
                            {{-- Announcements --}}
                            <div class="card container-fluid overflow-auto col-md-6 rounded shadow mb-5 mt-3 p-3"
                                style="height: 30em;">
                                @foreach ($classes as $class)
                                    <a class="col-md-12 mb-3 text-decoration-none"
                                        href="{{ route('class.show', ['id' => $class->id]) }}">
                                        <div class="card" style="height:5em">
                                            {{-- Your header content here --}}
                                            <div class="row m-0 align-items-center h-100">
                                                <div class="col-md-11 ">
                                                    <h5 class="card-title">{{ $class->subject }}</h5>
                                                    <h6 class="card-subtitle"><small>{{ $class->yearsec }}</small></h6>
                                                </div>
                                                <div class="col-md-1 d-flex flex-column align-items-center">
                                                    <i class="fa-regular fa-pen-to-square fa-lg p-3 "></i>
                                                    <i class="fa-regular fa-trash-can fa-lg p-3 "></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade h-100" id="content2">
                        <!-- Content for Tab 2 -->
                        <h5 class="card-title">Tab 2 Content</h5>
                        <p class="card-text">This is the content for Tab 2.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const fileInput = document.getElementById('fileInput');
        const filePreviewContainer = document.getElementById('filePreviewContainer');
        const filePreview = document.getElementById('filePreview');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileType = document.getElementById('fileType');

        fileInput.addEventListener('change', function(event) {
            const file = fileInput.files[0];

            if (file) {
                // Display a preview of the selected file
                const reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Display file information
                filePreviewContainer.style.display = 'flex';
                fileName.textContent = file.name;
                fileType.textContent = file.type;

                // Set the value of the hidden input for the selected file
                document.getElementById('selectedFile').value = file.name;

                // Hide the link input when a file is selected
                linkInput.style.display = 'none';
            } else {
                // Reset the preview and hide file information if no file is selected
                filePreview.src = '';
                filePreviewContainer.style.display = 'none';
                fileName.textContent = ''; // Clear the content
                fileType.textContent = ''; // Clear the content

                // Reset the value of the hidden input for the selected file
                document.getElementById('selectedFile').value = '';
            }
        });

        // Additional script for updating the selected link
        linkInput.addEventListener('input', function() {
            // Set the value of the hidden input for the selected link
            document.getElementById('selectedLink').value = linkInput.value;
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
