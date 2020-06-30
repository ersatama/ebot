<template>
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/settings" :class="{ active: (sel === 'settings') }">Основное</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/notifications" :class="{ active: (sel === 'notifications') }">Уведомление</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/integration" :class="{ active: (sel === 'integration') }">Интеграции</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/politics" :class="{ active: (sel === 'politics') }">Полититка</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/settings/additional" :class="{ active: (sel === 'additional') }">Дополнительно</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['sel'],
        name: "card_header"
    }
</script>

<style scoped>

</style>
