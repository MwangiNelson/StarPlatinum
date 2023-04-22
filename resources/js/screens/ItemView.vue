<template>
    <div
        class="container w-100 d-flex flex-column align-items-center justify-content-between my-4"
    >
        <div class="w-100 d-flex justify-content-between align-items-center">
            <div class="w-50 d-flex">
                <ol
                    class="breadcrumb d-flex justify-content-start align-items-center w-100 m-0"
                >
                    <li class="breadcrumb-item active">
                        <router-link to="/" class="link">
                            <button
                                class="btn btn-light d-flex align-items-center"
                            >
                                <i class="fa-solid fa-arrow-left"></i>
                                <h3 class="ps-3 m-0">MY LISTS</h3>
                            </button>
                        </router-link>
                    </li>
                    <li
                        class="d-flex align-items-center breadcrumb-item active"
                    >
                        <h3 class="m-0 text-uppercase px-3">{{ listName }}</h3>
                    </li>
                </ol>
            </div>
            <div class="w-25 d-flex justify-content-end">
                <button class="btn btn-danger">
                    <i class="fa-solid fa-trash"></i>
                    DELETE LIST
                </button>
            </div>
        </div>

        <hr class="w-100" />

        <div class="w-100 d-flex" v-if="loaded">
            <span class="w-100 alert alert-secondary m-0 text-center">
                {{ emptyReturn }}
            </span>
        </div>
        <div class="container" v-else v-for="item in todos" :key="item.id">
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
            emptyReturn: "",
            loaded: true,
            listName: "",
        };
    },
    props: {
        listId: Number,
    },
    methods: {
        getToDos(id) {
            axios
                .get(`/api/todos/${id}`)
                .then((response) => {
                    let listData = response.data.data;
                    if (listData.length === 0) {
                        this.emptyReturn = "This list has no items yet";
                    } else {
                        this.loaded = false;
                        this.todos = listData;
                    }
                })
                .catch(console.error());
        },
        getListName(id) {
            axios
                .get(`/api/lists/${id}`)
                .then((response) => {
                    console.log(response.data.data.title);
                    this.listName = response.data.data.title;
                })
                .catch(console.error());
        },
    },
    mounted() {
        this.getToDos(this.listId);
        this.getListName(this.listId);
    },
};
</script>

<style lang="scss" scoped>
.link {
    text-decoration: none;
}
</style>
