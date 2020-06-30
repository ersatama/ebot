@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5 mb-5 pt-5 pb-5">
            <div class="col-12 col-md-4">
                <div class="card rounded-lg">
                    <div class="card-body">
                        <div class="card-title text-center border-bottom pb-3 font-weight-bold text-uppercase">Регистрация в <span class="text-success">E-Bot</span></div>
                        <form method="POST" action="/register">
                            @csrf
                            <div class="form-group">
                                <label class="text-secondary">Имя</label>
                                <the-mask :mask="['SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS']"  type="text" class="form-control bg-light" placeholder="Имя" required name="name" min-length="2" max-length="255"/>
                            </div>
                            <div class="form-group">
                                <label class="text-secondary">Фамилия</label>
                                <the-mask :mask="['SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS']" type="text" class="form-control bg-light" placeholder="Фамилия" required name="surname" min-length="2" max-length="255"/>
                            </div>
                            <div class="form-group">
                                <label class="text-secondary">Телефон</label>
                                <the-mask :mask="['+7(###) ###-##-##']"  type="text" class="form-control bg-light" placeholder="Телефон" required name="phone"/>
                            </div>
                            <div class="form-group">
                                <label class="text-secondary">Пароль</label>
                                <input type="password" class="form-control bg-light" placeholder="Пароль" required name="password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 text-capitalize">регистрация</button>
                        </form>
                        <hr>
                        <a href="/login">
                            <button type="submit" class="btn btn-success w-100 text-capitalize">войти</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
