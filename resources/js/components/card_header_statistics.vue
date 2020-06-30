<template>
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/statistics" :class="{ active: (sel === 'statistics') }">Активность</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/statistics/devices" :class="{ active: (sel === 'devices') }">Устройства</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/statistics/phrases" :class="{ active: (sel === 'phrases') }">Фразы Whatsapp</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/statistics/popular" :class="{ active: (sel === 'popular') }">Популярные фразы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/statistics/links" :class="{ active: (sel === 'links') }">Ссылки</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['sel'],
        name: "card_header_statistics"
    }
</script>

<style scoped>

</style>
