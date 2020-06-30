<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'autofunnels'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="card m-5">
                    <card_header_autofunnels :sel="'autofunnels'"></card_header_autofunnels>
                    <div class="card-body">

                        <div class="alert alert-info" role="alert">
                            В авторассылку попадают новые контакты подходящие под заданные условия и написавшие боту после ЗАПУСКА рассылки. Чтобы добавить существующие контакты в авторассылку установите нужный параметр ниже при создании авторассылки.
                        </div>
                        <div class="row py-5 justify-content-center">
                            <div class="col-12 col-md-5">

                                <form>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label text-secondary">Название рассылки</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-dark" placeholder="Моя рассылка">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label text-secondary">Содержит теги</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-dark" placeholder="Имя тега">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label text-secondary">Не содержит теги</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control text-dark" placeholder="Имя тега">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-7 ml-auto">
                                            <button type="submit" class="btn btn-primary w-100">Сохранить</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import side from "./sidebar";
    import head_main from "./head";
    import card_header_autofunnels from "./card_header_autofunnels";
    export default {
        components: {
            side,
            head_main,
            card_header_autofunnels
        },
        name: "autofunnels"
    }
</script>

<style scoped>

</style>
