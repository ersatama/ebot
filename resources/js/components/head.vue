<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container-fluid">
            <button class="btn btn-dark d-inline-block d-lg-none" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold">Добро пожаловать в <span class="text-dark">E-</span><span class="text-success">Bot</span></a>
                    </li>
                    <li class="nav-item active">
                        <div class="btn-group">

                            <button type="button" class="btn btn-light">
                                {{user.name}}
                            </button>
                            <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="/user">Редактировать</a>
                                <a class="dropdown-item" href="/help">Помощь</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout">Выход</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "head",
        data: function() {
            return {
                user: {
                    name: 'Hello world'
                }
            }
        }
    }
</script>

<style scoped>

</style>
