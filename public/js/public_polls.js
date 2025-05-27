// JavaScript for public poll voting

document.addEventListener('DOMContentLoaded', function () {
    const publicPollsList = document.getElementById('public-polls-list');

    // Function to fetch and display public polls
    async function fetchAndDisplayPublicPolls() {
        try {
            const response = await fetch('/api/v1/public-polls');
            if (!response.ok) {
                throw new Error('Failed to fetch public polls');
            }
            const polls = await response.json();

            publicPollsList.innerHTML = ''; // Clear existing polls

            if (polls.length === 0) {
                publicPollsList.innerHTML = '<p>No other polls found at the moment.</p>';
                return;
            }

            polls.forEach(poll => {
                const pollElement = document.createElement('div');
                pollElement.classList.add('card', 'mb-3', 'poll-card'); // Added poll-card class for potential styling
                pollElement.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${poll.question}</h5>
                        <ul class="list-group list-group-flush">
                            ${poll.choices.map(choice => `
                                <li class="list-group-item">
                                    <div class="form-check">
                                        <input class="form-check-input vote-radio" type="radio" name="vote-${poll.id}" id="choice-${choice.id}" value="${choice.id}" data-poll-id="${poll.id}">
                                        <label class="form-check-label" for="choice-${choice.id}">
                                            ${choice.value} (${choice.votes_count || 0} votes)
                                        </label>
                                    </div>
                                </li>
                            `).join('')}
                        </ul>
                        <button class="btn btn-primary mt-3 vote-btn" data-poll-id="${poll.id}" disabled>Vote</button>
                        <div id="vote-status-${poll.id}" class="mt-2"></div>
                    </div>
                `;
                publicPollsList.appendChild(pollElement);
            });

            // Add event listeners for radio buttons and vote buttons
            document.querySelectorAll('.vote-radio').forEach(radio => {
                radio.addEventListener('change', handleRadioChange);
            });

            document.querySelectorAll('.vote-btn').forEach(button => {
                button.addEventListener('click', handleVote);
            });

        } catch (error) {
            console.error('Error fetching public polls:', error);
            publicPollsList.innerHTML = '<p class="text-danger">Failed to load public polls.</p>';
        }
    }

    // Enable vote button when a choice is selected
    function handleRadioChange(e) {
        const pollId = e.target.dataset.pollId;
        const voteButton = document.querySelector(`.vote-btn[data-poll-id="${pollId}"]`);
        if (voteButton) {
            voteButton.disabled = false;
        }
    }

    // Handle Vote Button Click
    async function handleVote(e) {
        const pollId = e.target.dataset.pollId;
        const selectedChoice = document.querySelector(`input[name="vote-${pollId}"]:checked`);
        const voteStatusElement = document.getElementById(`vote-status-${pollId}`);

        if (!selectedChoice) {
            alert('Please select a choice to vote.');
            return;
        }

        const choiceId = selectedChoice.value;

        try {
            voteStatusElement.innerHTML = '<span class="text-info">Submitting vote...</span>';
             e.target.disabled = true; // Disable button while voting

            const response = await fetch('/api/v1/vote', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ poll_id: pollId, choice_id: choiceId })
            });

            if (!response.ok) {
                const errorData = await response.json();
                 throw new Error(errorData.message || 'Failed to cast vote');
            }

            const result = await response.json();
            voteStatusElement.innerHTML = '<span class="text-success">Vote cast successfully!</span>';

            // Optionally, refresh the polls or update vote counts locally
             fetchAndDisplayPublicPolls(); // Refresh the list to show updated counts

        } catch (error) {
            console.error('Error casting vote:', error);
            voteStatusElement.innerHTML = `<span class="text-danger">Failed to cast vote: ${error.message}</span>`;
             e.target.disabled = false; // Re-enable button on failure
        }
    }


    // Initial fetch and display public polls when the page loads
    fetchAndDisplayPublicPolls();
});
