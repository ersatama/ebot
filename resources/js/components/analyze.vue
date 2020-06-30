<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'analyze'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="container grid-template card bg-light m-5 rounded-0" v-if="list.length !== 0">
                    <div class="card rounded-0" v-for="(bot, index) in list">
                        <h6 class="card-title m-3">{{bot.name}}</h6>
                        <div class="card-text">
                            <table class="table m-0" style="font-size: 12px;">
                                <tbody>
                                <tr class="bg-light">
                                    <td class="border-0">
                                        <span class="text-secondary">событий:</span> {{bot.chain}}
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="border-0">
                                        <span class="text-secondary">ссылка:</span> {{bot.url}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-toolbar m-3">
                            <div class="btn-group mr-2">
                                <a :href="'/edit/bot/'+bot.id">
                                    <button type="button" class="btn btn-success rounded-0">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                            </div>
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-danger rounded-0">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="btn-group mr-2">
                                <a :href="'/view/bot/'+bot.id">
                                    <button type="button" class="btn btn-secondary rounded-0">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container grid-template card bg-light m-5 rounded-0" v-else>
                    Нет ботов
                </div>
                <div class="container bg-light card m-5 p-3 rounded-0" v-if="pagination > 1">
                    <nav aria-label="Page navigation example m-0">
                        <ul class="pagination m-0 rounded-0">
                            <li class="page-item" v-for="page in pagination" :class="{active: (page == selectedPage?true:false)}">
                                <a class="page-link rounded-0" :href="(page != 1?'/analyze?page='+page:'/analyze')">{{page}}</a>
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

    export default {
        components: {
            side,
            head_main,
        },
        name: "analyze",
        created() {

            let self = this;
            if (this.$route.query.page) this.selectedPage = this.$route.query.page;

            axios.get('vue/analyze/'+this.selectedPage).then(function(response) {
                // return console.log(response.data);
                self.list = response.data[0];
                self.pagination = response.data[1];
                console.log(response.data);
            });

        },
        data: function() {
            return {
                list: [],
                pagination: 0,
                selectedPage: 1,
            }
        }
    }
</script>

<style scoped>
    .grid-template {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        grid-gap: 15px;
        padding: 15px;
    }
</style>
