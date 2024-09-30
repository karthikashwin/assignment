const audioTable = document.getElementById('audioTable');
const pagination = document.getElementById('pagination');

async function fetchAudioData(page = 1) {
    const response = await fetch(`view.php?page=${page}`);
    const data = await response.json();

    // Render the audio files table
    audioTable.innerHTML = `
        <thead>
            <tr>
                <th>File</th>
                <th>Language</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            ${data.audioFiles.map(audio => `
                <tr>
                    <td><audio controls><source src="${audio.file_path}" type="audio/mpeg"></audio></td>
                    <td>${audio.language}</td>
                    <td>${audio.description}</td>
                    <td>${audio.status}</td>
                    <td>
                        <button class="approve-btn" data-id="${audio.id}">Approve</button>
                        <button class="reject-btn" data-id="${audio.id}">Reject</button>
                    </td>
                </tr>
            `).join('')}
        </tbody>
    `;

    // Render pagination buttons
    pagination.innerHTML = `
        ${data.totalPages > 1 ? Array.from({ length: data.totalPages }, (_, i) => `
            <button class="pagination-btn" data-page="${i + 1}">${i + 1}</button>
        `).join('') : ''}
    `;

    // Add event listeners for approve/reject buttons
    const approveButtons = document.querySelectorAll('.approve-btn');
    const rejectButtons = document.querySelectorAll('.reject-btn');

    approveButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const audioId = button.dataset.id;
            await updateAudioStatus(audioId, 'approved');
        });
    });

    rejectButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const audioId = button.dataset.id;
            await updateAudioStatus(audioId, 'rejected');
        });
    });

    // Add event listeners for pagination buttons
    const paginationButtons = document.querySelectorAll('.pagination-btn');
    paginationButtons.forEach(button => {
        button.addEventListener('click', () => {
            fetchAudioData(button.dataset.page);
        });
    });
}

async function updateAudioStatus(audioId, status) {
    const response = await fetch('update_audio_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: audioId, status })
    });

    if (response.ok) {
        alert('Status updated successfully!');
        fetchAudioData(); // Refresh data
    } else {
        alert('Error updating status.');
    }
}

// Fetch initial audio data
fetchAudioData();
