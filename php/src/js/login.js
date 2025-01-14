document.addEventListener('DOMContentLoaded', function () {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const rememberCheckbox = document.getElementById('remember');

    // ดึงข้อมูลจาก Local Storage
    const savedEmail = localStorage.getItem('email');
    const savedPassword = localStorage.getItem('password');
    const rememberMe = localStorage.getItem('rememberMe');

    // เติมข้อมูลถ้าตั้ง Remember Me
    if (rememberMe === 'true') {
        emailField.value = savedEmail || '';
        passwordField.value = savedPassword || '';
        rememberCheckbox.checked = true;
    }
});

document.querySelector('#myForm').addEventListener('submit', function (e) {
    e.preventDefault(); // ป้องกันการรีเฟรชหน้า
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const rememberCheckbox = document.getElementById('remember');
    const resultDiv = document.getElementById('result');

    // บันทึกข้อมูลลง Local Storage ถ้า Remember Me ถูกเลือก
    if (rememberCheckbox.checked) {
        localStorage.setItem('email', emailField.value);
        localStorage.setItem('password', passwordField.value);
        localStorage.setItem('rememberMe', 'true');
    } else {
        localStorage.removeItem('email');
        localStorage.removeItem('password');
        localStorage.setItem('rememberMe', 'false');
    }

    // ส่งข้อมูลด้วย Fetch API
    fetch('process.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `email=${emailField.value}&password=${passwordField.value}`
    })
    .then(response => response.text())
    .then(data => {
        resultDiv.innerHTML = `<div class="alert alert-success">${data}</div>`;
    })
    .catch(err => {
        resultDiv.innerHTML = `<div class="alert alert-danger">Error: ${err.message}</div>`;
    });
});
