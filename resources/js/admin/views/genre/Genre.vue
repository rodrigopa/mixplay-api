<template>
    <div>
        <title-bar :title-stack="titleStack"/>
        <hero-bar :has-right-visible="false">
            Gêneros
        </hero-bar>
        <section class="section is-main-section">
            <router-view></router-view>
        </section>
    </div>
</template>

<script>
    import TitleBar from '../../components/TitleBar'
    import HeroBar from '../../components/HeroBar'

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
                    'Media',
                    'Gêneros'
                ]
            }
        },
    }
</script>
