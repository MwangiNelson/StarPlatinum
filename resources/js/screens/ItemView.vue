<template>
    <div>
        <div class="container" v-for="item in todos" :key="item.id">
            <p>{{ item }}</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "itemView",
    data() {
        return {
            todos: [],
        };
    },
    props: {
        listId: Number,
    },
    methods: {
        getToDos(id) {
            axios
                .get(`/api/todos/1`)
                .then((response) => {
                    this.todos = response.data.data;
                })
                .catch(console.error());
        },
    },
    mounted() {
        this.getToDos(this.listId);
    },
};
</script>

<style lang="scss" scoped></style>
