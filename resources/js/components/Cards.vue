<template>
    <div class="list-card w-100" @click.stop="showToDo(listId)">
        <div class="title d-flex justify-content-between">
            <h2>{{ title }}</h2>
            <button class="btn btn-outline-secondary" @click.stop="editPrompt">
                <i class="fa-solid fa-pen"></i>
            </button>
        </div>
        <p>{{ itemCount }} items</p>
        <div class="w-100 d-flex justify-content-between align-items-end">
            <div class="w-75 d-flex align-items-start flex-column">
                <p class="m-0">Created on : {{ getDate(date) }}</p>
                <p class="my-1">Updated on: {{ getDate(date_update) }}</p>
            </div>
            <button class="btn btn-outline-danger" @click.stop="deleteList">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import axios from "axios";
//notificaation library
import notification from "../notification";

//exports
export default {
    data() {
        return {
            itemCount: "",
        };
    },
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

        showToDo(listId) {
            this.$router.push("/todos/" + listId);
        },
        editPrompt() {
            alert("Sorry,still working on this");
        },
        getItemsCount() {
            axios
                .get(`/api/todos/${this.listId}`)
                .then((res) => {
                    this.itemCount = res.data.data.length;
                })
                .catch((err) => console.error());
        },
    },
    mounted() {
        this.getItemsCount();
    },
};
</script>

<style lang="scss" scoped>
.list-card {
    display: flex;
    flex-direction: column;
    padding: 1em;
    border-radius: 5px;
    background-color: #333;
    color: white !important;
    min-height: 15vh;
}
.title h2 {
    text-transform: capitalize;
}
</style>
