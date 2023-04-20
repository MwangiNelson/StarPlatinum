<template>
    <div class="w-100">
        <div class="w-100" v-if="visible" >
            <NewList :visibleProp="visible" @update:visibleMethod="visible = $event"/>
        </div>
        <div class="w-100 my-4">
            <div class="header w-100 d-flex justify-content-between">
                <div class="lists-title w-50">
                    <h2>MY LISTS</h2>
                </div>
                <div class="w-25 d-flex justify-content-end">
                    <button
                        class="btn btn-primary"
                        @click="visible = !visible"
                        
                    >
                        <i class="fa-solid fa-plus"></i>
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
                    <Cards :title="card.title" :date="card.created_at" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Cards from "../components/Cards.vue";
import NewList from "../modules/NewList.vue";
import axios from "axios";
export default {
    name: "Lists",
    components: {
        Cards,
        NewList,
    },
    data() {
        return {
            visible: false,
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
    computed: {
        toggleVisibility() {
            return this.visible;
        },
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
