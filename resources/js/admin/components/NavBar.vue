<template>
    <nav v-show="isNavBarVisible" id="navbar-main" class="navbar is-fixed-top">
        <div class="navbar-brand">
            <a class="navbar-item is-hidden-desktop" @click.prevent="menuToggleMobile">
                <b-icon :icon="menuToggleMobileIcon"/>
            </a>
        </div>
        <div class="navbar-brand is-right">
            <a class="navbar-item navbar-item-menu-toggle is-hidden-desktop" @click.prevent="menuNavBarToggle">
                <b-icon :icon="menuNavBarToggleIcon" custom-size="default"/>
            </a>
        </div>
        <div class="navbar-menu fadeIn animated faster" :class="{'is-active':isMenuNavBarActive}">
            <div class="navbar-end">
                <a class="navbar-item" title="Log out" @click="logout">
                    <span>Sair</span>
                </a>
            </div>
        </div>
    </nav>
</template>

<script>
    import { mapState } from 'vuex'
    import NavBarMenu from './NavBarMenu'
    import UserAvatar from './UserAvatar'

    export default {
        name: 'NavBar',
        components: {
            UserAvatar,
            NavBarMenu
        },
        data () {
            return {
                isMenuNavBarActive: false
            }
        },
        computed: {
            menuNavBarToggleIcon () {
                return (this.isMenuNavBarActive) ? 'close' : 'dots-vertical'
            },
            menuToggleMobileIcon () {
                return this.isAsideMobileExpanded ? 'backburger' : 'forwardburger'
            },
            ...mapState([
                'isNavBarVisible',
                'isAsideMobileExpanded',
                'userName'
            ])
        },
        methods: {
            menuToggleMobile () {
                this.$store.commit('asideMobileStateToggle')
            },
            menuNavBarToggle () {
                this.isMenuNavBarActive = (!this.isMenuNavBarActive)
            },
            logout () {
                this.$buefy.snackbar.open({
                    message: 'Log out clicked',
                    queue: false
                })
            }
        }
    }
</script>
