<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'chat'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="card m-5">
                    <div class="row">
                        <div class="col-3 border-right">menu</div>
                        <div class="col-9">chat</div>
                    </div>
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
            head_main
        },
        name: "chat"
    }
</script>

<style scoped>

</style>
