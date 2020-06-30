<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'settings'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="card m-5">
                    <card_header :sel="'politics'"></card_header>
                    <div class="card-body">
                        <div class="row py-5 justify-content-center">
                            Политика
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
        name: "settingsPolitics"
    }
</script>

<style scoped>

</style>
