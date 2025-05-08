
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const storeSelect = document.getElementById('store_id');
        const categorySelect = document.getElementById('category_id');

        if (storeSelect) {
            storeSelect.addEventListener('change', function () {
                const storeId = this.value;
                categorySelect.innerHTML = '<option>در حال بارگذاری...</option>';
                fetch(`/panel/product/get-categories-by-store/${storeId}`)
                    .then(response => response.json())
                    .then(data => {
                        categorySelect.innerHTML = '<option value="">انتخاب دسته‌بندی</option>';
                        data.forEach(category => {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.name;
                            categorySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('خطا در دریافت دسته‌بندی‌ها:', error);
                        categorySelect.innerHTML = '<option>خطا در دریافت</option>';
                    });
            });
        }
    });
</script>
<script>
    // نمایش نام فایل انتخاب شده در input
    document.querySelector('#image').addEventListener('change', function() {
        const fileName = this.files[0]?.name || 'انتخاب فایل';
        this.nextElementSibling.textContent = fileName;
    });
</script>