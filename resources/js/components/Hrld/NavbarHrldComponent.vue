<template>
    <div>
        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <img
                        src="/img/deped-logo.png"
                        alt="Lightweight UI components for Vue.js based on Bulma"
                    >
                </b-navbar-item>
            </template>
            <template #start>
                <b-navbar-item href="/hrld/home">
                    Home
                </b-navbar-item>
                <b-navbar-item href="/hrld/seminar-posts">
                    Seminars
                </b-navbar-item>
                <b-navbar-dropdown label="Info">
                    <b-navbar-item href="#">
                        About
                    </b-navbar-item>
                    <b-navbar-item href="#">
                        Contact
                    </b-navbar-item>
                </b-navbar-dropdown>
            </template>

            <template #end>
                <b-navbar-item class="navbar-notif">
                    <b-icon icon="earth">
                    </b-icon>
                    <div class="notif-counter">
                        4
                    </div>
                </b-navbar-item>

                <b-navbar-item tag="div">
                    <div class="buttons">
                        <a class="button is-outlined is-danger" @click="logout">
                            Log out
                        </a>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>

    </div>


</template>

<script>
export default {
    data(){
        return{

        }
    },
    methods: {
        logout(){
            axios.post('/logout').then(()=>{
                window.location = '/';
            })
        },

        loadUser(){
            axios.get('/load-user').then(res=>{
                this.user = res.data;
            })
        }
    },

    mounted(){
        this.loadUser();
    },

    computed: {
        userRole(){
            return this.user.role.toUpperCase();
        }
    }
}
</script>

<style scoped>
    .navbar-notif{
        position: relative;
    }
    .notif-counter{
        background: red;
        padding: 5px;
        font-weight: bold;
        color:white;
        border-radius: 20px;
        font-size: .6em;
        position: absolute;
        top: 10px;
        left: 20px;
    }

    @media screen and (max-width: 1024px) {
        .notif-counter{
            position: absolute;
            top: 10px;
            left: 30px;

        }
    }

</style>
