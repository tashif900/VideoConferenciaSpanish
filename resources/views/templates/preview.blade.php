@extends('layouts.web')
@section('title', 'Sala')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card-white">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-5">
                                <div class="preview-course-banner">
                                    <img src="{{ asset('img/preview-bg.png') }}" alt="">
                                    <div class="preview-course-banner-copy">
                                        <h2 class="class-viewer-banner-copy-title">CURSO</h2>
                                        <hr>
                                        <p class="class-viewer-banner-copy-subtitle">INSTRUCTOR</p>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit similique numquam consectetur sequi dolore dolorum delectus iste velit perferendis quae. Alias quos repellendus modi dignissimos dolor, ipsam quam pariatur maiores.</p>
                                        <a href="#" class="btn btn-custom-red">Inscribirte</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-7 preview-rightsidebar">
                                <div class="col-12 mb-4">
                                    <div class="item border">
                                        <div class="xcard video-class-item grid">
                                            <div class="xcard-header">
                                                <img src="{{ asset('img/3.png') }}">
                                                <div class="video-class-item-type">
                                                    <span class="icon"></span> Grabada
                                                </div>
                                            </div>
                                            <div class="xcard-body py-3 px-3">
                                                <div class="row cross-center">
                                                    <div class="col-12 col-lg-9 pd-0">
                                                        <div class="video-class-instructor-content d-flex mt-3">
                                                            <div class="video-class-instructor-content-avatar">
                                                                <img src="{{ asset('img/8.png') }}">
                                                            </div>
                                                            <div class="video-class-instructor-content-info">
                                                                <p>CURSO</p>
                                                                <small>INSTRUCTOR</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-3 main-end pd-0 my-4">
                                                        <p><strong>$55</strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 preview-course-item">
                                            <img src="{{ asset('img/3.png') }}" alt="">
                                            <div class="preview-course-item-info">
                                                <p><strong>INSTRUCTOR</strong> Juan Peres</p>
                                            </div>
                                        </div>
                                        <div class="col-12 preview-course-item">
                                            <img src="{{ asset('img/3.png') }}" alt="">
                                            <div class="preview-course-item-info">
                                                <p><strong>INSTRUCTOR</strong> Juan Peres</p>
                                            </div>
                                        </div>
                                        <div class="col-12 preview-course-item">
                                            <img src="{{ asset('img/3.png') }}" alt="">
                                            <div class="preview-course-item-info">
                                                <p><strong>INSTRUCTOR</strong> Juan Peres</p>
                                            </div>
                                        </div>
                                        <div class="col-12 preview-course-item">
                                            <img src="{{ asset('img/3.png') }}" alt="">
                                            <div class="preview-course-item-info">
                                                <p><strong>INSTRUCTOR</strong> Juan Peres</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="preview-course-table border px-3 py-3">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Clase</th>
                                                    <th scope="col">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($course->cclass as $class)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $class->name }}</td>
                                                        <td>Pendiente</td>
                                                    </tr>    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
