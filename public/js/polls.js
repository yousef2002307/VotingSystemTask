// JavaScript for poll management

document.addEventListener('DOMContentLoaded', function () {
    const pollsList = document.getElementById('polls-list');
    const addPollModal = new bootstrap.Modal(document.getElementById('addPollModal'));
    const editPollModal = new bootstrap.Modal(document.getElementById('editPollModal'));

    // Function to fetch and display polls
    async function fetchAndDisplayPolls() {
        try {
            const response = await fetch('/api/v1/polls');
            if (!response.ok) {
                throw new Error('Failed to fetch polls');
            }
            const polls = await response.json();

            pollsList.innerHTML = ''; // Clear existing polls

            if (polls.length === 0) {
                pollsList.innerHTML = '<p>No polls found. Create one!</p>';
                return;
            }

            polls.forEach(poll => {
                const pollElement = document.createElement('div');
                pollElement.classList.add('card', 'mb-3');
                pollElement.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${poll.question}</h5>
                        <ul class="list-group list-group-flush">
                            ${poll.choices.map(choice => `<li class="list-group-item">${choice.value} (${choice.votes_count || 0} votes)</li>`).join('')}
                        </ul>
                        <button class="btn btn-sm btn-secondary mt-2 edit-poll-btn" data-id="${poll.id}">Edit</button>
                        <button class="btn btn-sm btn-danger mt-2 delete-poll-btn" data-id="${poll.id}">Delete</button>
                    </div>
                `;
                pollsList.appendChild(pollElement);
            });

            // Add event listeners for edit and delete buttons
            document.querySelectorAll('.edit-poll-btn').forEach(button => {
                button.addEventListener('click', handleEditPoll);
            });

            document.querySelectorAll('.delete-poll-btn').forEach(button => {
                button.addEventListener('click', handleDeletePoll);
            });

        } catch (error) {
            console.error('Error fetching polls:', error);
            pollsList.innerHTML = '<p class="text-danger">Failed to load polls.</p>';
        }
    }

    // Handle Add Poll Form Submission
    document.getElementById('addPollForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const question = document.getElementById('pollQuestion').value;
        const choices = [];
        document.querySelectorAll('#choicesContainer input[type="text"]').forEach(input => {
            if (input.value.trim() !== '') {
                choices.push(input.value.trim());
            }
        });

        if (choices.length < 2) {
            alert('Please add at least two choices.');
            return;
        }

        try {
            const response = await fetch('/api/v1/polls', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Assuming you have a CSRF token meta tag
                },
                body: JSON.stringify({ question, choices })
            });

            if (!response.ok) {
                throw new Error('Failed to add poll');
            }

            // Clear form and close modal
            this.reset();
            addPollModal.hide();

            // Refresh poll list
            fetchAndDisplayPolls();

        } catch (error) {
            console.error('Error adding poll:', error);
            alert('Failed to add poll. Please try again.');
        }
    });

    // Handle Add Another Choice Button in Add Modal
    document.getElementById('addChoiceBtn').addEventListener('click', function () {
        const choicesContainer = document.getElementById('choicesContainer');
        const choiceCount = choicesContainer.querySelectorAll('input[type="text"]').length + 1;
        const newChoiceInput = document.createElement('div');
        newChoiceInput.classList.add('mb-3');
        newChoiceInput.innerHTML = `
            <label for="choice${choiceCount}" class="form-label">Choice ${choiceCount}</label>
            <input type="text" class="form-control" id="choice${choiceCount}" required>
        `;
        choicesContainer.appendChild(newChoiceInput);
    });

    // Handle Edit Poll Button Click
    async function handleEditPoll(e) {
        const pollId = e.target.dataset.id;
        try {
            const response = await fetch(`/api/v1/polls/${pollId}`);
            if (!response.ok) {
                throw new Error('Failed to fetch poll for editing');
            }
            const poll = await response.json();

            // Populate edit modal
            document.getElementById('editPollId').value = poll.id;
            document.getElementById('editPollQuestion').value = poll.question;

            const editChoicesContainer = document.getElementById('editChoicesContainer');
            editChoicesContainer.innerHTML = ''; // Clear existing choices

            poll.choices.forEach((choice, index) => {
                 const newChoiceInput = document.createElement('div');
                newChoiceInput.classList.add('mb-3');
                newChoiceInput.innerHTML = `
                    <label for="editChoice${index + 1}" class="form-label">Choice ${index + 1}</label>
                    <input type="text" class="form-control" id="editChoice${index + 1}" value="${choice.value}" required>
                `;
                 editChoicesContainer.appendChild(newChoiceInput);
            });
             // Ensure at least two choice fields are available for editing
            while (editChoicesContainer.querySelectorAll('input[type="text"]').length < 2) {
                 const choiceCount = editChoicesContainer.querySelectorAll('input[type="text"]').length + 1;
                  const newChoiceInput = document.createElement('div');
                newChoiceInput.classList.add('mb-3');
                newChoiceInput.innerHTML = `
                    <label for="editChoice${choiceCount}" class="form-label">Choice ${choiceCount}</label>
                    <input type="text" class="form-control" id="editChoice${choiceCount}" required>
                `;
                 editChoicesContainer.appendChild(newChoiceInput);
            }

            editPollModal.show();

        } catch (error) {
            console.error('Error fetching poll for editing:', error);
            alert('Failed to load poll for editing.');
        }
    }

    // Handle Add Another Choice Button in Edit Modal
    document.getElementById('addEditChoiceBtn').addEventListener('click', function () {
        const editChoicesContainer = document.getElementById('editChoicesContainer');
        const choiceCount = editChoicesContainer.querySelectorAll('input[type="text"]').length + 1;
        const newChoiceInput = document.createElement('div');
        newChoiceInput.classList.add('mb-3');
        newChoiceInput.innerHTML = `
            <label for="editChoice${choiceCount}" class="form-label">Choice ${choiceCount}</label>
            <input type="text" class="form-control" id="editChoice${choiceCount}" required>
        `;
        editChoicesContainer.appendChild(newChoiceInput);
    });


    // Handle Edit Poll Form Submission
     document.getElementById('editPollForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const pollId = document.getElementById('editPollId').value;
        const question = document.getElementById('editPollQuestion').value;
        const choices = [];
        document.querySelectorAll('#editChoicesContainer input[type="text"]').forEach(input => {
             if (input.value.trim() !== '') {
                choices.push(input.value.trim());
            }
        });

         if (choices.length < 2) {
            alert('Please add at least two choices.');
            return;
        }

        try {
            const response = await fetch(`/api/v1/polls/${pollId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Assuming you have a CSRF token meta tag
                },
                body: JSON.stringify({ question, choices })
            });

            if (!response.ok) {
                throw new Error('Failed to update poll');
            }

            // Close modal
            editPollModal.hide();

            // Refresh poll list
            fetchAndDisplayPolls();

        } catch (error) {
            console.error('Error updating poll:', error);
            alert('Failed to update poll. Please try again.');
        }
    });

    // Handle Delete Poll Button Click
    async function handleDeletePoll(e) {
        const pollId = e.target.dataset.id;
        if (confirm('Are you sure you want to delete this poll?')) {
            try {
                const response = await fetch(`/api/v1/polls/${pollId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Assuming you have a CSRF token meta tag
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to delete poll');
                }

                // Refresh poll list
                fetchAndDisplayPolls();

            } catch (error) {
                console.error('Error deleting poll:', error);
                alert('Failed to delete poll. Please try again.');
            }
        }
    }


    // Initial fetch and display polls when the page loads
    fetchAndDisplayPolls();
}); 