<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Poll Management</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ secure_asset('css/polls.css') }}">
</head>
<body>
    <div class="container mt-4">
        <h1>Poll Management</h1>

        <!-- Poll list will be loaded here by JavaScript -->
        <div id="polls-list">
            Loading polls...
        </div>

        <!-- Button to add a new poll -->
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addPollModal">Add New Poll</button>

        <!-- Add Poll Modal -->
        <div class="modal fade" id="addPollModal" tabindex="-1" aria-labelledby="addPollModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPollModalLabel">Add New Poll</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addPollForm">
                            <div class="mb-3">
                                <label for="pollQuestion" class="form-label">Poll Question</label>
                                <input type="text" class="form-control" id="pollQuestion" required>
                            </div>
                            <div id="choicesContainer">
                                <div class="mb-3">
                                    <label for="choice1" class="form-label">Choice 1</label>
                                    <input type="text" class="form-control" id="choice1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="choice2" class="form-label">Choice 2</label>
                                    <input type="text" class="form-control" id="choice2" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="addChoiceBtn">Add Another Choice</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="addPollForm" class="btn btn-primary">Save Poll</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Poll Modal -->
         <div class="modal fade" id="editPollModal" tabindex="-1" aria-labelledby="editPollModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPollModalLabel">Edit Poll</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPollForm">
                             <input type="hidden" id="editPollId">
                            <div class="mb-3">
                                <label for="editPollQuestion" class="form-label">Poll Question</label>
                                <input type="text" class="form-control" id="editPollQuestion" required>
                            </div>
                             <div id="editChoicesContainer">

                            </div>
                             <button type="button" class="btn btn-secondary" id="addEditChoiceBtn">Add Another Choice</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="editPollForm" class="btn btn-primary">Update Poll</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS CDN (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ secure_asset('js/polls.js') }}"></script>
</body>
</html> 