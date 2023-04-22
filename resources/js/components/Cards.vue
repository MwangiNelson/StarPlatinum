<template>
    <div class="list-card w-100" @click="showToDo(listId)">
        <div class="title d-flex justify-content-between">
            <h2>{{ title }}</h2>
            <button class="btn btn-outline-secondary">
                <i class="fa-solid fa-pen"></i>
            </button>
        </div>
        <p>40 items</p>
        <div class="w-100 d-flex justify-content-between align-items-end">
            <div class="w-75 d-flex align-items-end">
                <p class="m-0">Created on : {{ getDate(date) }}</p>
            </div>
            <button class="btn btn-outline-danger" @click="deleteList">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import axios from "axios";
//notificaation library
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

//exports
export default {
    props: {
        title: String,
        date: String,
        listId: Number,
    },
    methods: {
        //delete List item API call method triggered by the button in the card above
        deleteList() {
            axios
                .delete(`/api/lists/${this.listId}/delete`)
                .then((response) => {
                    Toastify({
                        text: "List deletd successfully!  ",
                        duration: 2500,
                        newWindow: true,
                        close: true,
                        gravity: "top", // bottom-right, bottom-left, top-right, top-left
                        position: "center", // left, right, center
                        backgroundColor: "#dc3545",
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                    }).showToast();
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
