<template>
    <div>

        <div class="print-form">
            <div class="buttons is-right">
                <b-button
                    class="mt-5"
                    label="Print"
                    @click="print"
                    icon-right="printer"
                    type="is-primary"
                ></b-button>
            </div>

            <div class="print-body">
                <div class="table-title">{{ data.seminar_title }}</div>

                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Specialization</th>
                        <th>No of Seminars</th>
                    </tr>
                    <tr v-for="(item, index) in data.recommended_teacher_lists" :key="index">
                        <td>{{ item.lname }}, {{ item.fname }} {{ item.mname }}</td>
                        <td>{{ item.sex }}</td>
                        <td>{{ item.specialization }}</td>
                        <td style="text-align: center;">{{ item.no_seminars }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</template>


<script>

export default{
    props: ['propData'],
    data(){
        return{
            data: {},
        }
    },

     methods: {
         initData(){
            this.data = JSON.parse(this.propData)
             console.log(this.data)
         },

         print(){
             window.print()
         }
     },

    mounted() {
        this.initData()
    }


}
</script>

<style scoped>
table{
    margin: auto;
}
.table-title{
    font-weight: bold;
    margin: 15px auto;
    text-align: center;
    font-size: 1.2em;
}
</style>
