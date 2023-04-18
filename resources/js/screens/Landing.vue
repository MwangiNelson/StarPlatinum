<template>
    <div class="w-100 my-4">
        <div class="header w-100 d-flex justify-content-between">
            <div class="lists-title w-50">
                <h2>MY LISTS</h2>
            </div>
            <div class="w-25 d-flex justify-content-end">
                <button class="btn btn-primary">
                    <i class="fa-solid fa-add"></i>
                    NEW LIST
                </button>
            </div>
        </div>
        <hr />
        <div class="lists w-100">
            <div
                class="w-100"
                v-for="card in cardDetails"
                :key="cardDetails.id"
            >
                <Cards
                    :title="card.title"
                    :date="card.created_at"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Cards from "../components/Cards.vue";
import axios from "axios";
export default {
    name: "Lists",
    components: {
        Cards,
    },
    data() {
        return {
            cardDetails: [],
        };
    },
    mounted() {
        axios
            .get("/api/lists")
            .then((response) => {
                this.cardDetails = response.data.data;
                console.log(this.cardDetails);
            })
            .catch(console.error());
    },
};
</script>

<style lang="scss" scoped>
.lists {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1em;
}
</style>
