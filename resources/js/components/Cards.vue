<template>
    <!-- This is the list item card view on the landing page -->
    <!-- I have appended a method to the card such that when the user clicks, they are redirected to the to dos item view -->
    <div
        class="list-card p-3 d-flex flex-column rounded bg-dark w-100"
        @click.stop="showToDo(listId)"
    >
        <div class="title d-flex justify-content-between">
            <!-- Appending the list title -->
            <h2>{{ title }}</h2>

            <!-- This should prompt the user to make changes on the list -->
            <button class="btn btn-outline-secondary" @click.stop="editPrompt">
                <i class="fa-solid fa-pen"></i>
            </button>
        </div>

        <!-- This shows the number of items in the list -->
        <p>{{ itemCount }} items</p>

        <!-- This is just metadata about the list -->
        <div class="w-100 d-flex justify-content-between align-items-end">
            <div class="w-75 d-flex align-items-start flex-column">
                <p class="m-0">Created on : {{ getDate(date) }}</p>
                <p class="my-1">Updated on: {{ getDate(date_update) }}</p>
            </div>

            <!-- This is the kaboom💣💥💥 button -->
            <button class="btn btn-outline-danger" @click.stop="deleteList">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<script lang="ts">
// API library
import axios from "axios";

//notification library
import notification from "../notification";

//exports
export default {
    data() {
        return {
            itemCount: "",
        };
    },
    // These are the variables that are to be initialised in the parent component
    props: {
        title: String,
        date: String,
        listId: Number,
        date_update: String,
    },
    methods: {
        //delete List item API call method triggered by the button in the card above
        deleteList() {
            axios
                .delete(`/api/lists/${this.listId}/delete`)
                .then((response) => {
                    notification("List deletd successfully!  ", "#dc3545");
                    this.$emit("listDeleted");
                })
                .catch((error) => console.log(error));
        },

        //Simplified the date format that was stored in the databse to yyyy-mm-dd
        getDate(dateProp) {
            const regex = /^(\d{4}-\d{2}-\d{2})/;
            const match = dateProp.match(regex);
            return match[0];
        },

        // Routes the user to the todos view component
        showToDo(listId) {
            this.$router.push("/todos/" + listId);
        },

        // Hmmm,I'm still working on this
        editPrompt() {
            alert("Sorry,still working on this");
        },

        // This method is just for calculating the number of to do items in the list via API call
        getItemsCount() {
            axios
                .get(`/api/todos/${this.listId}`)
                .then((res) => {
                    // I am just getting the number of items returned by the API because it's an array of objects
                    this.itemCount = res.data.data.length;
                })
                .catch((err) => console.error());
        },
    },
    mounted() {
        // This is to call the getItems count method on component render
        this.getItemsCount();
    },
};
</script>

<style lang="scss" scoped>
.list-card {
    color: white !important;
    min-height: 15vh;
}
.title h2 {
    text-transform: capitalize;
}
</style>
