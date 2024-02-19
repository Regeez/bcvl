@extends('layouts.app')

@section('content')
    <div class="container-fluid overflow-auto">
        <div class="row m-0">
            <div class="container pt-3 pb-5">
                <div class="row">
                    @foreach ($classes as $class)
                        <a class="col-md-4 mb-3 text-decoration-none" href="{{ route('class.show', ['id' => $class->id]) }}">
                            <div class="card" style="height:17em">
                                <div class="card-header class_head">
                                    {{-- Your header content here --}}
                                    <h5 class="card-title">{{ $class->subject }}</h5>
                                    <h6 class="card-subtitle mb-5"><small>{{ $class->yearsec }}</small></h6>
                                </div>
                                <div class="card-body d-flex align-items-end" style="height: 70%">
                                    {{-- Your body content here --}}
                                    <div class="w-100" style="background-color: #e3d9c9">
                                        @if (Auth::user()->role == 'Instructor')
                                            <form action="{{ route('class.destroy', ['id' => $class->id]) }}" method="POST"
                                                class="d-flex justify-content-end align-items-end h-100 p-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-1">
                                                    <i class="fa-solid fa-trash fa-lg text-secondary"
                                                        style="cursor: pointer"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('class')
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="card w-100" style="height: 100vh">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab">
                        <li class="nav-item text-center">
                            <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1">Announcements</a>
                        </li>
                        <li class="nav-item text-center" style="width:10em">
                            @if (Auth::user()->role == 'Instructor')
                                <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2">Students</a>
                            @else
                                <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2">Members</a>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">
                    <div class="tab-pane fade show active" id="tab1">
                        <!-- Content for Tab 1 -->
                        <div class="container mt-4">
                            <!-- Row for the Full Width Card -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <!-- Content of the first full-width card -->
                                        <div class="card-body class_head rounded p-4 b-3">
                                            @php
                                                // Assuming $selectedClass is a collection of Classroom models
                                                if ($selectedClass->count() > 0) {
                                                    $classroom = $selectedClass->first(); // Get the first item in the collection
                                                    $subjectValue = $classroom->subject;
                                                    $yearsecValue = $classroom->yearsec;
                                                    $classroomId = $classroom->id; // Get the id from the first item
                                                } else {
                                                    // Handle the case where no matching record was found
                                                    $subjectValue = 'No matching record found';
                                                    $yearsecValue = '';
                                                    $classroomId = ''; // Set the id to empty
                                                }
                                            @endphp

                                            <h2 class="card-title mt-4">{{ $subjectValue }}</h2>
                                            <p class="card-text">{{ $yearsecValue }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Row for the Post and View Cards -->
                            <div class="row mt-3">
                                @if (Auth::user()->role == 'Instructor')
                                    <div class="col-md-6">
                                        <!-- Post Card (45% Width) -->
                                        <div class="card" style="width: 100%;">
                                            <div class="card-body p-3">
                                                <form action="{{ route('announcement.store') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    {{-- postAnnouncement --}}
                                                    <input type="hidden" name="classroom_id" value="{{ $classroomId }}">
                                                    <div class="form-floating">
                                                        <textarea class="form-control mb-3" placeholder="Write your announcement here." name="announcement" id="textArea"
                                                            style="height: 10em;" required></textarea>
                                                        <label for="textArea">Write your announcement here.</label>
                                                    </div>

                                                    <!-- Display a temporary preview of the selected file -->
                                                    <div id="filePreviewContainer" class="card mb-3"
                                                        style="display: none; flex-direction: row; align-items: center;">
                                                        <img id="filePreview" class="file_preview rounded-start"
                                                            src="" alt="No image preview" height="60"
                                                            width="90">
                                                        <div id="fileInfo" class="fw-bold ps-2" style="text-align: start;">
                                                            <samp id="fileName"></samp>
                                                            <br>
                                                            <samp id="fileType"></samp>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Upload File Button (Bottom Left) -->
                                                        <div class="ms-3">
                                                            <i class="fa-solid fa-arrow-up-from-bracket fa-lg"
                                                                onclick="document.getElementById('fileInput').click()"></i>
                                                            <input type="file" id="fileInput" name="file_input"
                                                                class="d-none"
                                                                accept=".pdf, .doc, .docx, .jpeg, .png, .jpg">
                                                        </div>
                                                        <!-- Post Button (Bottom Right) -->
                                                        <button type="submit" class="btn btn-primary">Post</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- viewAnnouncement --}}
                                @if (Auth::user()->role == 'Instructor')
                                    <div class="card col-md-6 overflow-auto" style="max-height: 40vh">
                                    @else
                                        <div class="card col-md-12 overflow-auto" style="max-height: 40vh">
                                @endif

                                <!-- View Card (50% Width) -->
                                @if ($currentUrl !== 'home')
                                    @foreach ($classAnnouncement as $announcement)
                                        <div class="card mt-2 shadow">
                                            <div class="card-body p-3 d-flex justify-content-between">
                                                {{-- Download Announcement --}}
                                                <div class="content">
                                                    <h6 class="card-title">{{ $announcement->content }}</h6>
                                                    @if ($announcement->file_path)
                                                        <a href="{{ route('download', $announcement->id) }}"
                                                            class="btn btn-outline-secondary download p-1 text-nowrap overflow-hidden"
                                                            style="transition: background-color 0.3s ease; width:15vw">
                                                            {{ $announcement->file_name }}
                                                            <i class="fa-solid fa-download"></i>
                                                        </a>
                                                    @endif
                                                </div>

                                                {{-- Edit/Delete Announcement --}}
                                                @if (Auth::user()->role == 'Instructor')
                                                    <div style="cursor: default">
                                                        <i class="fa-solid fa-pen-to-square pe-2 text-secondary"
                                                            style="cursor: pointer"
                                                            onclick="showAnnouncementModal({{ $announcement->id }}, '{{ $announcement->content }}')"></i>
                                                        <form
                                                            action="{{ route('announcement.destroy', ['id' => $announcement->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-link p-0 text-danger"
                                                                id="delete-announcement-{{ $announcement->id }}"
                                                                data-announcement-id="{{ $announcement->id }}">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <form id="delete-announcement-form-{{ $announcement->id }}"
                                                    action="{{ route('announcement.destroy', ['id' => $announcement->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                {{-- if ($announcement->file_name)
                                                        <p class="card-text">
                                                            <a href="{ Storage::url($announcement->file_path) }}"
                                                                target="_blank">
                                                                { $announcement->file_name }}
                                                                ({ $announcement->file_type }})
                                                            </a>
                                                        </p>
                                                    @endif --}}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="tab2">
                    <!-- Content for Tab 2 -->
                    <div class="container mt-5 d-flex justify-content-center">
                        <!-- Card with Student List -->
                        <div class="card" style="width: 60vw;">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title">Student List</h5>
                                @if (Auth::user()->role == 'Instructor')
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addStudentModal">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                @endif
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @if ($currentUrl !== 'home')
                                        @foreach ($classroom->users as $user)
                                            <li class="list-group-item d-flex justify-content-between">
                                                {{ $user->name }}
                                                @if (Auth::user()->role == 'Instructor')
                                                    <h6 onclick="removeStudent({{ $classroom->id }}, {{ $user->id }})"
                                                        class="text-danger" style="cursor: pointer">Remove</label>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Add Student Modal -->
                        <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog"
                            aria-labelledby="addStudentModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content p-2">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                                        <button type="button" class="close btn btn-outline-secondary"
                                            data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <input type="text" id="search-input" oninput="search(this.value)"
                                        class="form-control mt-2" placeholder="Type to search...">
                                    <hr class="text-secondary mt-2">
                                    <div class="modal-body " style="max-height: 60vh; overflow-y: auto;">
                                        <!-- Search input for adding a new student -->
                                        <div class="form-group">
                                            <div id="results" class="search-results"></div>
                                        </div>
                                        <!-- Additional form elements can be added here as needed -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @if (session('success'))
        <script>
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-2',
                    cancelButton: 'btn btn-danger mx-2'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: '{{ session('title') }}',
                text: '{{ session('success') }}',
                icon: 'success'
            });
        </script>
    @endif

    <dialog id="editAnnouncement" class="announcement_modal overflow-hidden p-5 rounded border border-0">
        <form action="{{ route('announcement.update', ['id' => Auth::id()]) }}" method="post">
            @csrf
            @method('PUT')
            @if (auth()->check())
                <input type="hidden" name="announcementId" id="announcementId" value="">
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Leave a comment here" name="content" id="floatingTextarea2"
                        style="height: 9em"></textarea>
                    <label for="floatingTextarea2">Editing Announcement</label>
                </div>
                <div class="options">
                    <button class="btn btn-outline-secondary rounded" id="close-button"
                        onclick="event.preventDefault(); closeAnnouncementModal()">Cancel</button>
                    <input type="submit" class="btn btn-primary rounded" value="Save" />
                </div>
            @else
                <p>Your session has expired due to inactivity. Please log in again to continue.</p>
            @endif
        </form>
    </dialog>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/b87fe33100.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function showAnnouncementModal(id, content) {
            document.getElementById('announcementId').value = id;
            const dialog = document.getElementById('editAnnouncement');
            const textarea = dialog.querySelector('textarea');

            textarea.value = content;
            dialog.showModal();
        }

        function closeAnnouncementModal() {
            document.getElementById('editAnnouncement').close();
        }

        // window.onload = function() {
        //     const activeTab = localStorage.getItem('activeTab');
        //     if (activeTab) {
        //         const tab = document.querySelector(`#myTab a[href="#${activeTab}"]`);
        //         if (tab) {
        //             const tabLink = new bootstrap.Tab(tab);
        //             tabLink.show();
        //         }
        //     }
        // };

        function search(query) {
            if (query.length < 2) { // Only search if the query is at least 3 characters long
                return;
            }

            fetch('/search?q=' + query)
                .then(response => response.json())
                .then(data => {
                    // Display the search results
                    const resultsContainer = document.getElementById('results');

                    if (data.length > 0) {
                        let resultsHtml = '<ul>';
                        data.forEach(result => {
                            resultsHtml += '<li class="d-flex justify-content-between align-items-center">';
                            resultsHtml += '<span>' + result.name + '</span>';
                            resultsHtml +=
                                '<i class="fa-duotone fa-plus fa-2xl cursor-pointer" onclick="addStudent(' +
                                result.id + ')"></i>';
                            resultsHtml += '</li>';
                        });

                        resultsHtml += '</ul>';

                        resultsContainer.innerHTML = resultsHtml;
                    } else {
                        resultsContainer.innerHTML = '<p>No results found.</p>';
                    }
                });
        }

        function addStudent(studentId) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-outline-secondary me-3"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Add student to this class?',
                showCancelButton: true,
                confirmButtonText: 'Yes, Confirm!',

                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let classroomId = {{ $currentUrl }}; // Replace this with the actual ID of the classroom
                    fetch('/class/' + classroomId + '/' + studentId, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            Swal.fire({
                                title: 'Success!',
                                // text: data.message,
                                text: 'Added successfuly',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: 'green'
                            }).then((result) => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to add',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }

        function removeStudent(classroomId, studentId) {
            Swal.fire({
                title: 'Remove student?',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove!',
                confirmButtonColor: '#d33',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/class/' + classroomId + '/' + studentId, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            Swal.fire({
                                title: 'Success!',
                                // text: data.message,
                                text: 'Removed successfuly',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: 'green'
                            }).then((result) => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to remove',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }

        function removeAnnouncement(classroomId, announcementId) {
            if (confirm('Are you sure you want to remove Announcement?')) {
                fetch('/class/' + classroomId + '/' + announcementId, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle file input change event
            document.getElementById('fileInput').addEventListener('change', handleFileSelect);

            function handleFileSelect(event) {
                const fileInput = event.target;
                const filePreviewContainer = document.getElementById('filePreviewContainer');
                const filePreview = document.getElementById('filePreview');
                const fileInfo = document.getElementById('fileInfo');
                const fileName = document.getElementById('fileName');
                const fileType = document.getElementById('fileType');

                if (fileInput.files.length > 0) {
                    const selectedFile = fileInput.files[0];

                    // Display the file preview container
                    filePreviewContainer.style.display = 'flex';

                    // Display the file information in the preview
                    fileName.textContent = selectedFile.name;
                    fileType.textContent = selectedFile.type;

                    // Display an image preview for image files (you can customize this part)
                    if (selectedFile.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            filePreview.src = e.target.result;
                        };
                        reader.readAsDataURL(selectedFile);
                    } else {
                        // For non-image files, you can customize how you want to display them
                        filePreview.src = ''; // Clear the image preview
                    }
                } else {
                    // Hide the file preview container if no file is selected
                    filePreviewContainer.style.display = 'none';

                    // Clear the file information in the preview
                    fileName.textContent = '';
                    fileType.textContent = '';

                    // Clear the image preview
                    filePreview.src = '';

                    // Clear the hidden input value for form submission
                    document.getElementById('selectedFile').value = '';
                }
            }
        });

        document.querySelectorAll('button[id^="delete-announcement-"]').forEach(button => {
            button.addEventListener('click', () => {
                const announcementId = button.getAttribute('data-announcement-id');
                Swal.fire({
                    title: 'Delete Announcement?',
                    text: 'You will not be able to recover this announcement!',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-announcement-form-${announcementId}`)
                            .submit();

                    }
                });
            });
        });
    </script>
@endsection
