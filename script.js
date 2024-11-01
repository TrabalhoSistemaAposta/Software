function registerUser() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    fetch('index.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'register', username, email, password })
    }).then(response => response.json()).then(data => {
        if (data.success) {
            alert('Registro bem-sucedido');
            window.location.href = 'dashboard.html';
        } else {
            alert(data.message);
        }
    });
}

function loginUser() {
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    fetch('index.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'login', email, password })
    }).then(response => response.json()).then(data => {
        if (data.success) {
            localStorage.setItem('userId', data.user_id);
            window.location.href = 'dashboard.html';
        } else {
            alert(data.message);
        }
    });
}

function placeBet() {
    const event = document.getElementById('event').value;
    const outcome = document.getElementById('outcome').value;
    const amount = document.getElementById('amount').value;
    const userId = localStorage.getItem('userId');

    fetch('bet.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ userId, event, outcome, amount })
    }).then(response => response.json()).then(data => {
        if (data.success) {
            alert('Aposta realizada!');
            document.getElementById('credits').textContent = data.credits;
        } else {
            alert(data.message);
        }
    });
}
