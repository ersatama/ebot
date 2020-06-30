<template>
    <bot_edit :edit-id="this.$route.params.id"></bot_edit>
</template>

<script>
    import bot_edit from './bot_edit';
    export default {
        name: "editBot",
        components: {
            bot_edit,
        },
    }
</script>

<style scoped>

</style>
