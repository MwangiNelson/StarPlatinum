<template>
    <div
        class="wrapper container position-fixed d-flex justify-content-center align-items-center"
    >
        <div class="w-50 d-flex container bg-dark rounded flex-column p-3">
            <div
                class="w-100 d-flex justify-content-between align-items-end border-bottom-secondary"
            >
                <h1 class="text-secondary m-0 p-0">ADD NEW LIST</h1>
                <button
                    class="btn btn-outline-danger"
                    @click="toggleVisibility"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <hr class="seperator w-100" />
            <form class="">
                <div
                    class="form-group mb-3 d-flex flex-column justify-content-start"
                >
                    <div class="w-100 d-flex justify-content-between">
                        <input
                            type="text"
                            v-model="title"
                            class="form-control w-75"
                            placeholder="List title:"
                        />
                        <button class="btn btn-primary" @click="handleSubmit">
                            ADD ITEM
                            <i class="fa-solid fa-paper-plane ps-3"></i>
                        </button>
                    </div>

                    <small class="form-text text-muted text-secondary"
                        >Please enter your list title here</small
                    >
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";
export default {
    data() {
        return {
            title: "",
        };
    },
    props: {
        visibleProp: Boolean,
    },
    methods: {
        toggleVisibility() {
            this.$emit("update:visibleMethod", !this.visibleProp);
        },
        handleSubmit() {
            console.log(this.title);
            if (this.title === "") {
                Toastify({
                    text: "Please enter a title for your list!  ",
                    duration: 2000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // bottom-right, bottom-left, top-right, top-left
                    position: "center", // left, right, center
                    backgroundColor: "#ffc107",
                    stopOnFocus: false, // Prevents dismissing of toast on hover
                }).showToast();
                return;
            }

            axios
                .post("/api/lists", { title: this.title })
                .then((response) => {
                    console.log(response);
                })
                .catch(console.error());
        },
    },
};
</script>

<style lang="scss" scoped>
.seperator {
    color: #fff;
}
.wrapper {
    width: 100vw;
    height: 100vh;
    backdrop-filter: blur(3px);
}
</style>
