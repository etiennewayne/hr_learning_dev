<template>
    <div>

        <div class="columns is-centered mt-5">
            <div class="column is-6">
                <div class="box">
                    <div class="box-text">New Seminar / Trainings</div>

                    <div>
                        <b-field>
                            <b-input type="textarea" v-model="desc">
                            </b-input>
                        </b-field>

                        <b-field class="file is-primary" :class="{'has-name': !!file}">
                            <b-upload v-model="file" class="file-label">
                                <span class="file-cta">
                                    <b-icon class="file-icon" icon="upload"></b-icon>
                                    <span class="file-label">Click to upload</span>
                                </span>
                                <span class="file-name" v-if="file">
                                    {{ file.name }}
                                </span>
                            </b-upload>
                        </b-field>

                        <div class="buttons is-right">
                            <b-button type="is-primary is-outlined" label="Post Training" @click="submit"></b-button>
                        </div>
                        
                    </div>
                </div>

                <div class="box box-post" v-for="(seminar, index) in serminars" :key="index">
                    <div class="box-post-heading">
                        <div class="posted-text">Posted: {{ seminar.date_posted }}</div>
                        <div class="post-action">
                            <b-dropdown aria-role="list">
                                <template #trigger="{ active }">
                                    <b-button
                                        label="..."
                                        class="is-small"
                                        type="is-light"
                                        :icon-right="active ? 'menu-up' : 'menu-down'" />
                                </template>


                                <b-dropdown-item aria-role="listitem" @click="deletePost(seminar.seminar_post_id)">Delete</b-dropdown-item>
                                
                            </b-dropdown>
                        </div>
                    </div>
                    <div class="post-desc">
                        {{ seminar.description }}
                    </div>
                    <div class="post-img-container">
                        <img :src="`/storage/seminars/${seminar.img_path}`" class="post-img" />
                    </div>
                </div>


            </div> <!-- col -->
        </div>
    </div>
</template>

<script>

export default{
    data(){
        return {
            file: null,
            desc: '',


            serminars: [],
        }
    },

    methods: {

        initData(){

        },

        clear(){
            this.fil = null;
            this.desc = '';
        },

        loadSeminars(){
            axios.get('/hrld/get-seminars').then(res=>{
                this.serminars = res.data
            }).catch(err=>{

            })
        },

        submit(){

            let formData = new FormData();
            formData.append('desc', this.desc);
            formData.append('file', this.file);

            axios.post('/hrld/seminar-posts-store', formData).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: "Posted!",
                        message: 'Seminar successfully posted.',
                        type: 'is-success',
                        onConfirm: ()=>  {
                            this.loadSeminars()
                        }
                    });
                }
            }).catch(err=>{

            })
        },

        deletePost(seminarPostId){
            axios.delete('/hrld/seminar-posts/' + seminarPostId).then(res=>{
                if(res.data.status === 'deleted'){
                    this.$buefy.toast.open({
                        message: 'Post deleted successfully.',
                        type: 'is-success'
                    })
                    this.loadSeminars()
                }
            })
        }
    },

    mounted(){
        this.loadSeminars()
    }
}
</script>

<style scoped>
    .box-post{
        margin: 10px 0;
        border-top: 0px;

    }

    .post-img-container{
        height: 300px;
        overflow: hidden;
        display: flex;
        justify-content: center;
    }
    .posted-text{
        font-weight: bold;
        font-style: .8em;
        color: gray;
    }
    .post-img{
        height: 400px;
    }

    .box-post-heading{
        display: flex;
        padding: 10px;
    }
    .post-action{
        margin-left: auto;
    }
    
    .post-desc{
        border-top: 1px solid gray;
        margin: 10px;
        padding: 10px 0
    }
</style>
