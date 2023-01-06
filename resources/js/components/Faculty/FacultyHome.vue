<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="box box-post" v-for="(seminar, index) in serminars" :key="index">
                        <div class="box-post-heading">
                            <div class="posted-text">Posted: {{ seminar.date_posted }}</div>
                            <div class="post-action">
                             
                            </div>
                        </div>
                        <div class="post-desc">
                            {{ seminar.description }}
                        </div>
                        <div class="post-img-container">
                            <img :src="`/storage/seminars/${seminar.img_path}`" class="post-img" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</template>

<script>
export default{

    data(){
        return{
            serminars:[],

        }
    },

    methods: {
        loadSeminars(){
            axios.get('/hrld/get-seminars').then(res=>{
                this.serminars = res.data
            }).catch(err=>{

            })
        },
    },

    mounted(){
        this.loadSeminars()
    }
}

</script>

<style scoped>
    .home-hero{
        height: 100vh;
    }
</style>