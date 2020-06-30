<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'autofunnels'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="card m-5">
                    <card_header_autofunnels :sel="'list'"></card_header_autofunnels>
                    <div class="card-body">

                        LIST

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
        name: "autofunnelsList"
    }
</script>

<style scoped>

</style>
