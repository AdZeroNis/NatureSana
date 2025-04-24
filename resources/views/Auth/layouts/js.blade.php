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