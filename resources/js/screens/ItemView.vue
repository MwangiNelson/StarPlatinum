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
        <div
            class="content-area w-100 d-flex justify-content-start align-items-start position-relative"
        >
            <!-- This is a conditional render, to utput different info when:loading,no data and when data is recieved -->
            <div class="w-100 d-flex" v-if="loaded">
                <span class="w-100 alert alert-secondary m-0 text-center">
                    {{ emptyReturn }}
                </span>
            </div>

            <!-- This div has conditional classnames depending on whether the user has selected an item to view -->
            <div
                :class="`${
                    selected_item ? 'w-75' : 'w-100'
                } d-flex flex-column`"
                v-else
            >
                <!-- If there are items in the list, they'll be displayed here -->
                <!-- Using vue's iterating loader.... -->

                <div
                    class="container w-100 d-flex flex-column"
                    v-for="item in todos"
                    :key="item.id"
                >
                    <!-- To do item card -->
                    <!-- On click, the side panel with it's respective details opens up -->
                    <!-- The background color is also dependent on the completion status of the task -->
                    <div
                        :class="`container d-flex align-items-center justify-content-between ${
                            item.is_completed ? 'bg-success' : 'bg-primary'
                        } rounded py-2 px-3 my-2`"
                        @click="openPanel(item.id)"
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
                            <button
                                class="btn btn-text"
                                @click="openPanel(item.id)"
                            >
                                <h2 class="m-0">⋮</h2>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- To do side panel -->
            <div
                class="w-25 d-flex flex-column justify-content-start bg-dark rounded m-2 p-2 position-absolute top-0 end-0"
                v-if="selected_item"
            >
                <!-- This component overlays the rest propting the user to confirm whether they want to delete the task -->
                <!-- Its a conditional render ergo the v-if -->
                <div
                    v-if="prompted"
                    class="position-absolute top-0 w-100 m-0 p-0 h-100 rounded blur d-flex justify-content-center align-items-center"
                >
                    <div
                        class="d-flex bg-dark shadow-lg container rounded flex-column w-75 justify-content-center align-items-center"
                    >
                        <p class="m-0 fs-4 text-center text-light">
                            Do you want to delete <br />
                            ' {{ edit_item.title }} '?
                        </p>
                        <div class="w-100 d-flex my-2 justify-content-center">
                            <!-- If they wanna cancel the operation, they can do it here -->
                            <button
                                class="btn btn-outline-primary mx-2"
                                @click="prompted = !prompted"
                            >
                                Cancel
                            </button>
                            <!-- Or go on ahead and delete the task from the db -->
                            <button
                                class="btn btn-outline-danger mx-2"
                                @click.prevent="deleteToDo"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="w-100 rounded bg-dark d-flex justify-content-between align-items-center shadow-lg"
                >
                    <!-- Tis is now the selected item view -->
                    <!-- It's purpose is editing -->
                    <div class="w-100 d-flex align-items-center">
                        <i class="fa-solid fa-pen mx-3 text-light"></i>
                        <!-- This is an editable input field that uses the original title as the holding value that can be edited -->
                        <input
                            type="text"
                            class="form-control fs-3 bg-dark border p-0 m-0 border-dark text-light shadow-none"
                            v-model="edit_item.title"
                            id=""
                        />
                    </div>
                    <!-- Toggles the editing panel{ie.closes it} -->
                    <button
                        class="btn btn-dark"
                        @click="selected_item = !selected_item"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="w-50 my-2">
                    <!-- A conditional span thatshows the completion status -->
                    <span
                        :class="`w-100 rounded p-1 ${
                            edit_item.is_completed
                                ? 'bg-success text-light'
                                : 'bg-primary'
                        }`"
                    >
                        {{
                            edit_item.is_completed
                                ? "Completed"
                                : "Task not yet done"
                        }}
                    </span>
                </div>

                <div
                    class="w-100 bg-light rounded my-2 shadow-lg d-flex flex-column p-2"
                >
                    <h4 class="text-dark">Item note</h4>
                    <div class="w-100 d-flex">
                        <form class="w-100 m-0">
                            <!-- An editable note that couples the task -->
                            <textarea
                                class="w-100 form-control mb-2"
                                rows="4"
                                v-model="edit_item.note"
                            ></textarea>
                            <div class="w-100 d-flex">
                                <!-- Updates the data in the db -->
                                <button
                                    class="btn btn-warning w-50 m-2"
                                    @click.prevent="updateToDo"
                                >
                                    <i class="fa-solid fa-pen pe-2"></i>
                                    Update Item
                                </button>

                                <!-- Prompts the deletion of the item -->
                                <button
                                    class="btn btn-danger w-50 m-2"
                                    @click.prevent="prompted = !prompted"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                    Delete Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- This is the adding a new task item creation module  -->
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
                    <!-- Submits the new to do task -->
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
            selected_item: false,
            edit_item: [],
            prompted: false,
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
        // gets the name of the list that has been selected for rendering
        getListName() {
            axios
                .get(`/api/lists/${this.$route.params.listId}`)
                .then((response) => {
                    console.log(response.data.data.title);
                    this.listName = response.data.data.title;
                })
                .catch(console.error());
        },
        // Submits a new task to be saved with empty validation
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
                .post(`/api/task`, toDoItem)
                .then((response) => {
                    notification(response.data.data, "#28a745");
                    this.getToDos();
                })
                .catch((error) => {
                    notification(error, "#dc3545");
                });
        },

        // deletes all tasks in the list
        clearList() {
            axios
                .delete(`/api/task/clear/${this.$route.params.listId}`)
                .then((response) => {
                    notification(response.data.data, "#28a745");
                    this.todos = [];
                    this.getToDos();
                })
                .catch((error) => {
                    notification(error, "#dc3545");
                });
        },

        // Opens the side panel appending the selected item's data
        openPanel(id) {
            this.selected_item = true;
            this.edit_item = this.todos.find((item) => item.id === id);
            this.noteText = this.edit_item.note;
        },

        // Updates the edited item
        updateToDo() {
            axios
                .put(`/api/task/edit/${this.edit_item.id}`, this.edit_item)
                .then((res) => {
                    notification(res.data.data, "#28a745");
                    this.getToDos();
                })
                .catch((error) => {
                    notification(error, "#dc3545");
                });
        },

        // Deletes the selected to do item
        deleteToDo() {
            axios
                .delete(`/api/task/delete/${this.edit_item.id}`)
                .then((res) => {
                    notification(res.data.data, "#28a745");
                    this.selected_item = false;
                    this.prompted = false;
                    this.getToDos();
                })
                .catch((error) => {
                    notification(error, "#dc3545");
                });
        },
    },

    // Calling on load functions
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
.blur {
    backdrop-filter: blur(3px);
}
</style>
