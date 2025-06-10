@extends('Admin.layouts.master')

@section('content')
<section class="comments-section py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">


         <div class="d-flex justify-content-center gap-4">
    <a href="{{route('panel.report.store')}}" class="btn btn-lg comment-btn article-btn">
        <i class="fas fa-store ml-2"></i>
        گزارش مغازه
    </a>


            </div>
        </div>
    </div>
</section>

<style>
.comments-section {
    padding: 2rem;
}

.comment-btn {
    min-width: 200px;
    max-width: 300px;
    flex: 1;
    padding: 1.5rem;
    text-align: center;
    border-radius: 15px;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.comment-btn i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.article-btn {
    background: linear-gradient(135deg, #1976d2, #64b5f6);
    color: white;
}

.product-btn {
    background: linear-gradient(135deg, #43a047, #81c784);
    color: white;
}

.comment-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: white;
}

.badge {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.9rem;
}

.gap-4 {
    gap: 1.5rem;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: center;
}

@media (max-width: 576px) {
    .gap-4 {
        flex-direction: column;
    }
}
</style>
@endsection
