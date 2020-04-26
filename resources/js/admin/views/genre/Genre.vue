<template>
    <div>
        <title-bar :title-stack="titleStack"/>
        <hero-bar :has-right-visible="false">
            Gêneros
        </hero-bar>
        <section class="section is-main-section">
            <div class="module-actions">
                <b-button type="is-secondary" tag="router-link" :to="{ name: 'genre.index' }">Listar</b-button>
                <b-button type="is-secondary" tag="router-link" :to="{ name: 'genre.create' }">Criar</b-button>
            </div>
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
