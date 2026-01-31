const editBtn = document.getElementById('editBtn');
const inputs = document.querySelectorAll('.profile-input');

let isEditing = false;

editBtn.addEventListener('click', () => {
    isEditing = !isEditing;

    inputs.forEach(input => {
        input.readOnly = !isEditing;
        input.classList.toggle('editing', isEditing);
    });

    editBtn.textContent = isEditing ? 'Done' : 'Edit';
});

// for profileModal.php
const vehicleButtons = document.querySelectorAll('.vehicle-btn');

vehicleButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        vehicleButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});