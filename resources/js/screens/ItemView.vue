<template>
    <!-- This is the view the user will see after clicking a list card -->
    <div
        class="container w-100 d-flex flex-column align-items-center justify-content-between my-4"
    >
        <div class="w-100 d-flex justify-content-between align-items-center">
            <div class="w-50 d-flex">
                <ol
                    class="breadcrumb d-flex justify-content-start align-items-center w-100 m-0"
                >
                    <li class="breadcrumb-item active">
                        <!-- A back route - goes back to the home page -->
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
                        <!-- Displays the list name -->
                        <h3 class="m-0 text-uppercase px-3">{{ listName }}</h3>
                    </li>
                </ol>
            </div>
            <div class="w-25 d-flex justify-content-end">
                <!-- This is the BIG RED button push at your own peril😂😂 -->
                <!-- It deletes all the to-dos under this list -->
                <button class="btn btn-danger" @click="clearList">
                    <i class="fa-solid fa-trash pe-2"></i>
                    CLEAR LIST
                </button>
            </div>
        </div>

        <hr class="w-100" />

        <!-- This is a conditional render, to utput different info when:loading,no data and when data is recieved -->
        <div class="w-100 d-flex" v-if="loaded">
            <span class="w-100 alert alert-secondary m-0 text-center">
                {{ emptyReturn }}
            </span>
        </div>
        <!-- If there are items in the list, they'll be displayed here -->
        <!-- Using vue's iterating loader.... -->
        <div
            class="container w-100 d-flex flex-column"
            v-else
            v-for="item in todos"
            :key="item.id"
        >
            <!-- To do item card -->
            <div
                :class="`container d-flex align-items-center justify-content-between ${
                    item.is_completed ? 'bg-success' : 'bg-primary'
                } rounded py-2 px-3 my-2`"
            >
                <div class="w-50 d-flex align-items-center">
                    <input
                        type="checkbox"
                        class="form-input"
                        v-model="item.is_completed"
                    />
                    <h4 class="m-0 px-3">{{ item.title }}</h4>
                </div>
                <div class="w-25 d-flex justify-content-end">
                    <button class="btn btn-text"><h2 class="m-0">⋮</h2></button>
                </div>
            </div>
        </div>

        <!-- This is the adding a new item module  -->
        <div class="container w-100 fixed-bottom mb-4">
            <div
                class="container rounded bg-secondary w-100 d-flex justify-content-start py-3"
            >
                <form class="w-100 d-flex align-items-center m-0 p-0 container">
                    <i class="fa-regular fa-circle white me-2"></i>

                    <!-- Vue binding the newToDo varible to the input -->
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
            newTodo: "",
        };
    },
    methods: {
        // makes the api call to get the to do list data
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
                note: "note",
                is_completed: 0,
                list_id: this.$route.params.listId,
            };
            axios
                .post(`/api/items`, toDoItem)
                .then((response) => {
                    notification(response.data.data, "#28a745");
                    this.getToDos();
                })
                .catch((error) => {
                    notification(error, "#dc3545");
                });
        },
        clearList() {
            axios
                .delete(`/api/clear/${this.$route.params.listId}`)
                .then((response) => {
                    notification(response.data.data, "#28a745");
                    this.todos = [];
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
