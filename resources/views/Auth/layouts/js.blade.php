<script>
        function showLogin() {
            document.querySelector('.auth-form.login').classList.add('active');
            document.querySelector('.auth-form.register').classList.remove('active');
            document.querySelectorAll('.auth-toggle button')[0].classList.add('active');
            document.querySelectorAll('.auth-toggle button')[1].classList.remove('active');
        }

        function showRegister() {
            document.querySelector('.auth-form.register').classList.add('active');
            document.querySelector('.auth-form.login').classList.remove('active');
            document.querySelectorAll('.auth-toggle button')[1].classList.add('active');
            document.querySelectorAll('.auth-toggle button')[0].classList.remove('active');
        }

        // فرم ورود (جایگزین)
        document.querySelector('.auth-form.login button').addEventListener('click', () => {
            const email = document.querySelector('.auth-form.login input[type="email"]').value;
            const password = document.querySelector('.auth-form.login input[type="password"]').value;
            // Removed client-side validation
        });

        // فرم ثبت‌نام (جایگزین)
        document.querySelector('.auth-form.register button').addEventListener('click', () => {
            const name = document.querySelector('.auth-form.register input[type="text"]').value;
            const email = document.querySelector('.auth-form.register input[type="email"]').value;
            const password = document.querySelector('.auth-form.register input[type="password"]').value;
            const confirmPassword = document.querySelector('.auth-form.register input[placeholder="تکرار رمز عبور"]').value;
            // Removed client-side validation
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.code-inputs input');
    
    inputs.forEach((input, index) => {
        // Auto-focus next input
        input.addEventListener('input', function() {
            if (this.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Allow only numbers
        input.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
    });
});
</script>
