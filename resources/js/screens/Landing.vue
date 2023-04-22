<template>
    <div class="w-100">
        <!--   The v-if method is an inbuilt vue method for conditional renders -->
        <!-- It is using the 'visible' boolean variable to show the Add NewList module -->
        <div class="w-100" v-if="visible">
            <!-- The new list ,module is taking a prop that's the 'visible' variable mentioned above -->
            <!-- This is to enable toggle view syntax using it's button -->
            <!-- The parameters for the toggle view mathod are also taken -->
            <!-- More info on it's vue file -->
            <NewList
                :visibleProp="visible"
                @update:visibleMethod="visible = $event"
                @listUpdated="getLists"
            />
        </div>
        <div class="w-100 my-4">
            <div class="header w-100 d-flex justify-content-between">
                <div class="lists-title w-50">
                    <h2>MY LISTS</h2>
                </div>
                <div class="w-25 d-flex justify-content-end">
                    <!-- This button toggles the 'visible' variable to enable view of the new item module-->
                    <button class="btn btn-primary" @click="visible = !visible">
                        <i class="fa-solid fa-plus"></i>
                        NEW LIST
                    </button>
                </div>
            </div>
            <hr />
            <div class="lists w-100">
                <!-- This is a list display for all the lists categories -->
                <!-- It iterates through the data using the v-for method
                     that has been parsed in the cardDetails variable by the API call below 
                     to show an instance of the Card component inflated with their respective data per
                    iteration-->
                <div
                    class="w-100"
                    v-for="card in cardDetails"
                    :key="cardDetails.id"
                >
                    <!-- The prop card details are passd as prop values -->
                    <!-- More info on Cards.vue -->
                    <Cards
                        :title="card.title"
                        :date="card.created_at"
                        :listId="card.id"
                        @listDeleted="getLists"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Importing the card component
import Cards from "../components/Cards.vue";

// Importing the NewList compnent
import NewList from "../modules/NewList.vue";

// Import axios for API calls handling
import axios from "axios";
export default {
    name: "Lists",
    // These are the imported components for render
    components: {
        Cards,
        NewList,
    },
    methods: {
        getLists() {
            axios
                .get("/api/lists")
                .then((response) => {
                    this.cardDetails = response.data.data;
                })
                .catch(console.error());
        },
    },
    // Initialising variable data that's being computed an all 😂😂
    data() {
        return {
            visible: false,
            cardDetails: [],
        };
    },

    // making API calls
    mounted() {
        // getting and storing the cardDetails data in the cardDetails variable (psst.it's an array of objects)
        // It comes with error handling
        this.getLists();
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
