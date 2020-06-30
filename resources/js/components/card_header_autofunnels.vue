<template>
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/autofunnels" :class="{ active: (sel === 'autofunnels') }">Авторассылка</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/autofunnels/list" :class="{ active: (sel === 'list') }">Все рассылки</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['sel'],
        name: "card_header_autofunnels"
    }
</script>

<style scoped>

</style>
