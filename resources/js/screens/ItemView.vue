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
        <div
            class="container w-100 d-flex flex-column"
            v-else
            v-for="item in todos"
            :key="item.id"
        >
            <div
                class="container w-100 d-flex align-items-center justify-content-between bg-primary rounded py-2 px-3 my-2"
            >
                <div class="w-50 d-flex align-items-center">
                    <input type="checkbox" class="form-input" />
                    <h4 class="m-0 px-3">{{ item.title }}</h4>
                </div>
                <div class="w-25 d-flex justify-content-end">
                    <button class="btn btn-text"><h2 class="m-0">⋮</h2></button>
                </div>
            </div>
        </div>
        <div class="container w-100 fixed-bottom mb-4">
            <div
                class="container rounded bg-secondary w-100 d-flex justify-content-start py-3"
            >
                <form class="w-100 d-flex align-items-center m-0 p-0 container">
                    <i class="fa-regular fa-circle white me-2"></i>
                    <input
                        type="text"
                        class="form-control w-100"
                        v-model="newTodo"
                        placeholder="Add new to do"
                    />
                    <button
                        class="btn btn-dark ms-2"
                        @click.prevent="handleSubmit"
                    >
                        <i class="fa-solid fa-add"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import notification from "../notification";
export default {
    name: "itemView",
    data() {
        return {
            todos: [],
            emptyReturn: "Fetching...",
            loaded: true,
            listName: "",
        };
    },
    methods: {
        getToDos() {
            axios
                .get(`/api/todos/${this.$route.params.listId}`)
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
        getListName() {
            axios
                .get(`/api/lists/${this.$route.params.listId}`)
                .then((response) => {
                    console.log(response.data.data.title);
                    this.listName = response.data.data.title;
                })
                .catch(console.error());
        },
        handleSubmit() {
            if (this.newTodo.length === 0) {
                notification("Please enter a title for your to do!", "#ffc107");
                return;
            }
            let toDoItem = {
                title: this.newTodo,
                note: "",
                list_id: this.$route.params.listId,
                is_completed: 0,
            };
            axios
                .post(`/api/items`, { data: toDoItem })
                .then((response) => {
                    notification(response.data.data, "#28a745");
                    this.getToDos();
                })
                .catch((error) => {
                    notification(error, "#dc3545");
                });
        },
    },
    mounted() {
        this.getToDos();
        this.getListName();
    },
};
</script>

<style lang="scss" scoped>
.link {
    text-decoration: none;
}
.white {
    color: white;
}
</style>
