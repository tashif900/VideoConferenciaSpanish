<template>
    <div>
        <transition name="slide-fade" mode="out-in">
            <router-view :key="$route.fullPath"></router-view>
        </transition>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                this.$store.dispatch("getCategories").catch(error =>{console.log(error);});
                //console.log(this.$store.state.categories, 'app component');
            }
        },
        computed:{

        }
    }
</script>

<style scoped>

</style>