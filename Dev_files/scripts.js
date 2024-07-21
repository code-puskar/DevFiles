let totalChants = 0;
let dailyChants = 0;
let participants = [];

document.getElementById('update-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const chants = parseInt(document.getElementById('chants').value);

    let participant = participants.find(p => p.name === name);
    if (participant) {
        participant.totalChants += chants;
        participant.dailyChants += chants;
    } else {
        participant = { name: name, totalChants: chants, dailyChants: chants };
        participants.push(participant);
    }

    totalChants += chants;
    dailyChants += chants;

    localStorage.setItem('participants', JSON.stringify(participants));
    localStorage.setItem('totalChants', totalChants);
    localStorage.setItem('dailyChants', dailyChants);

    updateProgress(); // Update progress immediately after form submission
    document.getElementById('update-form').reset();
    alert('Progress updated successfully!');
});

window.onload = function() {
    participants = JSON.parse(localStorage.getItem('participants')) || [];
    totalChants = parseInt(localStorage.getItem('totalChants')) || 0;
    dailyChants = parseInt(localStorage.getItem('dailyChants')) || 0;

    updateProgress(); // Update progress when the page loads
};

function updateProgress() {
    document.getElementById('total-chants').innerText = totalChants;
    document.getElementById('daily-chants').innerText = dailyChants;

    const tbody = document.getElementById('progress-tbody');
    if (tbody) {
        tbody.innerHTML = '';
        participants.forEach(participant => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${participant.name}</td><td>${participant.totalChants}</td><td>${participant.dailyChants}</td>`;
            tbody.appendChild(row);
        });
    }
}
