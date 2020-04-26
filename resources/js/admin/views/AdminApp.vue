<template>
    <div>
        <nav-bar></nav-bar>
        <aside-menu :menu="menu"/>
        <router-view></router-view>
        <footer-bar/>
    </div>
</template>

<script>
    import NavBar from "../components/NavBar";
    import AsideMenu from "../components/AsideMenu";
    import FooterBar from "../components/FooterBar";

    export default {
        components: {
            NavBar,
            AsideMenu,
            FooterBar
        },
        computed: {
            menu () {
                return [
                    'Media',
                    [
                        {
                            to: '/genre',
                            label: 'Gêneros',
                            icon: 'table'
                        },
                        {
                            to: '/forms',
                            label: 'Forms',
                            icon: 'square-edit-outline'
                        },
                        {
                            to: '/profile',
                            label: 'Profile',
                            icon: 'account-circle'
                        },
                        {
                            label: 'Submenus',
                            subLabel: 'Submenus Example',
                            icon: 'view-list',
                            menu: [
                                {
                                    href: '#void',
                                    label: 'Sub-item One'
                                },
                                {
                                    href: '#void',
                                    label: 'Sub-item Two'
                                }
                            ]
                        }
                    ]
                ]
            }
        },
        created () {
            this.$store.commit('user', {
                name: 'John Doe',
                email: 'john@example.com',
                avatar: 'https://avatars.dicebear.com/v2/gridy/John-Doe.svg'
            })
        }
    }
</script>

<style>
</style>
