<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'list'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="card m-5">
                    <card_header_list :sel="'constants'"></card_header_list>

                    list
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
        name: "listConstants"
    }
</script>

<style scoped>

</style>
