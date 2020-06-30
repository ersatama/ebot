@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mt-5 pt-5">
            <div class="col-12 col-sm-8 pt-5">

            </div>
            <div class="col-12 col-sm-4">
                <div class="card rounded-lg">
                    <div class="card-body">
                        <div class="card-title text-center border-bottom pb-3 font-weight-bold text-uppercase">Войти в <span class="text-success">E-Bot</span></div>
                        <form method="POST" action="/login">
                            @csrf
                            <div class="form-group">
                                <label class="text-secondary">Телефон</label>
                                <the-mask :mask="['+7(###) ###-##-##']"  type="text" class="form-control bg-light" placeholder="Телефон" required name="phone"/>
                            </div>
                            <div class="form-group">
                                <label class="text-secondary">Пароль</label>
                                <input type="password" name="password" class="form-control bg-light" placeholder="Пароль">
                            </div>
                            <div class="form-check" style="cursor: pointer;">
                                <div class="row">
                                    <div class="col-6 text-primary">
                                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                        <label class="form-check-label" for="remember">Запомни меня</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="/restore" class="text-success">Забыли пароль</a>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 w-100 text-capitalize">войти</button>
                        </form>
                        <hr>
                        <a href="/register">
                            <button class="btn btn-success w-100 text-capitalize">регистрация</button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
