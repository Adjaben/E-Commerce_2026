// js/validate.js
// Task 3: client-side form validation with regex.
// This never replaces server-side validation (actions/*.php) — it just
// gives the user faster feedback before the form submits.

(function () {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9+\-\s]{7,15}$/;

    function showError(input, message) {
        clearError(input);
        const span = document.createElement('span');
        span.className = 'field-error';
        span.textContent = message;
        input.insertAdjacentElement('afterend', span);
        input.classList.add('invalid');
    }

    function clearError(input) {
        input.classList.remove('invalid');
        const next = input.nextElementSibling;
        if (next && next.classList.contains('field-error')) {
            next.remove();
        }
    }

    function setLoading(form, isLoading) {
        const btn = form.querySelector('button[type="submit"]');
        if (!btn) return;
        btn.disabled = isLoading;
        btn.textContent = isLoading ? 'Please wait...' : btn.dataset.originalText || btn.textContent;
        if (!isLoading) return;
        btn.dataset.originalText = btn.dataset.originalText || btn.textContent;
    }

    function validateRegisterForm(form) {
        let valid = true;

        const name = form.querySelector('#name');
        const email = form.querySelector('#email');
        const pass = form.querySelector('#pass');
        const contact = form.querySelector('#contact');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

        if (name && name.value.trim().length === 0) {
            showError(name, 'Please enter your name.');
            valid = false;
        } else if (name) {
            clearError(name);
        }

        if (email && !emailRegex.test(email.value.trim())) {
            showError(email, 'Please enter a valid email address.');
            valid = false;
        } else if (email) {
            clearError(email);
        }

        if (pass && pass.value.length < 6) {
            showError(pass, 'Password must be at least 6 characters.');
            valid = false;
        } else if (pass) {
            clearError(pass);
        }

        if (contact && contact.value.trim() !== '' && !phoneRegex.test(contact.value.trim())) {
            showError(contact, 'Please enter a valid phone number.');
            valid = false;
        } else if (contact) {
            clearError(contact);
        }

        return valid;
    }

    function validateLoginForm(form) {
        let valid = true;

        const email = form.querySelector('#email');
        const pass = form.querySelector('#pass');

        if (email && !emailRegex.test(email.value.trim())) {
            showError(email, 'Please enter a valid email address.');
            valid = false;
        } else if (email) {
            clearError(email);
        }

        if (pass && pass.value.length === 0) {
            showError(pass, 'Please enter your password.');
            valid = false;
        } else if (pass) {
            clearError(pass);
        }

        return valid;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const registerForm = document.getElementById('register-form');
        const loginForm = document.getElementById('login-form');

        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                if (!validateRegisterForm(registerForm)) {
                    e.preventDefault();
                    return;
                }
                setLoading(registerForm, true);
            });
        }

        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                if (!validateLoginForm(loginForm)) {
                    e.preventDefault();
                    return;
                }
                setLoading(loginForm, true);
            });
        }
    });
})();
