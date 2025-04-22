<script>
    // ناوبری نوار کناری
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.sidebar a').forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            const sectionId = link.getAttribute('href').substring(1);
            document.querySelectorAll('.main-content section').forEach(section => {
                section.style.display = section.id === sectionId ? 'block' : 'none';
            });
        });
    });

    // مقداردهی اولیه نمای داشبورد
    document.querySelectorAll('.main-content section').forEach(section => {
        section.style.display = section.id === 'dashboard' ? 'block' : 'none';
    });

    // دکمه افزودن محصول جدید (جایگزین)
    document.querySelector('.add-item button').addEventListener('click', () => {
        alert('فرم افزودن محصول جدید در اینجا باز می‌شود.');
    });

    // دکمه‌های عملیات (جایگزین)
    document.querySelectorAll('.action-buttons button').forEach(button => {
        button.addEventListener('click', () => {
            alert(`عملیات ${button.textContent} فعال شد.`);
        });
    });
</script>
