<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>خبرنامه</h3>
            <div class="newsletter">
                <input type="email" placeholder="ایمیل خود را وارد کنید">
                <button>عضویت</button>
            </div>
        </div>

        <div class="footer-section">
            <h3>همکاری با ما</h3>
            <button id="openStoreModal" class="store-register-btn">ثبت فروشگاه</button>
        </div>

        <div class="footer-section">
            <h3>تماس با ما</h3>
            <p>آدرس: تهران، خیابان ولیعصر</p>
            <p>تلفن: 021-12345678</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025 گیاهان دارویی. تمامی حقوق محفوظ است.</p>
    </div>

    <!-- Store Registration Modal -->
    <div id="storeModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            
            <div class="modal-header">
                <h2>ثبت فروشگاه</h2>
            </div>
                <form id="storeRegistrationForm" class="store-form" action="{{ route('store.register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="storeName">نام فروشگاه:</label>
                        <input type="text" id="storeName" name="name" required>
                    </div>


                    <div class="form-group">
                        <label for="storePhone">شماره تماس:</label>
                        <input type="tel" id="storePhone" name="phone_number" required>
                    </div>

                    <div class="form-group">
                        <label for="storeAddress">آدرس:</label>
                        <textarea id="storeAddress" name="address" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="productTypes"> توضیحات:</label>
                        <textarea id="productTypes" name="productTypes" placeholder="لطفاً انواع محصولات خود را شرح دهید" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="storeImage">تصویر فروشگاه:</label>
                        <input type="file" id="storeImage" name="image" accept="image/*" required>
                        <small class="file-help">لطفاً تصویری از نمای فروشگاه خود را آپلود کنید</small>
                    </div>

                    <button type="submit" class="submit-btn">ثبت درخواست</button>
                </form>
            </div>
        </div>
    </div>
</footer>

<style>
.site-footer {
    background-color: #f8f9fa;
    padding: 40px 0 20px;
    font-family: 'Iranian Sans', sans-serif;
    direction: rtl;
}

.footer-content {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-section {
    margin-bottom: 30px;
    min-width: 250px;
}

.footer-section h3 {
    color: #333;
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.newsletter input {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-left: 10px;
    width: 200px;
}

.newsletter button,
.store-register-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.newsletter button:hover,
.store-register-btn:hover {
    background-color: var(--secondary-color);
}

.footer-bottom {
    text-align: center;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #ddd;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    width: 90%;
    max-width: 600px;
    border-radius: 8px;
    position: relative;
    max-height: 90vh;
    overflow-y: auto;
}

.close-modal {
    position: absolute;
    left: 20px;
    top: 20px;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.modal-header {
    text-align: center;
    margin-bottom: 20px;
}

.requirements-section {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.requirements-section ul {
    list-style-type: none;
    padding: 0;
}

.requirements-section li {
    margin-bottom: 10px;
    padding-right: 20px;
    position: relative;
}

.requirements-section li:before {
    content: '\2022';
    position: absolute;
    right: 0;
    color: var(--primary-color);
}

.store-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.form-group label {
    font-weight: bold;
    color: #333;
}

.form-group input:not([type="file"]),
.form-group textarea {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Iranian Sans', sans-serif;
}

.form-group textarea {
    height: 100px;
    resize: vertical;
}

.submit-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1.1rem;
    transition: background-color 0.3s;
}

.submit-btn:hover {
    background-color: var(--secondary-color);
}

@media (max-width: 768px) {
    .footer-section {
        flex: 0 0 100%;
        text-align: center;
    }

    .modal-content {
        margin: 10% auto;
        width: 95%;
    }
}

.file-help {
    color: #666;
    font-size: 0.9rem;
    margin-top: 4px;
}

.form-group input[type="file"] {
    padding: 6px;
    border: 1px dashed #ddd;
    border-radius: 4px;
    background-color: #f8f9fa;
}

.form-group input[type="file"]:hover {
    border-color: var(--primary-color);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('storeModal');
    const openBtn = document.getElementById('openStoreModal');
    const closeBtn = document.querySelector('.close-modal');
    const form = document.getElementById('storeRegistrationForm');

    openBtn.onclick = function() {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    closeBtn.onclick = function() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    form.onsubmit = function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        try {
            return true;
        } catch (error) {
            e.preventDefault();
            console.error('Error:', error);
            alert('خطا در ارسال درخواست. لطفا دوباره تلاش کنید.');
            submitBtn.disabled = false;
            return false;
        }
    }
});
</script>
