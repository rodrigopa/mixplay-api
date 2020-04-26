<template>
    <section>
        <form method="post" action="javascript:;" @submit="submit()">
            <b-field label="Nome" label-for="genre.name">
                <b-input v-model="data.name" id="genre.name"></b-input>
            </b-field>
            <b-button type="is-primary" native-type="submit">Enviar</b-button>
        </form>
    </section>
</template>

<script>
    import axios from 'axios'
    import ModalMixin from "../../mixins/ModalMixin";

    export default {
        mixins: [ModalMixin],
        data() {
            return {
                data: {}
            }
        },
        props: ['update'],
        computed: {
            id() {
                return this.$route.params.id;
            },
            isUpdate() {
                return this.update || false;
            }
        },
        methods: {
            load() {
                if (this.isUpdate) {
                    axios
                        .get(`genre/${this.id}`)
                        .then((res) => {
                            this.data = res.data.data;
                        })
                }
            },
            submit() {
                const config = {
                    method: this.isUpdate ? 'put' : 'post',
                    url: this.isUpdate ? `genre/${this.id}` : 'genre',
                    data: this.data
                }

                axios(config)
                    .then((res) => {
                        this.alertSubmitedSuccess(this.isUpdate)
                        this.$router.go(-1)
                    })
            }
        },
        mounted() {
            this.load()
        }
    }
</script>
