{{-- resources/views/maintenances/cars_needing.blade.php --}}

@extends('_layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🚗 السيارات التي تحتاج صيانة</h2>
        <a href="{{ route('cars') }}" class="btn btn-secondary">← رجوع للسيارات</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cars->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>الصورة</th>
                        <th>العلامة</th>
                        <th>الموديل</th>
                        <th>السنة</th>
                        <th>الترقيم</th>
                        <th>الكيلومترات</th>
                        <th>السعر/يوم</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                    <tr>
                        <td>
                            @if($car->image)
                                <img src="{{ Storage::url($car->image) }}" width="60" height="40" style="object-fit: cover; border-radius: 5px;">
                            @else
                                <span class="text-muted">لا صورة</span>
                            @endif
                        </td>
                        <td><strong>{{ $car->brand }}</strong></td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->year }}</td>
                        <td><span class="badge bg-info">{{ $car->registration }}</span></td>
                        <td>{{ number_format($car->mileage) }} km</td>
                        <td>{{ number_format($car->price_per_day, 2) }} DH</td>
                        <td>
                            <a href="{{ route('maintenance.create', $car->id) }}" class="btn btn-warning btn-sm">
                                🔧 إضافة صيانة
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $cars->links() }}
        </div>
    @else
        <div class="alert alert-success text-center">
            🎉 جميع السيارات سليمة، لا توجد سيارة تحتاج صيانة حالياً
        </div>
    @endif
</div>
@endsection