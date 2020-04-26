<template>
    <section>
        <b-table :data="data">
            <template slot-scope="props">
                <b-table-column label="Ações" width="100">
                    <b-button
                        tag="router-link"
                        :to="{ name: 'genre.edit', params: { id: props.row.id } }"
                        size="is-small">
                        <b-icon icon="pencil" size="is-small"></b-icon>
                    </b-button>
                    <b-button
                        @click="destroy(props.row.id)"
                        type="is-danger"
                        size="is-small">
                        <b-icon icon="delete" size="is-small"></b-icon>
                    </b-button>
                </b-table-column>
                <b-table-column label="ID" field="id" width="40" numeric>{{props.row.id}}</b-table-column>
                <b-table-column label="Nome" field="name">{{props.row.name}}</b-table-column>
            </template>
        </b-table>
        <pagination :pagination="pagination" route-name="genre.index"></pagination>
    </section>
</template>

<script>
    import axios from 'axios'
    import Pagination from "../../components/Pagination";
    import ModalMixin from "../../mixins/ModalMixin";

    export default {
        mixins: [ModalMixin],
        components: {
            Pagination
        },
        props: ['page'],
        data() {
            return {
                label: 'Gênero',
                data: [],
                pagination: []
            }
        },
        methods: {
            load() {
                axios
                    .get(`genre?page=${this.page}`)
                    .then((res) => {
                        const resultData = res.data.data;
                        this.data = resultData.items;
                        this.pagination = resultData.links;
                    })
            },
            destroy(id) {
                this.confirmDestroy(id, 'genre', () => this.load());
            }
        },
        mounted() {
            this.load()
        },
        watch: {
            page() {
                this.load()
            }
        }
    }
</script>
