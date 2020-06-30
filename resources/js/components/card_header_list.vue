<template>
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link rounded-0" href="/list" :class="{ active: (sel === 'list') }">Контакты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-0" href="/list/constants" :class="{ active: (sel === 'constants') }">Переменные</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['sel'],
        name: "card_header_list"
    }
</script>

<style scoped>

</style>
