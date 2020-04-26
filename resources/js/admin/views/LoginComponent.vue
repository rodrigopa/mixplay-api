<template>
    <div>
        <title-bar :title-stack="titleStack"/>
        <hero-bar :has-right-visible="false">
            Dashboard
        </hero-bar>
        <section class="section is-main-section">

        </section>
    </div>
</template>

<script>
    import TitleBar from '../components/TitleBar'
    import HeroBar from '../components/HeroBar'

    export default {
        name: 'home',
        components: {
            HeroBar,
            TitleBar
        },
        computed: {
            titleStack () {
                return [
                    'Admin',
                    'Dashboard'
                ]
            }
        },
    }
</script>
