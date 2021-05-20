<template>
    
</template>

<script>
    export default {
        created() {
            this.$store.dispatch("destroyToken").then(response =>{
                this.$router.push({name: "home"})
            }).catch(error =>{
                console.log(error.response, "Error")
                this.$router.push({name: "home"})
            });
        }
    }
</script>

<style scoped>

</style>