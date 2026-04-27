function openEditModal() { document.getElementById('editModal').style.display = 'flex'; }
function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }

function openPasswordModal() { document.getElementById('passwordModal').style.display = 'flex'; }
function closePasswordModal() { document.getElementById('passwordModal').style.display = 'none'; }

window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) closeEditModal();
    if (event.target == document.getElementById('passwordModal')) closePasswordModal();
}

// AJAX Profile Update
const editProfileForm = document.getElementById('editProfileForm');
if (editProfileForm) {
    editProfileForm.onsubmit = function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.innerHTML = '⌛ Saving...';
        submitBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update UI
                document.getElementById('display-name').innerText = formData.get('name');
                document.getElementById('display-email').innerText = formData.get('email');
                document.getElementById('display-phone').innerText = formData.get('phone');

                window.showToast(data.message, 'success');
                closeEditModal();
            } else {
                window.showToast(data.message || 'Update failed', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showToast('An error occurred while updating profile', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
    };
}

// AJAX Password Update
const changePasswordForm = document.getElementById('changePasswordForm');
if (changePasswordForm) {
    changePasswordForm.onsubmit = function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.innerHTML = '⌛ Updating...';
        submitBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.showToast(data.message, 'success');
                closePasswordModal();
                form.reset(); // Clear password fields
            } else {
                window.showToast(data.message || 'Update failed', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showToast('An error occurred while updating password', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
    };
}
