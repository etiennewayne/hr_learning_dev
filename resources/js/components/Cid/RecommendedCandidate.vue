<template>
    <div>
        <div class="filter-container">
            <div>
                <b-field expanded>
                    <b-input type="text" expanded
                        placeholder="Search Lastname"
                        v-model="search.lname"></b-input>
                    <b-input type="text" expanded
                        placeholder="Specialization"
                        v-model="search.specialization"></b-input>
                    <p class="control">
                        <b-button class="expanded" type="is-primary" label="..." @click="generateList"></b-button>
                    </p>
                </b-field>
            </div>
        </div>


        <div class="print-area">
            <div>
                <div>List of Recommended Candidate</div>
                <table class="table is-fullwidth is-narrow">
                    <tr>
                        <td>Name</td>
                        <td>Sex</td>
                        <td>Civil Status</td>
                        <td>Specialization/Skill</td>
                        <td>No of. Seminars</td>
                    </tr>
                    <tr v-for="(item, index) in data" :key="index">
                        <td>{{  item.lname }}, {{  item.fname }} {{ item.mname }} {{  item.suffix }}</td>
                        <td>{{ item.sex }}</td>
                        <td>{{ item.civil_status }}</td>
                        <td>{{ item.specialization }}</td>
                        <td>{{ item.no_seminars }}</td>
                        
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

export default{
    data(){
        return {
            data: [],

            search: {
                lname: '',
                specialization: '',
            }
        }
    },

    methods: {
        generateList(){
            const params = [
                `lname=${this.search.lname}`,
                `specialization=${this.search.specialization}`,
            ].join('&')

            axios.get(`/generate-list?${params}`).then(res=>{
                this.data = res.data
            }).catch(err=>{
            
            })
        }
    },

    mounted(){

    }
}
</script>

<style scoped>


    @media print {
        /*.myDivToPrint {*/
        /*    background-color: white;*/
        /*    height: 100%;*/
        /*    width: 100%;*/
        /*    position: fixed;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*    margin: 0;*/
        /*    padding: 15px;*/
        /*    font-size: 14px;*/
        /*    line-height: 18px;*/
        /*}*/

        .myDivToPrint{
            margin: 0;
            color: #000;
            background-color: #fff;
            font-size: 14px;
            height: 100%;

        }
        .nprint{
            display: none;
        }
        header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
            display: none;
        }

        .buttons{
            display: none;
        }


        /* // if print display none elements */
        html body{
            background-color: white;
        }

        .footer-container{
            display: none;
        }

        .filter-container{
           display: none;
        }

    }

    .print-area{
        max-width: 816px;
        margin: 30px auto 0;
        background: white;
        margin: auto;
    }
    .filter-container{
        max-width: 816px;
        margin: 30px auto;
        background-color: white;
        padding: 25px;
    }

    .print-area{
        padding: 20px;
    }


</style>