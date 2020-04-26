<template>
    <b-pagination
        class="has-margin-top"
        :total="pagination.total"
        :current.sync="pagination.current_page"
        :per-page="pagination.per_page"
        :simple="false">

        <b-pagination-button
            slot-scope="props"
            :page="props.page"
            :id="`page${props.page.number}`"
            tag="router-link"
            :to="{ 'name': routeName, 'query': { 'page' : props.page.number } }">
        </b-pagination-button>

        <b-pagination-button
            slot="previous"
            slot-scope="props"
            :page="props.page"
            tag="router-link"
            :to="{ 'name': routeName, 'query': { 'page' : props.page.number } }">
            <b-icon icon="chevron-left"></b-icon>
        </b-pagination-button>

        <b-pagination-button
            slot="next"
            slot-scope="props"
            :page="props.page"
            tag="router-link"
            :to="{ 'name': routeName, 'query': { 'page' : props.page.number } }">
            <b-icon icon="chevron-right"></b-icon>
        </b-pagination-button>

    </b-pagination>
</template>

<script>
    export default {
        name: 'pagination',
        props: ['pagination', 'route-name'],
        mounted() {
        }
    }
</script>
