<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'list'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="container m-5 p-0">
                    <div class="card rounded-0">
                        <card_header_list :sel="'list'"></card_header_list>
                        <div class="card-body">
                            <div class="contacts-filter">
                                <form class="contacts-filter-item">
                                    <div class="form-group">
                                        <label>Сортировать по</label>
                                        <select class="form-control rounded-0 bg-light">
                                            <option>По дате</option>
                                            <option>По имени</option>
                                        </select>
                                    </div>
                                </form>
                                <form class="contacts-filter-item">
                                    <div class="form-group">
                                        <label>Город</label>
                                        <select class="form-control rounded-0 bg-light">
                                            <option>Не выбрано</option>
                                            <option>Алматы</option>
                                            <option>Астана</option>
                                        </select>
                                    </div>
                                </form>
                                <form class="contacts-filter-item">
                                    <div class="form-group">
                                        <label>Компания</label>
                                        <select class="form-control rounded-0 bg-light">
                                            <option>Не выбрано</option>
                                            <option>Europharma</option>
                                            <option>Ak-Niet</option>
                                            <option>Kazanat</option>
                                        </select>
                                    </div>
                                </form>
                                <form class="contacts-filter-item">
                                    <div class="form-group">
                                        <label>Телефон</label>
                                        <the-mask :mask="['+7(###) ###-##-##']"  type="text" class="form-control rounded-0 h6 bg-light"/>
                                    </div>
                                </form>
                                <form class="contacts-filter-item">
                                    <div class="form-group">
                                        <label>Имя контакта</label>
                                        <input type="text" class="form-control rounded-0 bg-light">
                                    </div>
                                </form>
                                <form class="contacts-filter-item">
                                    <div class="form-group">
                                        <label class="text-white">Новый контакт</label>
                                        <button class="contacts-filter-add btn btn-success rounded-0 w-100">Добавить контакт</button>
                                    </div>
                                </form>

                            </div>
                            <div class="contacts-list">
                                <div class="contacts-list-item" v-for="item in list">
                                    <div class="contacts-list-item-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="contacts-list-item-body">
                                        <div class="contacts-list-item-title">{{item.name}}</div>
                                        <div class="contacts-list-item-desc">{{item.type}} • <span class="text-dark font-weight-bold">{{item.phone}}</span></div>
                                    </div>
                                    <button class="contacts-list-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="contacts-list-btn-red">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container bg-light card mt-2 m-5 p-3 rounded-0" v-if="pagination > 1">
                    <nav aria-label="Page navigation example m-0">
                        <ul class="pagination m-0 rounded-0">
                            <li class="page-item" v-for="page in pagination" :class="{active: (page == selectedPage?true:false)}">
                                <a class="page-link rounded-0" :href="(page != 1?'/list?page='+page:'/list')">{{page}}</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import side from "./sidebar";
    import head_main from "./head";
    import card_header_list from "./card_header_list";
    export default {
        components: {
            side,
            head_main,
            card_header_list
        },
        name: "list",
        data: function() {
            return {
                list: [
                    {
                        id: 1,
                        name: 'Наджибулла',
                        type: 'Сотовый',
                        phone: '87784139424',
                    },
                    {
                        id: 1,
                        name: 'Наджибулла',
                        type: 'Сотовый',
                        phone: '87784139424',
                    },
                    {
                        id: 1,
                        name: 'Наджибулла',
                        type: 'Сотовый',
                        phone: '87784139424',
                    },
                    {
                        id: 1,
                        name: 'Наджибулла',
                        type: 'Сотовый',
                        phone: '87784139424',
                    }
                ],
                selectedPage: 1,
                pagination: 1
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
