<template>
    <div>
        <div class="w-container">
            <div class="pending-text">
                ACCOUNT IS PENDING.
            </div>
            <div class="subtitle">
                Please verify the account first.
            </div>
        </div>
    </div>
</template>

<script>

export default{
    data(){
        return {
        }
    },

    methods: {

    },

    mounted(){

    }
}
</script>

<style scoped>
    .w-container{
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .pending-text{
        font-weight: bold;
        font-size: 1.8em;
    }

</style>