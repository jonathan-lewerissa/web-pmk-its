<template>
    <form action="" @submit.prevent="sendPresensi">
        <div class="form-group">
            <input type="text" placeholder="NRP Baru" v-model='nrp'>
        </div>
        <h3>{{ count }}</h3>
    </form>
</template>

<script>
    export default {
        props: ['counter'],
        data() {
            return {
                event_token: this.$route.params.id,
                nrp: '',
                count: this.counter,
            }
        },
        methods: {
            sendPresensi: function() {
                axios
                .post('/api/presensi',{
                    event_token: this.event_token,
                    nrp: this.nrp,
                })
                .then(res => {
                    this.count = res.data.count;
                    Swal.fire({
                        type: 'success',
                        title: 'Success!',
                        text: 'Hi! Have a wonderful day with Jesus!',
                        timer: 3000
                    })
                })
                .catch(err => {
                    if(err.response.status === 500){
                        if(err.response.data.errorInfo[1] === 1062)
                        Swal.fire({
                            type: 'error',
                            title: 'Oopsie!',
                            text: 'You have been recorded before!',
                            timer: 3000
                        })
                    } 
                    else {
                        console.error(err.response);
                    }
                })
                .then(()=>{
                    this.nrp = ''
                })
            }
        }
    }
</script>
