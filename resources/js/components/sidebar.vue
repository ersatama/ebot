<template>
    <nav id="sidebar" class="active">
        <div class="sidebar-header">
            <strong>EB</strong>
        </div>
        <ul class="list-unstyled components">
            <li :class="{ active: (sel === 'home') }">
                <a href="/home">
                    <i class="fas fa-sitemap h6 m-0 text-white"></i>
                </a>
            </li>
            <li :class="{ active: (sel === 'chat') }">
                <a href="/chat">
                    <i class="fas fa-comments h6 m-0 text-white"></i>
                </a>
            </li>
            <li :class="{ active: (sel === 'autofunnels')}">
                <a href="/autofunnels">
                    <i class="fas fa-filter text-white h6 m-0"></i>
                </a>
            </li>
            <li :class="{ active: (sel === 'settings') }">
                <a href="/settings">
                    <i class="fas fa-cogs text-white h6 m-0"></i>
                </a>
            </li>
            <li :class="{ active: (sel === 'list') }">
                <a href="/list">
                    <i class="fas fa-server text-white h6 m-0"></i>
                </a>
            </li>
            <li :class="{ active: (sel === 'statistics') }" class="d-none ">
                <a href="/statistics">
                    <i class="fas fa-chart-line text-white h6 m-0"></i>
                </a>
            </li>
            <li :class="{ active: (sel === 'analyze') }">
                <a href="/analyze">
                    <i class="fas fa-project-diagram text-white h6 m-0"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['sel'],
        name: "sidebar"
    }
</script>

<style scoped>

</style>
