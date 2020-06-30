<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'settings'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="card m-5">
                    <card_header :sel="'settings'"></card_header>
                    <div class="card-body">
                        <div class="row py-5 justify-content-center">
                            <div class="col-12 col-md-5">
                                <form>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label text-secondary">Название бота</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control text-dark">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label text-secondary">Язык бота</label>
                                        <div class="col-sm-8">
                                            <select class="form-control">
                                                <option>English</option>
                                                <option selected>Русский</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8 ml-auto">
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
    import card_header from "./card_header";
    export default {
        components: {
            side,
            head_main,
            card_header
        },
        name: "settings.vue"
    }
</script>

<style scoped>

</style>
