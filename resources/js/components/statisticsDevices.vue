<template>
    <div class="wrapper">
        <!-- Sidebar  -->
        <side :sel="'statistics'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="card m-5">
                    <card_header_statistics :sel="'devices'"></card_header_statistics>
                    <div class="card-body">
                        <div class="row py-5 justify-content-center">
                            <div class="col-12 col-md-5">
                                devices
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
    import card_header_statistics from "./card_header_statistics";
    export default {
        components: {
            side,
            head_main,
            card_header_statistics
        },
        name: "statisticsDevices"
    }
</script>

<style scoped>

</style>
