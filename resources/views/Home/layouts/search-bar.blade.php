<div class="search-bar">
    <form action="{{ route('search') }}" method="GET" class="search-form">
        <div class="search-input-group">
            <input type="text" name="search_key" placeholder="جستجوی گیاهان دارویی، مقالات و فروشگاه‌ها..." required>
            <select name="search_type">
                <option value="all">همه موارد</option>
                <option value="products">گیاهان دارویی</option>
                <option value="articles">مقالات</option>
                <option value="stores">فروشگاه‌ها</option>
                <option value="categories">دسته‌بندی‌ها</option>
            </select>
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>

<style>
.search-bar {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    padding: 1rem;
}

.search-form {
    width: 100%;
}

.search-input-group {
    display: flex;
    gap: 0.5rem;
    background: white;
    padding: 0.5rem;
    border-radius: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.search-input-group input {
    flex: 1;
    border: none;
    padding: 0.8rem 1.2rem;
    font-size: 1rem;
    outline: none;
    direction: rtl;
}

.search-input-group select {
    padding: 0.8rem;
    border: none;
    border-right: 1px solid #eee;
    outline: none;
    background: white;
    color: var(--text-color);
    font-size: 0.9rem;
    cursor: pointer;
    direction: rtl;
}

.search-input-group button {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-input-group button:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
}

.search-input-group button i {
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .search-input-group {
        flex-direction: column;
        padding: 0.8rem;
        gap: 0.8rem;
    }

    .search-input-group select {
        border-right: none;
        border-top: 1px solid #eee;
        padding-top: 0.8rem;
    }

    .search-input-group button {
        width: 100%;
    }
}
</style>
