<template>
    <div>
        <b-table :data="data" :columns="columns"></b-table>
        <pagination :pagination="pagination"></pagination>
    </div>
</template>

<script>
    import axios from 'axios'
    import Pagination from "../../components/Pagination";

    export default {
        components: {
            Pagination
        },
        data() {
            return {
                data: [],
                pagination: [],
                columns: [
                    {
                        field: 'id',
                        label: 'ID',
                        width: '40',
                        numeric: true
                    },
                    {
                        field: 'name',
                        label: 'Nome',
                    }
                ]
            }
        },
        computed: {
            page () {
                return this.$route.query.page || 1
            }
        },
        methods: {
            load() {
                axios
                    .get('genre?page=' + this.page)
                    .then((res) => {
                        const resultData = res.data.data;
                        this.data = resultData.items;
                        this.pagination = resultData.links;
                    })
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
