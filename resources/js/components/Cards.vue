<template>
    <div class="list-card w-100">
        <div class="title d-flex justify-content-between">
            <h2>{{ title }}</h2>
            <button class="btn btn-outline-secondary">
                <i class="fa-solid fa-pen"></i>
            </button>
        </div>
        <p>40 items</p>
        <div class="w-100 d-flex justify-content-between align-items-end">
            <div class="w-75 d-flex align-items-end">
                <p class="m-0">{{ date }}</p>
            </div>
            <button class="btn btn-outline-danger">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    props: {
        title: String,
        date: String,
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
